<?php

use Facebook\Entities\AccessToken;
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\GraphUser;
use Facebook\FacebookAuthorizationException;

function _v2_feeds_libraries_load_facebook() {
  $loaded = drupal_static(__FUNCTION__);
  if ($loaded) {
    return TRUE;
  }

  $library = libraries_load('facebook-php-sdk');

  $loaded = $library['installed'] && $library['loaded'] > 0;
  if (!$loaded && variable_get('v2_feeds_throw_exception', FALSE)) {
    throw new Exception('Could not load library: facebook-php-sdk');
  }

  return $loaded;
}

/**
 * @param object $feed
 * @return string|null
 */
function _v2_feeds_get_facebook_feed_access_token($feed) {
  if (is_object($feed) && !empty($feed->sfid)) {
    $sfid = $feed->sfid;
  }
  else if (is_numeric($feed)) {
    $sfid = $feed;
  }
  else {
    return NULL;
  }

  return v2_feeds_get_feed_credentials($sfid, 'access_token');
}

function _v2_feeds_init_facebook_session() {
  _v2_feeds_libraries_load_facebook();

  $app_id = variable_get('mumm_social_facebook_app_id');
  $app_secret = variable_get('mumm_social_facebook_app_secret');
  FacebookSession::setDefaultApplication($app_id, $app_secret);
}

function _v2_feeds_get_facebook_session($access_token = NULL, $validate = FALSE) {
  _v2_feeds_init_facebook_session();

  $session = NULL === $access_token ? FacebookSession::newAppSession() : new FacebookSession($access_token);

  if ($validate) {
    $session->validate();
  }

  return $session;
}

function _v2_feeds_extend_facebook_access_token($access_token) {
  _v2_feeds_init_facebook_session();

  try {
    $token = new AccessToken($access_token);
    $extended_token = $token->extend();

    return (string) $extended_token;
  }
  catch (Exception $e) {
    throw $e;
  }

  return $access_token;
}

/**
 * @param SocialFeedFacebook $feed
 */
function v2_feeds_feed_prepare_facebook($feed) {
  if (!$feed->hasAccessToken()) {
    // Try to load access token from database.
    $access_token = _v2_feeds_get_facebook_feed_access_token($feed);
    $feed->setAccessToken($access_token);
  }
}

/**
 * @param SocialFeedFacebook $feed
 * @param array $errors
 * @return bool
 */
function v2_feeds_feed_validate_facebook($feed, &$errors = array()) {
  _v2_feeds_libraries_load_facebook();

  // Make an API call to FB to validate the feeds existence and permissions.
  try {
    $path = sprintf('/%s', $feed->identifier);

    $session = _v2_feeds_get_facebook_session($feed->getAccessToken(), true);
    $response = (new FacebookRequest($session, 'GET', $path))->execute();

    $result = $response->getGraphObject();
    $feed->setIdentifier($result->getProperty('username'));
    $feed->setName($result->getProperty('name'));

    $feed->markValid();
  }
  catch (FacebookAuthorizationException $ex) {
    // Page does not exist, or you might need more permissions.
    $errors['identifier'] = array(
      'type' => 'authorization',
      'message' => 'Page does not exist, or you need more permissions to view the posts.',
      'exception' => $ex,
    );
    return FALSE;
  }
  catch (Exception $ex) {
    $errors[''] = array(
      'type' => 'server',
      'exception' => $ex,
    );
    return FALSE;
  }

  return TRUE;
}

/**
 * @param array $form
 * @param array $form_state
 * @param SocialFeedFacebook $feed
 */
function v2_feeds_form_admin_feed_subscribe_alter_facebook(&$form, &$form_state) {
  $form['fb_access_token'] = array(
    '#type' => 'container',
    '#states' => array(
      'visible' => array(
        ':input[name="type"]' => array('value' => 'facebook'),
      ),
    ),
    '#weight' => 60,
  );

  $form['fb_access_token']['fb_access_token'] = array(
    '#type' => 'textarea',
    '#title' => 'Access token',
    '#description' => '<p>The access token to be used when fetching new entries. This is required when subscribing to protected Facebook pages.</p>' .
    '<p>You might try to click on the <tt>"Fetch token using Facebook Connect"</tt> button below, after filling in the <em>Identifier</em> field.</p>',
  );

  $form['fb_access_token']['fb_connect'] = array(
    '#markup' => 'Fetch access token using Facebook Connect',
    '#prefix' => '<a href="#" class="fb-connect">',
    '#suffix' => '</a>',
  );

  $form['#validate'][] = 'v2_feeds_admin_feed_subscribe_validate_facebook';
  $form['#submit'][] = 'v2_feeds_admin_feed_subscribe_submit_facebook';
}

