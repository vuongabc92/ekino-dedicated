<?php

/**
 * @file
 * Content type editing user interface.
 */
function modules_types_build() {
  $_node_types = (object) array('types' => array(), 'names' => array());

  $query = db_select('node_type', 'nt')
      ->addTag('translatable')
      ->addTag('node_type_access')
      ->fields('nt')
      ->condition('nt.type', '^module_', 'REGEXP')
      ->orderBy('nt.type', 'ASC');
  foreach ($query->execute() as $type_object) {
    $type_db = $type_object->type;
    // Original disabled value.
    $disabled = $type_object->disabled;
    // Check for node types from disabled modules and mark their types for removal.
    // Types defined by the node module in the database (rather than by a separate
    // module using hook_node_info) have a base value of 'node_content'. The isset()
    // check prevents errors on old (pre-Drupal 7) databases.
    if (isset($type_object->base) && $type_object->base != 'node_content' && empty($_node_types->types[$type_db])) {
      $type_object->disabled = TRUE;
    }
    if (isset($_node_types->types[$type_db])) {
      $type_object->disabled = FALSE;
    }
    if (!isset($_node_types->types[$type_db]) || $type_object->modified) {
      $_node_types->types[$type_db] = $type_object;
      $_node_types->names[$type_db] = $type_object->name;

      if ($type_db != $type_object->orig_type) {
        unset($_node_types->types[$type_object->orig_type]);
        unset($_node_types->names[$type_object->orig_type]);
      }
    }
    $_node_types->types[$type_db]->disabled = $type_object->disabled;
    $_node_types->types[$type_db]->disabled_changed = $disabled != $type_object->disabled;
  }

  asort($_node_types->names);

  return $_node_types;
}

/**
 * Displays the content type admin overview page.
 */
function modules_overview_types() {
  $types = modules_types_build()->types;
  $names = node_type_get_names();
  $field_ui = module_exists('field_ui');
  $header = array(t('Name'), array('data' => t('Operations'), 'colspan' => $field_ui ? '5' : '2'));
  $rows = array();
  foreach ($names as $key => $name) {
    $type = $types[$key];
    if (node_hook($type->type, 'form')) {
      $type_url_str = str_replace('_', '-', $type->type);
      $options = array(
        'query' => array('name' => $type->type),
        'attributes' => array('id' => $type->type, 'target' => '_blank'),
      );
      $row = array(theme('node_admin_overview', array('name' => $name, 'type' => $type)));
      // Set the list content column.
      $row[] = array('data' => l(t('list'), 'admin/module-content', $options));

      // Set the edit column.
      $row[] = array('data' => l(t('edit'), 'admin/structure/types/manage/' . $type_url_str, $options));

      if ($field_ui) {
        // Manage fields.
        $row[] = array('data' => l(t('manage fields'), 'admin/structure/types/manage/' . $type_url_str . '/fields', $options));

        // Display fields.
        $row[] = array('data' => l(t('manage display'), 'admin/structure/types/manage/' . $type_url_str . '/display', $options));
      }

      // Set the delete column.
      if ($type->custom) {
        $row[] = array('data' => l(t('delete'), 'admin/structure/types/manage/' . $type_url_str . '/delete', $options));
      }
      else {
        $row[] = array('data' => '');
      }

      $rows[] = $row;
    }
  }

  $build['node_table'] = array(
    '#theme' => 'table',
    '#header' => $header,
    '#rows' => $rows,
    '#empty' => t('No content types available. <a href="@link">Add content type</a>.', array('@link' => url('admin/structure/types/add'))),
  );

  return $build;
}

/**
 * Page callback: Form constructor for the content administration form.
 *
 * @see node_admin_nodes()
 * @see node_admin_nodes_submit()
 * @see node_admin_nodes_validate()
 * @see node_filter_form()
 * @see node_filter_form_submit()
 * @see node_menu()
 * @see node_multiple_delete_confirm()
 * @see node_multiple_delete_confirm_submit()
 * @ingroup forms
 */
function module_admin_content($form, $form_state) {
  module_load_include('inc', 'node', 'node.admin');
  if (isset($_GET['name']) && !empty($_GET['name'])) {
    unset($_SESSION['module_overview_filter']);
    $_SESSION['module_overview_filter'][] = array('type', $_GET['name']);
  }

  if (isset($form_state['values']['operation']) && $form_state['values']['operation'] == 'delete') {
    return v2_node_multiple_delete_confirm($form, $form_state, array_filter($form_state['values']['nodes']));
  }
  $form['filter'] = module_filter_form();
  $form['#submit'][] = 'module_filter_form_submit';
  $form['admin'] = module_admin_nodes();

  return $form;
}

