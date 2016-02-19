<?php

class Thu_Social_Get_Feed {

  function __construct() {

    $this->load_libs();
  }

  function load_libs() {
    $files = array(
      "twitter/TwitterAPIExchange.php"
    );
    $library_path = DRUPAL_ROOT . '/' . drupal_get_path('module', 'thu_social_feed') . '/libs';

    foreach ($files as $item) {
      require "$library_path/$item";
    }
  }

  /**
   * Check a value exist in an array
   *
   * @param array $array array to check $value from $key
   * @param string $key
   * @param string $val
   *
   * @return boolean
   */
  public function array_exist($array, $key, $val) {
    if (count($array)) {
      foreach ($array as $item) {
        if (isset($item[$key]) && $item[$key] === $val) {
          return true;
        }
      }
    }

    return false;
  }

  public function get_twitter_feed() {
    //Generate twitter key params to get feeds
    $account_twitter = variable_get('social_feed_account_twitter', THU_FEEDS_DEFAULT_ACC_TWITTER);
    $twitter_params = array(
      'hashtags' => variable_get('social_feed_hashtags'),
      'access_token' => variable_get('social_feed_access_token'),
      'access_token_secret' => variable_get('social_feed_access_token_secret'),
      'customer_key' => variable_get('social_feed_consumer_key'),
      'customer_secret' => variable_get('social_feed_consumer_secret'),
      'url_api' => variable_get('social_feed_request_uri')
    );

    if (empty($twitter_params['hashtags'])) {
      $twitter_params['hashtags'] = THU_FEEDS_DEFAULT_HASHTAG;
    }

    $hashtags_arr = explode(',', $twitter_params['hashtags']);
    $settings = array(
      'oauth_access_token' => $twitter_params['access_token'],
      'oauth_access_token_secret' => $twitter_params['access_token_secret'],
      'consumer_key' => $twitter_params['customer_key'],
      'consumer_secret' => $twitter_params['customer_secret']
    );

    $curlOptions = array(
      CURLOPT_SSL_VERIFYPEER => FALSE,
    );

    $twitter = new TwitterAPIExchange($settings);

    //Get all feeds by search key hashtag
    $feeds_rebuild = array();
    //Loop each hashtags if contain many hashtags
    if (count($hashtags_arr)) {
      foreach ($hashtags_arr as $hashtag) {
        //Get feeds
        //$url_tweet = $twitter_params['url_api'];
        $url_tweet = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $url_query = '?screen_name=' . $account_twitter . '&count=5';

        $response_feeds = $twitter->setGetfield($url_query)
            ->buildOauth($url_tweet, 'GET')
            ->performRequest(TRUE, $curlOptions);
        $responses = json_decode($response_feeds, true);
        //Loop feeds response and check does the feed exist or not
        //and ger appropriate info

        foreach ($responses as $one) {
          if (!$this->array_exist($feeds_rebuild, 'id', $one['id'])) {
            // Just get feed from account $account_twitter.
            if (isset($one['user']['screen_name']) && $one['user']['screen_name'] == $account_twitter) {
              $created_at = new \DateTime($one['created_at']);

              $one_feed = array(
                'field_feed_id' => $one['id'],
                'field_feed_content' => $one['text'],
                'field_feed_picture' => isset($one['entities']['media'][0]['media_url']) ? $one['entities']['media'][0]['media_url'] : '',
                'field_feed_video' => '',
                'field_feed_link' => isset($one['entities']['media'][0]['expanded_url']) ? $one['entities']['media'][0]['expanded_url'] : '',
                'field_feed_from_id' => $one['user']['id'],
                'field_feed_name' => $one['user']['name'],
                'field_feed_avatar' => $one['user']['profile_image_url'],
                'field_feed_location' => NULL,
                'field_feed_create_at' => $created_at->format('Y-m-d h:i:s'),
                'field_feed_type' => '',
                  //'field_feed_link_detail' => 'https://twitter.com/'. $one['user']['screen_name'] .'/status/' . $one['id'],
              );

              if (strpos($one_feed['field_feed_link'], 'video')) {
                $one_feed['field_feed_type'] = 'video';
                $one_feed['field_feed_video'] = $one_feed['field_feed_link'];
              }

              if (strpos($one_feed['field_feed_link'], 'photo')) {
                $one_feed['field_feed_type'] = 'image';
              }

              if ($one['place'] !== NULL) {
                $one_feed['field_feed_location'] = array(
                  'longitude' => $one['place']['bounding_box']['coordinates'][0][0][0],
                  'latitude' => $one['place']['bounding_box']['coordinates'][0][0][1],
                );
              }
              $feeds_rebuild[] = $one_feed;
            }
          }
        }
      }
    }

    return $feeds_rebuild;
  }

  public function check_node_exist($feed_id) {
    $query = new EntityFieldQuery();
    $query->entityCondition('entity_type', 'node')
        ->entityCondition('bundle', THU_FEEDS_TYPE_SOCIAL)
        ->fieldCondition('field_feed_id', 'value', $feed_id)
        ->propertyOrderBy('created', 'DESC');

    $items = $query->execute();

    if (count($items)) {
      return array_shift($items['node'])->nid;
    }

    return 0;
  }

  public function insert_node_feed($feed, $is_update = false, $social_type = 'twitter') {
    if ($is_update) {

      $node = node_load($feed['nid']);
      unset($feed['nid']);
      //$node = entity_metadata_wrapper('node', $node_exist);
    }
    else {

      $node = new stdClass();

      // Set content type
      $node->type = THU_FEEDS_TYPE_SOCIAL;

      // Prepare defaults
      node_object_prepare($node);
      // Define language (currently language neutral)
      $node->language = LANGUAGE_NONE;

      // Basic content
      $node->title = $social_type . ' - ' . $feed['field_feed_from_id'] . ' - ' . substr($feed['field_feed_content'], 0, THU_FEEDS_LIMIT_TITLE);
    }

    if (!empty($feed[field_feed_location])) {
      $feed[field_feed_location] = json_encode($feed[field_feed_location]);
    }

    foreach ($feed as $key => $value) {
      $node->{$key}[$node->language][0]['value'] = $value;
    }

    $node->field_social_type[$node->language][0]['value'] = $social_type;
    $node->status = 0;
    $node->comment = 0;

    // Save node
    node_save($node);
  }

  public function save_feeds($feeds, $socialtype = 'twitter') {
    try {
      if (count($feeds)) {
        foreach ($feeds as $feed) {
          $feed_exist = $this->check_node_exist($feed['field_feed_id']);
          if (!$feed_exist) { // is add new
            $this->insert_node_feed($feed, FALSE, $socialtype);
          }
          else {    // is update
            $feed['nid'] = $feed_exist;
            $this->insert_node_feed($feed, TRUE, $socialtype);
          }
        }
      }
    }
    catch (Exception $ex) {
      throw new Exception('Opp!! Somethings went wrong. ' . $ex->getMessage());
    }
  }

  public static function get_lastest_feed() {

    $query = new EntityFieldQuery();
    $query->entityCondition('entity_type', 'node')
        ->entityCondition('bundle', THU_FEEDS_TYPE_SOCIAL)
        ->propertyCondition('status', 1)
        ->propertyOrderBy('created', 'DESC');
    //->extend('PagerDefault')->limit(1);

    $items = $query->execute();

    if (count($items)) {
      return node_load(array_shift($items['node'])->nid);
    }

    return NULL;
  }
}
