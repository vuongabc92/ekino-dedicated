<?php

/**
 * Convert an Instagram username to its ID.
 * Based on http://stackoverflow.com/a/12770516
 *
 * @return string|bool
 */
require_once('sites/all/libraries/instagram/src/Instagram.php');

use MetzWeb\Instagram\Instagram;

function _v2_feeds_instagram_username_to_id($username, &$status_code = NULL) {
  $username = strtolower($username); // sanitization
  $client_id = variable_get('mumm_social_instagram_app_client_id');
  $url = sprintf('https://api.instagram.com/v1/users/search?q=%s&client_id=%s', $username, $client_id);

  $response = drupal_http_request($url, array('method' => 'GET'));
  $status_code = $response->code;

  if ($status_code == 200) {
    $json_response = json_decode($response->data, TRUE);
    $users = $json_response['data'];
    foreach ($users as $user) {
      if ($user['username'] === $username) {
        return $user['id'];
      }
    }
  }

  return FALSE;
}

function v2_feeds_form_admin_feed_subscribe_alter_instagram(&$form, &$form_state) {
  $form['#validate'][] = 'v2_feeds_admin_feed_subscribe_validate_instagram';
}

function v2_feeds_admin_feed_subscribe_validate_instagram(&$form, &$form_state) {
  if ($form_state['values']['type'] !== SocialFeed::TYPE_INSTAGRAM) {
    // We don't care about other feed types.
    return;
  }

  // A feed object will always be set during validation.
  /** @var SocialFeedInstagram $feed */
  $feed = $form['#feed'];

  // Handle hashtag validation.
  if ($feed->isHashtag()) {
    // We don't want an empty name, as it would crash the database transaction :)
    $hashtag = $feed->getIdentifier();
    $feed->setName($hashtag);

    // No additional validation is required for a hashtag.
    $feed->markValid();

    return;
  }

  // Handle user account.

  if (is_numeric($feed->identifier)) {
    // Identifier is already numeric.
    // Nothing to validate.
    return;
  }

  // Identifier is a username. Convert it to an instagram user id.
  $username = $feed->identifier;
  $uid = _v2_feeds_instagram_username_to_id($username);

  if (!$uid) {
    form_set_error('identifier', t('An Instagram account with this username was not found.'));
    return;
  }

  // Swap identifier with the uid, and keep username as feed name.
  $feed->setIdentifier($uid);
  $feed->setName($username);

  // Maybe we already have an account with this identifier.
  // Try to reload the feed with the new data.
  if ($db_feed = v2_feeds_feed_load_identifier($uid, 'instagram')) {
    $feed->sfid = $db_feed->sfid;
  }

  $feed->markValid();
}

/**
 * @param SocialFeedInstagram $feed
 * @param array $errors
 * @return bool|null
 */
function v2_feeds_feed_validate_instagram($feed, &$errors = array()) {
  if ($feed->isHashtag()) {
    // No validation required for a hashtag.
    $feed->markValid();

    // We don't want an empty name, as it would crash the database transaction :)
    $hashtag = $feed->getIdentifier();
    $feed->setName($hashtag);

    return NULL;
  }

  if (is_numeric($feed->identifier)) {
    // Identifier is already numeric.
    // Nothing to validate.
    return NULL;
  }

  // Identifier is a username. Convert it to an instagram user id.
  $username = $feed->identifier;

  if (FALSE === $uid = _v2_feeds_instagram_username_to_id($username, $status_code)) {
    // Oops. No result.
    if ($status_code == 200) {
      $errors['identifier'] = array(
        'type' => 'not_found',
        'message' => 'An Instagram account with this username was not found.',
      );
    }
    else {
      $errors[''] = array(
        'type' => 'server',
      );
    }

    return FALSE;
  }

  // Account exists.
  $feed->markValid();

  $feed->setIdentifier($uid);
  $feed->setName($username);

  // Try to reload the feed with the new data.
  if ($db_feed = v2_feeds_feed_load_identifier($uid, 'instagram')) {
    $feed->sfid = $db_feed->sfid;
  }

  return TRUE;
}

/**
 * @param SocialFeedInstagram $feed
 * @return bool
 */
function v2_feeds_feed_update_instagram($feed) {
  $images = array();
  $i = 0;
  libraries_load('instagram');
  $instagram = new Instagram(array(
    'apiKey' => variable_get('mumm_social_instagram_app_client_id'),
    'apiSecret' => variable_get('mumm_social_instagram_app_client_secret'),
  ));

  if ($feed->identifier) {
    $instagram_objects = $instagram->getUserMedia($feed->identifier)->data;
    if(empty($instagram_objects)){
      $access_token = variable_get('mumm_social_instagram_app_access_token');
      $url = 'https://api.instagram.com/v1/users/'.$feed->identifier.'/media/recent?access_token='.$access_token.'';
      $result = file_get_contents($url);
      $instagram_objects = json_decode($result)->data;    
    } 
  }
  if($instagram_objects){
    $count_items = 0;
    foreach ($instagram_objects as $instagram_object) {
       $record = (object) array(
            'sfid' => $feed->sfid,
            'message' => instagram_link_tags_user($instagram_object->caption->text),
            'guid' => $instagram_object->id,
            'username' => $instagram_object->user->username,
            'uid' => $instagram_object->user->id,
            'media_url' => $instagram_object->images->standard_resolution->url,
            'url' => $instagram_object->link,
            'created' => $instagram_object->created_time,
      );
      $query = db_select('social_feed_items', 's');
      $query->fields('s', array('sfiid', 'sfid', 'guid'));
      $query->condition('s.guid',$instagram_object->id);
      $result = $query->execute()->fetchAssoc();

      if (empty($result)) {
        drupal_write_record('social_feed_items', $record);
        $count_items++;
      }    
    }
    if($count_items > 0){
    drupal_set_message('Total '.$count_items.' items instagram feeds added');
    }
  }
  else {
    drupal_set_message(t('Failed feed instagram: '.$feed->identifier.', You need check api key, api Secret, access token at <a href="/admin/config/content/social-sharing">this link</a>'), 'warning');
  }
  return TRUE;
}

function v2_feeds_preprocess_v2_feeds_item_instagram(&$vars) {
  $message = & $vars['message'];

  // Make hashtags clickable.
  $hashtag_pattern = '/#(\w+)/';
  $message = preg_replace_callback($hashtag_pattern, '_v2_feeds_filter_instagram_tag_urls', $message);

  // Make tags clickable.
  // @todo

}
function _v2_feeds_filter_instagram_tag_urls($matches) {
  $text = $matches[0];
  $hashtag = $matches[1];

  $link = sprintf('https://twitter.com/hashtag/%s?src=hash', $hashtag);
  return sprintf('<a href="%s" target="_blank">%s</a>', $link, $text);
}

function instagram_link_tags_user($message) {
  $text = _v2_feeds_strip_utf8($message);
  $patterns = array('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '/@([A-Za-z0-9_]{1,30})/');
  $replace = array('<a href="$1">$1</a>', '<a href="https://www.instagram.com/$1" target="_blank">@$1</a>');
  $result = preg_replace($patterns, $replace, $text);
  $str = preg_replace('/\#([a-z0-9]+)/i', '<a target="_blank" href="https://www.instagram.com/explore/tags/$1">#$1</a>', $result);
  return $str;
}