/**
 * Implements hook_form().
 */
function module_filter_form() {
  $session = isset($_SESSION['module_overview_filter']) ? $_SESSION['module_overview_filter'] : array();
  $filters = module_filters();

  $i = 0;
  $form['filters'] = array(
    '#type' => 'fieldset',
    '#title' => t('Show only items where'),
    '#theme' => 'exposed_filters__node',
  );
  foreach ($session as $filter) {
    list($type, $value) = $filter;
    if ($type == 'term') {
      // Load term name from DB rather than search and parse options array.
      $value = module_invoke('taxonomy', 'term_load', $value);
      $value = $value->name;
    }
    elseif ($type == 'language') {
      $value = $value == LANGUAGE_NONE ? t('Language neutral') : module_invoke('locale', 'language_name', $value);
    }
    else {
      $value = $filters[$type]['options'][$value];
    }
    $t_args = array('%property' => $filters[$type]['title'], '%value' => $value);
    if ($i++) {
      $form['filters']['current'][] = array('#markup' => t('and where %property is %value', $t_args));
    }
    else {
      $form['filters']['current'][] = array('#markup' => t('where %property is %value', $t_args));
    }
    if (in_array($type, array('type', 'language'))) {
      // Remove the option if it is already being filtered on.
      unset($filters[$type]);
    }
  }

  $form['filters']['status'] = array(
    '#type' => 'container',
    '#attributes' => array('class' => array('clearfix')),
    '#prefix' => ($i ? '<div class="additional-filters">' . t('and where') . '</div>' : ''),
  );
  $form['filters']['status']['filters'] = array(
    '#type' => 'container',
    '#attributes' => array('class' => array('filters')),
  );
  foreach ($filters as $key => $filter) {
    $form['filters']['status']['filters'][$key] = array(
      '#type' => 'select',
      '#options' => $filter['options'],
      '#title' => $filter['title'],
      '#default_value' => '[any]',
    );
  }

  $form['filters']['status']['actions'] = array(
    '#type' => 'actions',
    '#attributes' => array('class' => array('container-inline')),
  );
  $form['filters']['status']['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => count($session) ? t('Refine') : t('Filter'),
  );
  if (count($session)) {
    $form['filters']['status']['actions']['undo'] = array('#type' => 'submit', '#value' => t('Undo'));
    $form['filters']['status']['actions']['reset'] = array('#type' => 'submit', '#value' => t('Reset'));
  }

  drupal_add_js('misc/form.js');

  return $form;
}

/**
 * Implement hook_form_submit().
 */
function module_filter_form_submit($form, &$form_state) {
  $filters = module_filters();
  switch ($form_state['values']['op']) {
    case t('Filter'):
    case t('Refine'):
      // Apply every filter that has a choice selected other than 'any'.
      foreach ($filters as $filter => $options) {
        if (isset($form_state['values'][$filter]) && $form_state['values'][$filter] != '[any]') {
          // Flatten the options array to accommodate hierarchical/nested options.
          $flat_options = form_options_flatten($filters[$filter]['options']);
          // Only accept valid selections offered on the dropdown, block bad input.
          if (isset($flat_options[$form_state['values'][$filter]])) {
            $_SESSION['module_overview_filter'][] = array($filter, $form_state['values'][$filter]);
          }
        }
      }
      break;
    case t('Undo'):
      array_pop($_SESSION['module_overview_filter']);
      break;
    case t('Reset'):
      $_SESSION['module_overview_filter'] = array();
      break;
  }
}

/**
 * Implements module filters()
 */
function module_filters() {
  // Regular filters
  $filters['status'] = array(
    'title' => t('status'),
    'options' => array(
      '[any]' => t('any'),
      'status-1' => t('published'),
      'status-0' => t('not published'),
//      'promote-1' => t('promoted'),
//      'promote-0' => t('not promoted'),
//      'sticky-1' => t('sticky'),
//      'sticky-0' => t('not sticky'),
    ),
  );
  // Include translation states if we have this module enabled
//  if (module_exists('translation')) {
//    $filters['status']['options'] += array(
//      'translate-0' => t('Up to date translation'),
//      'translate-1' => t('Outdated translation'),
//    );
//  }



  $filters['type'] = array(
    'title' => t('type'),
    'options' => array(
  '[any]' => t('any'),
    ) + modules_types_build()->names,
  );

  // Language filter if there is a list of languages
  if ($languages = module_invoke('locale', 'language_list')) {
    $languages = array(LANGUAGE_NONE => t('Language neutral')) + $languages;
    $filters['language'] = array(
      'title' => t('language'),
      'options' => array(
    '[any]' => t('any'),
      ) + $languages,
    );
  }
  return $filters;
}

