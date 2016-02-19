<?php

function v2_feeds_admin_feeds() {
  $settings_language = mumm_country_get_user_country_language();

  $header = array(
    'identifier' => t('Identifier'),
    'name' => t('Name (or alias)'),
    'type' => t('Type'),
    'actions' => t('Actions'),
  );

  $feed_options = array();
  foreach (v2_feeds_get_feeds($settings_language) as $sfid => $feed) {
    $actions = array(
      '#theme' => 'links',
      '#links' => array(),
      '#attributes' => array(
        'class' => array('links', 'inline'),
      ),
    );

    $actions['#links']['delete'] = array(
      'title' => t('unsubscribe'),
      'href' => sprintf('admin/config/user-interface/wall-of-victories/feeds/unsubscribe/%d', $sfid),
    );

    $feed_options[$sfid] = array(
      'identifier' => $feed->identifier,
      'name' => empty($feed->alias) ? $feed->name : $feed->alias,
      'type' => v2_feeds_feed_types($feed->type),
      'actions' => array('data' => $actions),
    );
  }

  $form['feeds'] = array(
    '#theme' => 'table',
    '#header' => $header,
    '#rows' => $feed_options,
    '#empty' => t('Not subscribed to social feeds.'),
  );
  return $form;
}

function v2_feeds_admin_feed_subscribe($form, &$form_state) {
  $form['#country'] = mumm_country_get_user_country_language();
  $feed_types = v2_feeds_feed_types();

  $form['type'] = array(
    '#type' => 'select',
    '#title' => t('Social feed type'),
    '#options' => $feed_types,
    '#required' => TRUE,
  );

  $form['identifier'] = array(
    '#type' => 'textfield',
    '#title' => t('Identifier'),
    '#description' => t('The screen name for the account you want to add, or a hashtag to search for (e.g. #myHashtag). <br>'
                        .'For Instagram, you need to input the user id of your account that you can retrieve from <a target="_blank" href="http://jelled.com/instagram/lookup-user-id">this link</a>.'),
    '#required' => TRUE,
    '#weight' => 50,
  );

  $form['alias'] = array(
    '#type' => 'textfield',
    '#title' => t('Alias'),
    '#weight' => 100,
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'Subscribe',
    '#weight' => 9999,
  );

  return $form;
}

function v2_feeds_admin_feed_subscribe_submit($form, &$form_state) {
  // Feed object is stored during form validation.
  /** @var SocialFeed $feed */
  global $user;
  $time_now = strtotime("now");
  $record_social_feeds = (object) array(
        'type' => $form_state['values']['type'],
        'identifier' => $form_state['values']['identifier'],
        'since_id' => 0,
        'uid' => $user->uid,
        'created' => $time_now,
        'changed' => 0,
        'channel' => 'official',
        'status' => 1,
  );
  drupal_write_record('social_feeds', $record_social_feeds);
  $record_feed_countries = (object) array(
        'sfid' => $record_social_feeds->sfid,
        'alias' => $form_state['values']['alias'],
        'language' => $user->language,
        'uid' => $user->uid,
        'created' => $time_now,
  );
  drupal_write_record('social_feed_countries', $record_feed_countries);
  drupal_set_message(sprintf('Saved' . ' ' . $form_state['values']['type'] . ' ' . $form_state['values']['identifier']));
  return TRUE;
}

function v2_feeds_admin_feed_unsubscribe_confirm($form, $form_state, $feed) {
  $cancel_path = 'admin/config/user-interface/wall-of-victories/feeds';
  $feed = is_object($feed) ? $feed : v2_feeds_feed_load($feed);
  if (!$feed) {
    drupal_goto($cancel_path);
  }

  $form['#feed'] = $feed;

  $form['sfid'] = array(
    '#type' => 'value',
    '#value' => $feed->sfid,
  );

  return confirm_form(
      $form, t('Are you sure you want to unsubscribe from %feed_identifier?', array('%feed_identifier' => $feed->identifier)), $cancel_path, t('This action cannot be undone.'), t('Unsubscribe'), t('Cancel')
  );
}

function v2_feeds_admin_feed_unsubscribe_confirm_submit($form, $form_state) {
  $feed = $form['#feed'];

  if ($form_state['values']['confirm']) {
    v2_feeds_feed_unsubscribe($feed);
    drupal_set_message('You have unsubscribed from ' . $feed->identifier);
  }

  drupal_goto('admin/config/user-interface/wall-of-victories/feeds');
}

function v2_feeds_admin_wall_item_publish($feed_item, $publish = TRUE) {
  $sfiid = is_object($feed_item) ? $feed_item->sfiid : $feed_item;

  v2_feeds_feed_items_publish_multiple(array($sfiid), $publish);

  // Redirect to another page if redirect destination is set.
  if (isset($_GET['destination'])) {
    drupal_goto($_GET['destination']);
  }
}

function v2_feeds_admin_content($form, &$form_state, $only_published = FALSE) {
  $form['filter'] = v2_feeds_filter_form();
  $form['#submit'][] = 'v2_feeds_filter_form_submit';

  $form['admin'] = v2_feeds_admin_wall_items($only_published);

  return $form;
}

