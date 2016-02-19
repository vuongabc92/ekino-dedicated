<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  Implements hook_settings_form().
 */
function babybel_variable_news_settings_form($form, &$form_state) {
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

  // Variable Settings for News page
  $form['babybel_variable_news_page'] = array(
    '#type' => 'fieldset',
    '#title' => t('News page'),
    '#group' => 'babybel_variable_tab',
  );

  $form['babybel_variable_news_page']['general'] = array(
    '#type' => 'fieldset',
    '#title' => t('General'),
  );

  $form['babybel_variable_news_page']['general']['babybel_variable_news_text_button_' . $settings_language . ''] = array(
     '#type' => 'textfield',
     '#title' => t('Text in button'),
     '#default_value' => variable_get('babybel_variable_news_text_button_' . $settings_language . ''),
  );

  $form['babybel_variable_news_page']['general']['babybel_variable_news_text_share_' . $settings_language . ''] = array(
     '#type' => 'textfield',
     '#title' => t('Text share'),
     '#default_value' => variable_get('babybel_variable_news_text_share_' . $settings_language . ''),
  );
  $form['babybel_variable_news_page']['general']['babybel_variable_news_text_date_' . $settings_language . ''] = array(
     '#type' => 'textfield',
     '#title' => t('Text date'),
     '#default_value' => variable_get('babybel_variable_news_text_date_' . $settings_language . ''),
  );

  $form['babybel_variable_news_page']['general']['babybel_variable_news_list_social_checkbox_' . $settings_language . ''] = array(
    '#title' => t('Available social networks for sharing'),
    '#type' => 'checkboxes',
    '#default_value' => variable_get('babybel_variable_news_list_social_checkbox_' . $settings_language . ''),
    '#options' => array('fb' => 'Facebook', 'gg' => 'Google +', 'tw' => 'Twitter'),
    '#tree' => TRUE,
  );

    $form['babybel_variable_news_meta'] = array(
    '#type' => 'fieldset',
    '#title' => t('News Meta'),
    '#group' => 'babybel_variable_tab',
  );
  $form['babybel_variable_news_meta']['babybel_variable_page_title_news_' . $settings_language] = array(
    '#type' => 'textfield',
    '#title' => t('Page title'),
    '#default_value' => variable_get('babybel_variable_page_title_news_' . $settings_language . ''),
    '#description' => t("Page title"),
  );
  $form['babybel_variable_news_meta']['babybel_variable_meta_title_news_' . $settings_language] = array(
    '#type' => 'textfield',
    '#title' => t('Meta title'),
    '#default_value' => variable_get('babybel_variable_meta_title_news_' . $settings_language . ''),
    '#description' => t("Meta title"),
  );
  $form['babybel_variable_news_meta']['babybel_variable_meta_desc_news_' . $settings_language] = array(
    '#type' => 'textarea',
    '#title' => t('Meta description'),
    '#default_value' => variable_get('babybel_variable_meta_desc_news_' . $settings_language . ''),
    '#description' => t("Meta description"),
  );
  $form['babybel_variable_news_meta']['babybel_variable_meta_images_news_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#description' => t('(*) Please upload file .png extension'),
    '#title' => t('Image for social network'),
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_meta_images_news_' . $settings_language . ''),
    '#upload_validators' => array(
      'file_validate_extensions' => array('png'),
    ),
    '#theme' => 'babybel_variable_background_upload',
    //'#required' => TRUE,
  );


  return system_settings_form($form);
}
