<?php

class TBYoutubeFeed extends TBSocialFeed {

  function __construct($cfg = NULL) {
    $this->configs = $cfg;
    $this->configs['max_results'] = ($cfg['feed_limit'] > 50) ? 50 : $cfg['feed_limit'];
    $this->configs['alt'] = 'json';
  }

  function getType() {
    return "Youtube";
  }

  public function getContent() {
    $apikey = variable_get('youtube_api_key', '');
//    $endpoint = 'http://gdata.youtube.com/feeds/api/videos?q=%s&v=2&max-results=%s';
    $endpoint = 'https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=%s&order=date&maxResults=%s&key=%s';
    $fullurl = sprintf($endpoint, $this->configs['account'], $this->configs['max_results'], $apikey);
    $raw = file_get_contents($fullurl);
    $data = json_decode($raw);
    $results = array();
    $list = $data->items;
    if (is_array($list) && count($list)) {
      foreach ($list as $l) {
//        $row = $list[$i];
        $result = array();
        $result['title'] = (isset($l->snippet->title)) ? utf8_encode('[Youtube] ' . $l->snippet->title) : utf8_encode(t('Youtube feed'));
        $video_id = $l->id->videoId;
        $result['field_youtube'] = $result['field_reference_url'] = $result['reference_url'] = 'http://www.youtube.com/watch?v=' . $video_id;
        $result['changed'] = strtotime($l->snippet->publishedAt);
        $result['created'] = strtotime($l->snippet->publishedAt);
        $result['body'] = utf8_encode($l->snippet->description);
        $result['field_social_feed_type'] = $this->getType();
        $result['node_type'] = $this->getBundle();
        $result['feed_id'] = $video_id;
        $result['status'] = 0;
        $result['url'] = 'http://www.youtube.com/watch?v=' . $video_id;
        $result['service'] = 'youtube';
        $result['account'] = $this->configs['account'];
        $results[] = $result;
      }
    }
    return $results;
  }

  function createAccountForm($account, &$form) {
    $form = array(
      '#type' => 'fieldset',
      '#title' => t("Channels")
    );
    $form[$account->service . '_feed_account_name[]'] = array(
      '#type' => 'hidden',
      '#size' => 8,
      '#title' => t("Channel ID"),
      '#default_value' => isset($account->account_name) ? $account->account_name : ""
    );
    $form[$account->service . '_feed_account[]'] = array(
      '#type' => 'textfield',
      '#size' => 8,
      '#title' => t("Youtube Channel ID"),
      '#default_value' => isset($account->account) ? $account->account : "",
      '#description' => t("Enter your Youtube Channel ID. Ex: www.youtube.com/channel/UCmKurapML4BF9Bjtj4RbvXw ( UCmKurapML4BF9Bjtj4RbvXw is Channel ID )."),
      '#attributes' => array('class' => array('account')),
    );
    $form[$account->service . '_feed_current_account[]'] = array(
      '#type' => 'hidden',
      '#value' => isset($account->account) ? $account->account : ""
    );
//    $form[$account->service . '_feed_account_verify'] = array(
//      '#markup' => '<a href="javascript:void(0)" class="form-submit btn-verify-account" onclick="Drupal.TBFeed.verifyAccount(\'http://gdata.youtube.com/feeds/api/videos?q=\', this)">' . t('Check feed') . '</a><br/>',
//    );
    $form[$account->service . '_feed_account_delete'] = array(
      '#markup' => '<a href="javascript:void(0)" class="btn btn-delete-account" onclick="Drupal.TBFeed.deleteAccount(this)">' . t('Delete') . '</a>',
    );
  }

  function createFeedLimitForm($service, &$form) {
    $form[$service->service . "_feed_limit"] = array(
      '#type' => 'textfield',
      '#title' => t("Feed Limit"),
      '#value' => $service->feed_limit,
      '#description' => t('The valid number of feed items for Youtube should not be higher than 50.'),
    );
  }

  public function createServiceForm($service, &$form) {
    // Require user input app_id and app_secret.
    $apikey = variable_get('youtube_api_key', '');
    if ($apikey != "") {
      parent::createServiceForm($service, $form);
    }
    else {
      $form[$service->service . "_enable"] = array(
        '#type' => 'checkbox',
        '#title' => t("Enable"),
        '#value' => $service->enabled,
        '#disabled' => TRUE,
        '#description' => t('To enable and get feeds, please link to <a href="' . url('admin/config/feed/tb_social_feed') . '"> This </a> and input your app id and app secret.')
      );
    }
  }

  /**
   * Save settings social services.
   * 
   * @param type $values
   */
  public function saveSettingForm($values) {
    if (isset($values['youtube_app_api_key'])) {
      variable_set('youtube_api_key', $values['youtube_app_api_key']);
    }
  }

  /**
   * Create a settings form on configuration page.
   * 
   * @param stdClass $service
   * @param array $form
   */
  public function createSettingsForm($service, &$form) {
    $name_service = $service->service;
    $form[$name_service . '_application'] = array(
      '#type' => 'fieldset',
      '#title' => t($service->service . " Application"),
      '#weight' => -1,
    );
    $form_app = $form[$name_service . '_application'];
    $form_app[$name_service . '_app_api_key'] = array(
      '#type' => 'textfield',
      '#title' => t('API KEY'),
      '#description' => t('Please fill API KEY of your youtube application.'),
      '#size' => 8,
      '#default_value' => variable_get('youtube_api_key', ''),
    );
    $form[$name_service . '_application'] = $form_app;
  }

}