/**
 * Add validation checks for Facebook feeds.
 *
 * This will check if an access token is required, and alerts when the optionally provided access token is incorrect.
 *
 * @param $form
 * @param $form_state
 *
 * @see v2_feeds_admin_feed_subscribe_validate
 */
function v2_feeds_admin_feed_subscribe_validate_facebook($form, &$form_state) {
  if ($form_state['values']['type'] !== SocialFeed::TYPE_FACEBOOK) {
    // We don't care about other feed types.
    return;
  }

  // A feed object will always be set during validation.
  /** @var SocialFeedFacebook $feed */
  $feed = $form['#feed'];

  if ($feed->isHashtag()) {
    // Block unsupported hashtag search on this platform.
    form_set_error('identifier', 'Hashtag search is currently not supported in Facebook platform.');
    return;
  }

  if (!$feed->needsValidation()) {
    // Facebook feed is marked as up and running.
    // No need to (re)check access permissions.
    return;
  }

  // We want to check whether we can access the page or not.

  if (!empty($form_state['values']['fb_access_token'])) {
    // Use the provided access token.
    $access_token = $form_state['values']['fb_access_token'];

    // Try to extend this access token. Otherwise, just keep $access_token as is.
    $access_token = _v2_feeds_extend_facebook_access_token($access_token);
  }
  else {
    // Fallback to access token from database.
    $db_access_token = _v2_feeds_get_facebook_feed_access_token($feed);

    form_set_value($form['fb_access_token'], $db_access_token, $form_state);
    $access_token = $db_access_token;
  }

  if (!empty($access_token)) {
    $feed->setAccessToken($access_token);
  }

  $valid = v2_feeds_feed_validate_facebook($feed);
  if (!$valid) {
    form_set_error('identifier', t('Page does not exist, or you need more permissions to view the posts.'));
    form_set_error('fb_access_token');
  }
}

/**
 * Stores the access_token in database, along with the feed itself.
 *
 * @param array $form
 * @param array $form_state
 */
function v2_feeds_admin_feed_subscribe_submit_facebook($form, &$form_state) {
  if ($form_state['values']['type'] !== SocialFeed::TYPE_FACEBOOK) {
    // We don't care about other feed types.
    return;
  }

  /** @var SocialFeedFacebook $feed */
  $feed = $form['#feed'];

  if ($feed->hasAccessToken()) {
    // Save used access token to database.
    $access_token = $feed->getAccessToken();
    v2_feeds_set_feed_credentials($feed, array('access_token' => $access_token));
  }
}