function v2_feeds_admin_wall_items($channel = 'published') {
  $country_code = mumm_country_get_user_country_code();

  $published_channel = 'published' === strtolower($channel);

  if ($published_channel) {
    // Display all published items.
    $feed_query = _v2_feeds_feed_items_query($country_code, TRUE);
  }
  else {
    // List only items from a specified channel, like 'official' or 'third-party'.
    $feed_query = _v2_feeds_feed_items_query($country_code, FALSE);
    $feed_query->condition('f.channel', $channel);
  }

  $feed_query = $feed_query
      ->extend('TableSort')
      ->extend('PagerDefault');

  // Handle sorting
  $headers = array(
    'message' => array(
      'data' => t('Message'),
      'field' => 'i.message',
    ),
    'media' => array(
      'data' => t('Media'),
    ),
    'feed_type' => array(
      'data' => t('Feed type'),
      'field' => 'f.type',
    ),
    'created' => array(
      'data' => t('Post date'),
      'field' => 'i.created',
    ),
    'published' => array(
      'data' => t('Published'),
      'field' => 'ci.created',
    ),
    'actions' => t('Actions'),
  );

  if ($published_channel) {
    $headers['published']['sort'] = 'desc';
  }
  else {
    $headers['created']['sort'] = 'desc';
  }

  $feed_query->orderByHeader($headers);


  // Handle filtering
  v2_feeds_build_admin_filter_query($feed_query);

  $is_filtered = isset($_SESSION['v2_feeds_admin_filter']) && count($_SESSION['v2_feeds_admin_filter']) > 0;


  $res = $feed_query->execute();

  $items = array();
  $destination = drupal_get_destination();
  while ($row = $res->fetch()) {
    //$message = _filter_autop($row->message);
    $message = text_summary($row->message, 'text_plain', 200);

    $media_link = isset($row->media_url) ? l('link', $row->media_url, array('attributes' => array('target' => '_blank'))) : '-';

    $actions = array(
      '#theme' => 'links',
      '#links' => array(),
      '#attributes' => array(
        'class' => array('links', 'inline'),
      ),
    );

    if (empty($row->published)) {
      $actions['#links']['publish'] = array(
        'title' => t('publish'),
        'href' => sprintf('admin/config/user-interface/wall-of-victories/feeds/item/%d/publish', $row->sfiid),
        'query' => $destination,
      );
    }
    else {
      $actions['#links']['unpublish'] = array(
        'title' => t('unpublish'),
        'href' => sprintf('admin/config/user-interface/wall-of-victories/feeds/item/%d/unpublish', $row->sfiid),
        'query' => $destination,
      );
    }

    $items[$row->sfiid] = array(
      'message' => strip_tags($message),
      'media' => $media_link,
      'feed_type' => v2_feeds_feed_types($row->feed_type),
      'created' => format_date($row->created),
      'published' => isset($row->published) ? format_date($row->published) : '-',
      'actions' => array('data' => $actions),
    );
  }

  $form['options'] = array(
    '#type' => 'fieldset',
    '#title' => t('Update options'),
    '#attributes' => array('class' => array('container-inline')),
  );

  $form['options']['operation'] = array(
    '#type' => 'select',
    '#title' => t('Operation'),
    '#title_display' => 'invisible',
    '#default_value' => 'publish',
    '#options' => array(
      'publish' => t('Publish selected content'),
      'unpublish' => t('Unpublish selected content'),
      'delete' => t('Delete selected content'),
    ),
  );

  $form['options']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Update'),
    '#validate' => array('v2_feeds_admin_wall_items_validate'),
    '#submit' => array('v2_feeds_admin_wall_items_submit'),
  );

  $form['fetch_new_contens'] = array(
    '#type' => 'fieldset',
    '#title' => t('Fetch new contents'),
    '#attributes' => array('class' => array('container-inline')),
  );

  $form['fetch_new_contens']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Fetch'),
    '#submit' => array('v2_feeds_fetch_new_contents'),
  );

  $form['feed_items'] = array(
    '#type' => 'tableselect',
    '#header' => $headers,
    '#options' => $items,
    '#empty' => $is_filtered ? t('No contents available for filtered result.') : t('No contents available.'),
  );

  $form['pager']['#theme'] = 'pager';

  return $form;
}

function v2_feeds_fetch_new_contents($form, &$form_state) {
  // v2_feeds_update_fetch_new_content();
  //drupal_set_message(t("update"), 'status');
  if ($feeds = v2_feeds_get_feeds()) {
    foreach ($feeds as $sfid => $feed) {
      v2_feeds_feed_update($feed);
    }
  }
  return TRUE;
}

function v2_feeds_update_fetch_new_content() {
  if ($feeds = v2_feeds_get_feeds()) {
    foreach ($feeds as $sfid => $feed) {
      v2_feeds_feed_update($feed);
    }
  }
}

