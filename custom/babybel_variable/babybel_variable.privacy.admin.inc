<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  Implements hook_settings_form().
 */
function babybel_variable_privacy_settings_form($form, &$form_state) {
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

  // Variable settings for privacy
  $form['babybel_variable_privacy_page'] = array(
    '#type' => 'fieldset',
    '#title' => t('Privacy page'),
    '#group' => 'babybel_variable_tab',
  );

  $pages = babybel_common_get_content_type('page');
  $options_page = array();
  if ($pages) {
    foreach ($pages as $id => $page) {
//      $options_page[$id] = $page->title . ' (' . $id . ')';
      $options_page[$page->tnid] = $page->title . ' (' . $page->tnid . ')';
    }
  }

  $merge_option_page = $options_page + array(0 => 'None');
  ksort($merge_option_page);

  $page_id = variable_get('babybel_variable_privacy_page_id_' . $settings_language . '');
  $page_exists = array_key_exists($page_id, $merge_option_page);

  $form['babybel_variable_privacy_page']['babybel_variable_privacy_page_id_' . $settings_language . ''] = array(
    '#type' => 'select',
    '#options' => $merge_option_page,
    '#title' => 'Basic pages',
    '#description' => '(*) Cover image will display on this page',
    '#default_value' => $page_exists ? $page_id : 0,
  );

  $form['babybel_variable_privacy_page']['babybel_variable_privacy_background_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#title' => t('Cover image'),
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_privacy_background_' . $settings_language . ''),
    '#theme' => 'babybel_variable_background_upload',
    //'#required' => TRUE,
  );

  // Insert image
  $form['#field_uploads'] = array('babybel_variable_privacy_background_');
  // Update status image
  $form['#submit'][] = 'babybel_variable_settings_form_update_status_managed_filed';
  
  return system_settings_form($form);
}