function v2_feeds_feed_update_facebook($feed_social) {

  _v2_feeds_libraries_load_facebook();

  $paging_limit = 100;
  $request = NULL;
  $response = NULL;

  try {
    $config = $message_feed = array();
    $display_time = $display_pic = $selected_type = $selected_type_key = $fb_type = $selected_type_value = '';
    $config['app_id'] = variable_get('mumm_social_facebook_app_id');
    $config['secret'] = variable_get('mumm_social_facebook_app_secret');
    $fb_page = $feed_social->identifier;
    require_once('sites/all/libraries/facebook-php-sdk/autoload.php');
    // PHP SDK 5.x
    libraries_load('facebook-php-sdk');
    FacebookSession::setDefaultApplication($config['app_id'], $config['secret']);
    if (isset($config['app_id']) && !empty($config['app_id']) && isset($config['secret']) && !empty($config['secret'])) {
      
    $session = variable_get('mumm_social_facebook_access_token', NULL); 
    $session =  !empty($session) ? new FacebookSession($session): FacebookSession::newAppSession();

    $facebook_feeds = (new FacebookRequest(
      $session, 'GET',   '/'.$fb_page.'/feed',    array(
              'fields' => 'message,full_picture,link,created_time',
            )
    ))->execute()->getGraphObject(GraphUser::className());
    $facebook_values = $facebook_feeds->asArray('data');

      /* handle the result */
    if ($facebook_values['data']) {
        $i = 0;
        $message_feed = array();
        foreach ($facebook_values['data'] as $facebook_value) {
          if (array_key_exists('message', $facebook_value)) {
            $id_post = explode('_', $facebook_value->id);
            $url_post = 'https://www.facebook.com/' . $fb_page . '/posts/' . $id_post[1] . '';
            $message_feed[$facebook_value->id]['id'] = $facebook_value->id;
            $message_feed[$facebook_value->id]['message'] = convert_clickable_links($facebook_value->message);
            $message_feed[$facebook_value->id]['picture'] = $facebook_value->full_picture;
            $message_feed[$facebook_value->id]['url'] = $url_post;
            $message_feed[$facebook_value->id]['uid'] = $id_post[0];
            $formatted_facebook_date = new DateTime($facebook_value->created_time);
            $message_feed[$facebook_value->id]['created_time'] = date_timestamp_get($formatted_facebook_date);
          }
        }
        $count_items = 0;  
        foreach ($message_feed as $feed) {
          $record = (object) array(
                'sfid' => $feed_social->sfid,
                'guid' => $feed['id'],
                'message' => isset($feed['message']) ? $feed['message'] : NULL,
                'username' => $fb_page,
                'uid' => $feed['uid'],
                'media_url' => isset($feed['picture']) ? $feed['picture'] : NULL,
                'url' => $feed['url'],
                'created' => $feed['created_time'],
          );
          $query = db_select('social_feed_items', 's');
          $query->fields('s', array('sfiid', 'sfid', 'guid'));
          $query->condition('s.guid', $feed['id']);
          $result = $query->execute()->fetchAssoc();

          if (empty($result)) {
            drupal_write_record('social_feed_items', $record);
            $count_items++;
          }
        }
        if($count_items > 0){
          drupal_set_message('Total '.$count_items.' items facebook feeds added', 'status');
        }
      }     
    }
    else {
      drupal_set_message(t('Please provide your credentials at the Facebook <a href="@configuration">configuration page</a>.', array('@configuration' => 'admin/config/content/social-sharing')), 'warning');
    }
  }
  catch (FacebookRequestException $ex) {
    drupal_set_message(t('Failed feed Facebook:'.$feed_social->identifier.', You need check api key, api Secret, access token at <a href="/admin/config/content/social-sharing">this link</a>'), 'warning');
    drupal_set_message($ex->getMessage(), 'error');
    watchdog('v2_feeds', 'Failed to update Facebook feed @sfid: %error_msg', array(
      '@sfid' => $feed->sfid,
      '%error_msg' => $ex->getMessage(),
        ), WATCHDOG_ERROR);
    return FALSE;
  }

  return TRUE;
}

function v2_feeds_preprocess_v2_feeds_item_facebook(&$vars) {
  $message = & $vars['message'];

  // Make hashtags clickable.
  $hashtag_pattern = '/#(\w+)/';
  $message = preg_replace_callback($hashtag_pattern, '_v2_feeds_filter_facebook_tag_urls', $message);

  // Make tags clickable.
  // @todo
}

function _v2_feeds_filter_facebook_tag_urls($matches) {
  $text = $matches[0];
  $hashtag = $matches[1];

  $link = sprintf('https://www.facebook.com/hashtag/%s', $hashtag);
  return sprintf('<a href="%s" target="_blank">%s</a>', $link, $text);
}

function convert_clickable_links($message) {
  $parsedMessage = preg_replace(array('/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))/', '/(^|[^a-z0-9_])@([a-z0-9_]+)/i', '/(^|[^a-z0-9_])#([a-z0-9_]+)/i'), array('<a href="$1" target="_blank">$1</a>', '$1<a target="_blank" href="">@$2</a>', '$1<a target="_blank" href="https://facebook.com/hashtag/$2">#$2</a>'), $message);
  return $parsedMessage;
}