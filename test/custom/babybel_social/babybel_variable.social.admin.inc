<?php

/**
 * @file
 * Social Feed module admin inc file.
 *
 * Contains admin configuration page callback functions.
 */

/**
 * Form builder; Configure social feeds settings for this site.
 *
 * @ingroup forms
 *
 * @see system_settings_form()
 */
function babybel_variable_social_settings_form($form, &$form_state) {
  
  $settings_language = babybel_variable_get_settings_language();
  if (!$form_state['rebuild']) {
    babybel_variable_set_language_warning_message($settings_language);
  }

  $settings_links = babybel_variable_settings_language_switcher();
  $form['settings_links'] = array(
    '#markup' => $settings_links
  );
  $form['lang'] = array(
    '#type' => 'hidden',
    '#value' => $settings_language,
  );

  $form['babybel_variable_tab'] = array(
    '#type' => 'vertical_tabs',
  );
  // Variable Settings for Cherity Blocks
  $form['babybel_variable_social_blocks'] = array(
    '#type' => 'fieldset',
    '#title' => t('Social feeds setting'),
    '#group' => 'babybel_variable_tab',
  );
  $form['babybel_variable_social_blocks']['babybel_variable_social_feed_title_'.$settings_language.''] = array(
    '#type' => 'textfield',
    '#title' => t('Title'),
    '#default_value' => variable_get('babybel_variable_social_feed_title_'.$settings_language.''),
    '#size' => 60,
    '#maxlength' => 100,
    '#required' => TRUE,
  );  
  $form['babybel_variable_social_blocks']['babybel_variable_social_feed_display_title_'.$settings_language.''] = array(
    '#type' => 'checkbox',
    '#title' => t('Display title'),
    '#default_value' => variable_get('babybel_variable_social_feed_display_title_'.$settings_language.'', TRUE),
  );
  
  // Facebook setting
  $form['babybel_variable_social_blocks']['facebook_setting'] = array(
    '#type' => 'fieldset',
    '#title' => t('Facebook setting'),
  );
  
  $form['babybel_variable_social_blocks']['facebook_setting']['babybel_variable_social_facebook_page_name_'.$settings_language.''] = array(
    '#type' => 'textfield',
    '#title' => t('Facebook Page Name'),
    '#default_value' => variable_get('babybel_variable_social_facebook_page_name_'.$settings_language.''),
    '#description' => t('eg. If you have a Facebook page with a URL like this: https://www.facebook.com/your-page-name then the Page ID is just your-page-name. If your page URL is structured like this: https://www.facebook.com/pages/your-page-name/123654123654123 then the Page ID is actually the number at the end, so in this case 123654123654123.'),
    '#size' => 60,
    '#maxlength' => 100,
  );
  $form['babybel_variable_social_blocks']['facebook_setting']['babybel_variable_social_display_homepage_'.$settings_language.''] = array(
    '#type' => 'checkbox',
    '#title' => t('Display on the homepage'),
    '#default_value' => variable_get('babybel_variable_social_display_homepage_'.$settings_language.'', TRUE),
  );
  
 // Twitter setting
  $form['babybel_variable_social_blocks']['twitter_setting'] = array(
    '#type' => 'fieldset',
    '#title' => t('Twitter setting'),
  );
  
  $form['babybel_variable_social_blocks']['twitter_setting']['babybel_variable_social_twitter_username_'.$settings_language.''] = array(
    '#type' => 'textfield',
    '#title' => t('Twitter User Name'),
    '#default_value' => variable_get('babybel_variable_social_twitter_username_'.$settings_language.''),
    '#size' => 60,
    '#maxlength' => 100,
  );
  $form['babybel_variable_social_blocks']['twitter_setting']['babybel_variable_social_twitter_display_homepage_'.$settings_language.''] = array(
    '#type' => 'checkbox',
    '#title' => t('Display on the homepage'),
    '#default_value' => variable_get('babybel_variable_social_twitter_display_homepage_'.$settings_language.'', TRUE),
  );
  
  // instagram setting
  $form['babybel_variable_social_blocks']['instagram_setting'] = array(
    '#type' => 'fieldset',
    '#title' => t('Instagram setting'),
  );
  $form['babybel_variable_social_blocks']['instagram_setting']['babybel_variable_social_instagram_user_id_'.$settings_language.''] = array(
    '#type' => 'textfield',
    '#title' => t('User ID'),
    '#description' => t('Fetch the Instagram User ID from <a href="@jelled" target="@blank">here</a>.', array('@jelled' => 'http://jelled.com/instagram/lookup-user-id', '@blank' => '_blank')),
    '#default_value' => variable_get('babybel_variable_social_instagram_user_id_'.$settings_language.''),
    '#size' => 60,
    '#maxlength' => 100,
  );  
  $form['babybel_variable_social_blocks']['instagram_setting']['babybel_variable_social_instagram_display_homepage_'.$settings_language.''] = array(
    '#type' => 'checkbox',
    '#title' => t('Display on the homepage'),
    '#default_value' => variable_get('babybel_variable_social_instagram_display_homepage_'.$settings_language.'', TRUE),
  );
  return system_settings_form($form);
}

