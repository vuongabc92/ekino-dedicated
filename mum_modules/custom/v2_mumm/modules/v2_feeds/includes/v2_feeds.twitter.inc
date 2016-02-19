<?php

function v2_feeds_form_admin_feed_subscribe_alter_twitter(&$form, &$form_state) {
  $form['#validate'][] = 'v2_feeds_admin_feed_subscribe_validate_twitter';
}

function v2_feeds_admin_feed_subscribe_validate_twitter(&$form, &$form_state) {
  if ($form_state['values']['type'] !== SocialFeed::TYPE_TWITTER) {
    // We don't care about other feed types.
    return;
  }

  // A feed object will always be set during validation.
  /** @var SocialFeedTwitter $feed */
  $feed = $form['#feed'];

  // @todo Handle duplicate names / twitter user ids.
  if (TRUE) {
    // Replace $feed object with existing sfid.
  }

  $name = $feed->getIdentifier();
  if (!$feed->isHashtag()) {
    $name = '@' . $name;
  }

  $feed->setName($name);
  $feed->markValid();
}

/**
 * @param SocialFeedTwitter $feed
 * @return bool
 */
function v2_feeds_feed_update_twitter($feeds) {
  $twitter_tweets = array();
  $display_time = '';
   
  $settings = array(
    'oauth_access_token' => variable_get('mumm_social_twitter_access_token'),
    'oauth_access_token_secret' => variable_get('mumm_social_twitter_access_token_secret'),
    'consumer_key' => variable_get('mumm_social_twitter_consumer_key'),
    'consumer_secret' => variable_get('mumm_social_twitter_consumer_secret'),
  );


  $twitter_username = $feeds->identifier;
  $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
  $request_method = "GET";
  $getfield = '?screen_name=' . $twitter_username;
  // Loading TwitterAPIExchange.
  require_once('sites/all/libraries/twitter/TwitterAPIExchange.php' );
  libraries_load('twitter');
  
  $curlOptions = array(
    CURLOPT_SSL_VERIFYPEER => FALSE,
  );

  $twitter = new TwitterAPIExchange($settings);
    $twitter_values = json_decode($twitter->setGetfield($getfield)
    ->buildOauth($url, $request_method)
    ->performRequest(TRUE, $curlOptions), $assoc = TRUE
  );

  $transaction = db_transaction();
  if (isset($twitter_values) && !empty($twitter_values)) {
    $count_items = 0;
    foreach ($twitter_values as $key => $twitter_value) {
      $formatted_twitter_date = new DateTime($twitter_value['created_at']);
      $twitter_tweets = $twitter_value['extended_entities']['media'];
      try {
        $record = (object) array(
              'sfid' => $feeds->sfid,
              'message' => tweet_html_text_twitter($twitter_value['text']),
              'guid' => $twitter_value['id'],
              'username' => $twitter_username,
              'uid' => $twitter_value['user']['id'],
              'media_url' => $twitter_tweets ? $twitter_tweets[0]['media_url'] : Null,
              'url' => 'https://twitter.com/' . $twitter_username . '/status/' . $twitter_value['id'],
              'created' => date_timestamp_get($formatted_twitter_date),
        );
        $query = db_select('social_feed_items', 's');
        $query->fields('s', array('sfiid', 'sfid', 'guid'));
        $query->condition('s.guid', $twitter_value['id']);
        $result = $query->execute()->fetchAssoc();
        if (empty($result)) {
          drupal_write_record('social_feed_items', $record);
          $count_items++;
        }
      }
      catch (Exception $ex) {
        $transaction->rollback();

        watchdog_exception('mumm_social_wall', $ex);
        return FALSE;
      }
    }
    if($count_items > 0){
      drupal_set_message('Total '.$count_items.' items twitter feeds added');
    }
  }
  else {
    drupal_set_message(t('failed'), 'warning');
  }

  return TRUE;
}

function v2_feeds_preprocess_v2_feeds_item_twitter(&$vars) {
  $message = & $vars['message'];

  // Make hashtags clickable.
  $hashtag_pattern = '/#(\w+)/';
  $message = preg_replace_callback($hashtag_pattern, '_v2_feeds_filter_twitter_tag_urls', $message);

}

function _v2_feeds_filter_twitter_tag_urls($matches) {
  $text = $matches[0];
  $hashtag = $matches[1];

  $link = sprintf('https://twitter.com/hashtag/%s?src=hash', $hashtag);
  return sprintf('<a href="%s" target="_blank">%s</a>', $link, $text);
}

/**
 * Twitter link tags
 * @param type $tweet
 * @return type
 */
function tweet_html_text_twitter($tweet) {
  $text = _v2_feeds_strip_utf8($tweet);
  $patterns = array('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '/@([A-Za-z0-9_]{1,30})/');
  $replace = array('<a href="$1" target="_blank">$1</a>', '<a href="http://twitter.com/$1" target="_blank">@$1</a>');
  $result = preg_replace($patterns, $replace, $text);
  $str = preg_replace('/\#([a-z0-9]+)/i', '<a target="_blank" href="https://twitter.com/search?q=%23$1">#$1</a>', $result);
  return $str;
}