/**
 * Form builder: Builds the node administration overview.
 *
 * @see node_admin_nodes_submit()
 * @see node_admin_nodes_validate()
 * @see node_filter_form()
 * @see node_filter_form_submit()
 * @see node_multiple_delete_confirm()
 * @see node_multiple_delete_confirm_submit()
 *
 * @ingroup forms
 */
function module_admin_nodes() {
  $admin_access = user_access('administer nodes');

  // Build the 'Update options' form.
  $form['options'] = array(
    '#type' => 'fieldset',
    '#title' => t('Update options'),
    '#attributes' => array('class' => array('container-inline')),
    '#access' => $admin_access,
  );
  $options = array();
  foreach (module_invoke_all('node_operations') as $operation => $array) {
    $options[$operation] = $array['label'];
  }
  $form['options']['operation'] = array(
    '#type' => 'select',
    '#title' => t('Operation'),
    '#title_display' => 'invisible',
    '#options' => $options,
    '#default_value' => 'approve',
  );
  $form['options']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Update'),
    '#validate' => array('node_admin_nodes_validate'),
    '#submit' => array('node_admin_nodes_submit'),
  );

  // Enable language column if translation module is enabled or if we have any
  // node with language.
  $multilanguage = (module_exists('translation') || db_query_range("SELECT 1 FROM {node} WHERE language <> :language", 0, 1, array(':language' => LANGUAGE_NONE))->fetchField());

  // Build the sortable table header.
  $header = array(
    'title' => array('data' => t('Title'), 'field' => 'n.title'),
    'type' => array('data' => t('Type'), 'field' => 'n.type'),
    'author' => t('Author'),
    'status' => array('data' => t('Status'), 'field' => 'n.status'),
    'changed' => array('data' => t('Updated'), 'field' => 'n.changed', 'sort' => 'desc')
  );
  if ($multilanguage) {
    $header['language'] = array('data' => t('Language'), 'field' => 'n.language');
  }
  $header['operations'] = array('data' => t('Operations'));

  $query = db_select('node', 'n')->extend('PagerDefault')->extend('TableSort');
  $query->addTag('node_admin_filter');
  $query->condition('n.type', array_keys(modules_types_build()->names), 'IN');
  module_content_build_filter_query($query);

  if (!user_access('bypass node access')) {
    // If the user is able to view their own unpublished nodes, allow them
    // to see these in addition to published nodes. Check that they actually
    // have some unpublished nodes to view before adding the condition.
    if (user_access('view own unpublished content') && $own_unpublished = db_query('SELECT nid FROM {node} WHERE uid = :uid AND status = :status', array(':uid' => $GLOBALS['user']->uid, ':status' => 0))->fetchCol()) {
      $query->condition(db_or()
              ->condition('n.status', 1)
              ->condition('n.nid', $own_unpublished, 'IN')
      );
    }
    else {
      // If not, restrict the query to published nodes.
      $query->condition('n.status', 1);
    }
  }
  $nids = $query
      ->fields('n', array('nid'))
      ->limit(50)
      ->orderByHeader($header)
      ->addTag('node_access')
      ->execute()
      ->fetchCol();
  $nodes = node_load_multiple($nids);

  // Prepare the list of nodes.
  $languages = language_list();
  $destination = drupal_get_destination();
  $options = array();
  foreach ($nodes as $node) {
    $langcode = entity_language('node', $node);
    $l_options = $langcode != LANGUAGE_NONE && isset($languages[$langcode]) ? array('language' => $languages[$langcode]) : array();
    $options[$node->nid] = array(
      'title' => array(
        'data' => array(
          '#type' => 'link',
          '#title' => $node->title,
          '#href' => 'node/' . $node->nid,
          '#options' => $l_options,
          '#suffix' => ' ' . theme('mark', array('type' => node_mark($node->nid, $node->changed))),
        ),
      ),
      'type' => check_plain(node_type_get_name($node)),
      'author' => theme('username', array('account' => $node)),
      'status' => $node->status ? t('published') : t('not published'),
      'changed' => format_date($node->changed, 'short'),
    );
    if ($multilanguage) {
      if ($langcode == LANGUAGE_NONE || isset($languages[$langcode])) {
        $options[$node->nid]['language'] = $langcode == LANGUAGE_NONE ? t('Language neutral') : t($languages[$langcode]->name);
      }
      else {
        $options[$node->nid]['language'] = t('Undefined language (@langcode)', array('@langcode' => $langcode));
      }
    }
    // Build a list of all the accessible operations for the current node.
    $operations = array();
    if (node_access('update', $node)) {
      $operations['edit'] = array(
        'title' => t('edit'),
        'href' => 'node/' . $node->nid . '/edit',
        'query' => $destination,
      );
    }
    if (node_access('delete', $node)) {
      $operations['delete'] = array(
        'title' => t('delete'),
        'href' => 'node/' . $node->nid . '/delete',
        'query' => $destination,
      );
    }
    $options[$node->nid]['operations'] = array();
    if (count($operations) > 1) {
      // Render an unordered list of operations links.
      $options[$node->nid]['operations'] = array(
        'data' => array(
          '#theme' => 'links__node_operations',
          '#links' => $operations,
          '#attributes' => array('class' => array('links', 'inline')),
        ),
      );
    }
    elseif (!empty($operations)) {
      // Render the first and only operation as a link.
      $link = reset($operations);
      $options[$node->nid]['operations'] = array(
        'data' => array(
          '#type' => 'link',
          '#title' => $link['title'],
          '#href' => $link['href'],
          '#options' => array('query' => $link['query']),
        ),
      );
    }
  }

  // Only use a tableselect when the current user is able to perform any
  // operations.
  if ($admin_access) {
    $form['nodes'] = array(
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $options,
      '#empty' => t('No content available.'),
    );
  }
  // Otherwise, use a simple table.
  else {
    $form['nodes'] = array(
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $options,
      '#empty' => t('No content available.'),
    );
  }

  $form['pager'] = array('#markup' => theme('pager'));
  return $form;
}