function babybel_variable_social_credentials_settings_form($form, &$form_state) {
  
  $form['babybel_variable_babybel_variable_feeds_credentials_tab'] = array(
    '#type' => 'vertical_tabs',
  );
  // Variable Settings for Cherity Blocks
  $form['babybel_variable_social_feeds_credentials'] = array(
    '#type' => 'fieldset',
    '#title' => t('Social feeds credentials setting'),
    '#group' => 'babybel_variable_babybel_variable_feeds_credentials_tab',
  );
  // Facebook setting
  $form['babybel_variable_social_feeds_credentials']['facebook_setting'] = array(
    '#type' => 'fieldset',
    '#title' => t('Facebook setting'),
  );
  $form['babybel_variable_social_feeds_credentials']['facebook_setting']['babybel_variable_social_facebook_app_id'] = array(
    '#type' => 'textfield',
    '#title' => t('Facebook App ID'),
    '#default_value' => variable_get('babybel_variable_social_facebook_app_id'),
    '#size' => 60,
    '#maxlength' => 100,
  );
  $form['babybel_variable_social_feeds_credentials']['facebook_setting']['babybel_variable_social_facebook_secret_key'] = array(
    '#type' => 'textfield',
    '#title' => t('Facebook Secret Key'),
    '#default_value' => variable_get('babybel_variable_social_facebook_secret_key'),
    '#size' => 60,
    '#maxlength' => 100,
  );
  // Twitter setting
  $form['babybel_variable_social_feeds_credentials']['twitter_setting'] = array(
    '#type' => 'fieldset',
    '#title' => t('Twitter setting'),
  );
  $form['babybel_variable_social_feeds_credentials']['twitter_setting']['babybel_variable_social_twitter_access_token'] = array(
    '#type' => 'textfield',
    '#title' => t('Twitter Access Token'),
    '#default_value' => variable_get('babybel_variable_social_twitter_access_token'),
    '#size' => 60,
    '#maxlength' => 100,
  );
  $form['babybel_variable_social_feeds_credentials']['twitter_setting']['babybel_variable_social_twitter_access_token_secret'] = array(
    '#type' => 'textfield',
    '#title' => t('Twitter Access Token Secret'),
    '#default_value' => variable_get('babybel_variable_social_twitter_access_token_secret'),
    '#size' => 60,
    '#maxlength' => 100,
  );
  $form['babybel_variable_social_feeds_credentials']['twitter_setting']['babybel_variable_social_twitter_consumer_key'] = array(
    '#type' => 'textfield',
    '#title' => t('Twitter Consumer Key'),
    '#default_value' => variable_get('babybel_variable_social_twitter_consumer_key'),
    '#size' => 60,
    '#maxlength' => 100,
  );
  $form['babybel_variable_social_feeds_credentials']['twitter_setting']['babybel_variable_social_twitter_consumer_secret'] = array(
    '#type' => 'textfield',
    '#title' => t('Twitter Consumer Secret'),
    '#default_value' => variable_get('babybel_variable_social_twitter_consumer_secret'),
    '#size' => 60,
    '#maxlength' => 100,
  );
  // instagram setting
  $form['babybel_variable_social_feeds_credentials']['instagram_setting'] = array(
    '#type' => 'fieldset',
    '#title' => t('Instagram setting'),
  );
  $form['babybel_variable_social_feeds_credentials']['instagram_setting']['babybel_variable_social_instagram_api_key'] = array(
    '#type' => 'textfield',
    '#title' => t('API Key'),
    '#default_value' => variable_get('babybel_variable_social_instagram_api_key'),
    '#size' => 60,
    '#maxlength' => 100,
  );
  $form['babybel_variable_social_feeds_credentials']['instagram_setting']['babybel_variable_social_instagram_api_secret'] = array(
    '#type' => 'textfield',
    '#title' => t('API Secret'),
    '#default_value' => variable_get('babybel_variable_social_instagram_api_secret'),
    '#size' => 60,
    '#maxlength' => 100,
  );
  return system_settings_form($form);
}