function v2_feeds_admin_wall_items_validate($form, &$form_state) {
  // Error if there are no items to select.
  if (!is_array($form_state['values']['feed_items']) || !count(array_filter($form_state['values']['feed_items']))) {
    form_set_error('', t('No items selected.'));
  }
}

function v2_feeds_admin_wall_items_submit($form, &$form_state) {
  $op = $form_state['values']['operation'];

  // Filter out unchecked items
  $items = array_filter($form_state['values']['feed_items']);

  switch ($op) {
    case 'publish':
    case 'unpublish':
      $publish = ('publish' === $op);
      v2_feeds_feed_items_publish_multiple($items, $publish);
      break;
    case 'delete':
      $delete = ('delete' === $op);
      v2_feeds_feed_items_delele_multiple($items, $delete);
      break;
  }
}

function v2_feeds_filter_form() {
  $filter_values = isset($_SESSION['v2_feeds_admin_filter']) ? $_SESSION['v2_feeds_admin_filter'] : array();

  $default_values = $filter_values + array(
    'query' => NULL,
    'type' => NULL,
    'date_range_to' => FALSE,
    'date_range_from' => FALSE,
  );

  $form['filter'] = array(
    '#type' => 'fieldset',
    '#title' => t('Filter results'),
    '#tree' => TRUE,
  );

  $form['filter']['query'] = array(
    '#type' => 'textfield',
    '#title' => t('Search'),
    '#default_value' => $default_values['query'],
  );

  $form['filter']['type'] = array(
    '#type' => 'select',
    '#title' => t('Social network'),
    '#options' => array(NULL => 'All') + v2_feeds_feed_types(),
    '#default_value' => $default_values['type'],
  );

  $form['filter']['date_range'] = array(
    '#type' => 'container',
    '#attributes' => array(
      'class' => array('container-inline'),
    ),
  );

  $form['filter']['date_range']['from'] = array(
    '#type' => 'textfield',
    '#title' => t('From date'),
    '#default_value' => $default_values['date_range_to'] ? date('d/m/Y', $default_values['date_range_from']) : NULL,
    '#size' => 12,
    '#attributes' => array(
      'placeholder' => 'dd/mm/YYYY',
      'maxlength' => 10,
    ),
  );

  $form['filter']['date_range']['to'] = array(
    '#type' => 'textfield',
    '#title' => t('Till date'),
    '#default_value' => $default_values['date_range_to'] ? date('d/m/Y', $default_values['date_range_to']) : NULL,
    '#size' => 12,
    '#attributes' => array(
      'placeholder' => 'dd/mm/YYYY',
      'maxlength' => 10,
    ),
  );

  $form['filter']['actions'] = array(
    '#type' => 'actions',
  );

  $form['filter']['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Filter'),
    '#validate' => array('v2_feeds_filter_form_validate'),
    '#submit' => array('v2_feeds_filter_form_submit'),
  );

  $form['filter']['actions']['reset'] = array(
    '#type' => 'submit',
    '#value' => t('Reset'),
    '#submit' => array('v2_feeds_filter_form_submit'),
  );

  return $form;
}

function v2_feeds_filter_form_validate($form, &$form_state) {
  // Normalize date fields.
  $values = $form_state['input']['filter'];

  $has_date_range = $values['date_range']['from'] || $values['date_range']['to'];

  if ($has_date_range) {
    $date_range_from = date_create_from_format('d/m/Y', $values['date_range']['from']);
    $date_range_to = date_create_from_format('d/m/Y', $values['date_range']['to']);

    if ($date_range_from === FALSE || $date_range_to === FALSE) {
      form_set_error('date_range', t('Invalid date provided.'));
    }
    elseif ($date_range_to <= $date_range_from) {
      form_set_error('date_range', t('Start date should be less than the end date.'));
    }
    else {
      $form_state['values']['filter']['date_range_from'] = $date_range_from->getTimestamp();
      $form_state['values']['filter']['date_range_to'] = $date_range_to->getTimestamp();
    }

    unset($form_state['values']['filter']['date_range']);
  }
}

function v2_feeds_filter_form_submit($form, $form_state) {
  if ($form_state['values']['op'] === t('Reset')) {
    unset($_SESSION['v2_feeds_admin_filter']);
    return;
  }

  $filter_values = $form_state['values']['filter'];
  unset($filter_values['submit']);

  $filter_values = array_filter($filter_values);

  $_SESSION['v2_feeds_admin_filter'] = $filter_values;
}

function v2_feeds_build_admin_filter_query(SelectQueryInterface $query) {
  $filter = isset($_SESSION['v2_feeds_admin_filter']) ? $_SESSION['v2_feeds_admin_filter'] : array();

  if ($filter) {
    if (isset($filter['query'])) {
      $query->condition('i.message', "%{$filter['query']}%", 'LIKE');
    }

    if (isset($filter['type'])) {
      $query->condition('f.type', $filter['type']);
    }

    if (isset($filter['date_range_from'], $filter['date_range_to'])) {
      $query->condition('i.created', array($filter['date_range_from'], $filter['date_range_to']), 'BETWEEN');
    }
  }
}