/**
 * Applies filters for node administration filters based on session.
 *
 * @param $query
 *   A SelectQuery to which the filters should be applied.
 */
function module_content_build_filter_query(SelectQueryInterface $query) {
  // Build query
  $filter_data = isset($_SESSION['module_overview_filter']) ? $_SESSION['module_overview_filter'] : array();
  foreach ($filter_data as $index => $filter) {
    list($key, $value) = $filter;
    switch ($key) {
      case 'status':
        // Note: no exploitable hole as $key/$value have already been checked when submitted
        list($key, $value) = explode('-', $value, 2);
      case 'type':
      case 'language':
        $query->condition('n.' . $key, $value);
        break;
    }
  }
}

/**
 * Multiple node deletion confirmation form for module_admin_content().
 *
 * @see module_admin_content
 * @ingroup forms
 */
function v2_node_multiple_delete_confirm($form, &$form_state, $nodes) {
  $form['nodes'] = array('#prefix' => '<ul>', '#suffix' => '</ul>', '#tree' => TRUE);
  // array_filter returns only elements with TRUE values
  foreach ($nodes as $nid => $value) {
    $title = db_query('SELECT title FROM {node} WHERE nid = :nid', array(':nid' => $nid))->fetchField();
    $form['nodes'][$nid] = array(
      '#type' => 'hidden',
      '#value' => $nid,
      '#prefix' => '<li>',
      '#suffix' => check_plain($title) . "</li>\n",
    );
  }
  $form['operation'] = array('#type' => 'hidden', '#value' => 'delete');
  $form['#submit'][] = 'v2_node_multiple_delete_confirm_submit';
  $confirm_question = format_plural(count($nodes),
                                  'Are you sure you want to delete this item?',
                                  'Are you sure you want to delete these items?');
  return confirm_form($form,
                    $confirm_question,
                    'admin/module-content', t('This action cannot be undone.'),
                    t('Delete'), t('Cancel'));
}

/**
 * Form submission handler for v2_node_multiple_delete_confirm().
 *
 * @see v2_node_multiple_delete_confirm()
 */
function v2_node_multiple_delete_confirm_submit($form, &$form_state) {
  if ($form_state['values']['confirm']) {
    node_delete_multiple(array_keys($form_state['values']['nodes']));
    cache_clear_all();
    $count = count($form_state['values']['nodes']);
    watchdog('content', 'Deleted @count posts.', array('@count' => $count));
    drupal_set_message(format_plural($count, 'Deleted 1 post.', 'Deleted @count posts.'));
  }
  $form_state['redirect'] = 'admin/module-content';
}
