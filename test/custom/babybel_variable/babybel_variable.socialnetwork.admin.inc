<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  Implements hook_settings_form().
 */
function babybel_variable_social_network_settings_form($form, &$form_state)
{
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

  // Variable Settings for social network
  $form['babybel_variable_social_app_page'] = array(
    '#type' => 'fieldset',
    '#title' => t('Social Networks & mobile app links configuration'),
    '#group' => 'babybel_variable_tab',
  );

  // Facebook
  $form['babybel_variable_social_app_page']['facebook'] = array(
    '#type' => 'fieldset',
    '#title' => t('Facebook'),
  );

  $form['babybel_variable_social_app_page']['facebook']['babybel_variable_facebook_title_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Title'),
    '#default_value' => variable_get('babybel_variable_facebook_title_' . $settings_language . ''),
  );

  $form['babybel_variable_social_app_page']['facebook']['babybel_variable_facebook_url_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Url'),
    '#default_value' => variable_get('babybel_variable_facebook_url_' . $settings_language . ''),
  );

  // Twitter
  $form['babybel_variable_social_app_page']['twitter'] = array(
    '#type' => 'fieldset',
    '#title' => t('Twitter'),
  );

  $form['babybel_variable_social_app_page']['twitter']['babybel_variable_twitter_title_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Title'),
    '#default_value' => variable_get('babybel_variable_twitter_title_' . $settings_language . ''),
  );

  $form['babybel_variable_social_app_page']['twitter']['babybel_variable_twitter_url_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Url'),
    '#default_value' => variable_get('babybel_variable_twitter_url_' . $settings_language . ''),
  );

  // Youtube Chanel
  $form['babybel_variable_social_app_page']['youtube'] = array(
    '#type' => 'fieldset',
    '#title' => t('Youtube'),
  );

  $form['babybel_variable_social_app_page']['youtube']['babybel_variable_youtube_title_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Title'),
    '#default_value' => variable_get('babybel_variable_youtube_title_' . $settings_language . ''),
  );

  $form['babybel_variable_social_app_page']['youtube']['babybel_variable_youtube_url_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Url'),
    '#default_value' => variable_get('babybel_variable_youtube_url_' . $settings_language . ''),
  );

  // Instagram
  $form['babybel_variable_social_app_page']['instagram'] = array(
    '#type' => 'fieldset',
    '#title' => t('Instagram'),
  );

  $form['babybel_variable_social_app_page']['instagram']['babybel_variable_instagram_title_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Title'),
    '#default_value' => variable_get('babybel_variable_instagram_title_' . $settings_language . ''),
  );

  $form['babybel_variable_social_app_page']['instagram']['babybel_variable_instagram_url_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Url'),
    '#default_value' => variable_get('babybel_variable_instagram_url_' . $settings_language . ''),
  );

  // Appstore
  $form['babybel_variable_social_app_page']['appstore'] = array(
    '#type' => 'fieldset',
    '#title' => t('Appstore'),
  );

  $form['babybel_variable_social_app_page']['appstore']['babybel_variable_appstore_icon_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#title' => t('Logo'),
    '#description' => "Get your localized badge at <a href='https://developer.apple.com/app-store/marketing/guidelines/#downloadOnAppstore'>https://developer.apple.com/app-store/marketing/guidelines/#downloadOnAppstore</a>",
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_appstore_icon_' . $settings_language . ''),
    '#theme' => 'babybel_variable_background_upload',
    //'#required' => TRUE,
  );

  $form['babybel_variable_social_app_page']['appstore']['babybel_variable_appstore_title_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Title'),
    '#default_value' => variable_get('babybel_variable_appstore_title_' . $settings_language . ''),
  );

  $form['babybel_variable_social_app_page']['appstore']['babybel_variable_appstore_url_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Url'),
    '#default_value' => variable_get('babybel_variable_appstore_url_' . $settings_language . ''),
  );

  // Google Play
  $form['babybel_variable_social_app_page']['google_play'] = array(
    '#type' => 'fieldset',
    '#title' => t('Google Play'),
  );

  $form['babybel_variable_social_app_page']['google_play']['babybel_variable_google_play_icon_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#title' => t('Logo'),
    '#description' => "Get your localized badge at <a href='https://developer.android.com/distribute/tools/promote/badges.html'>https://developer.android.com/distribute/tools/promote/badges.html</a>",
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_google_play_icon_' . $settings_language . ''),
    '#theme' => 'babybel_variable_background_upload',
    //'#required' => TRUE,
  );

  $form['babybel_variable_social_app_page']['google_play']['babybel_variable_google_play_title_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Title'),
    '#default_value' => variable_get('babybel_variable_google_play_title_' . $settings_language . ''),
  );

  $form['babybel_variable_social_app_page']['google_play']['babybel_variable_google_play_url_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Url'),
    '#default_value' => variable_get('babybel_variable_google_play_url_' . $settings_language . ''),
  );

  $form['#field_uploads'] = array('babybel_variable_appstore_icon_', 'babybel_variable_google_play_icon_');

  $form['#submit'][] = 'babybel_variable_settings_form_update_status_managed_filed';

  return system_settings_form($form);
}

