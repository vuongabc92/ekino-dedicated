<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  Implements hook_settings_form().
 */
function babybel_variable_error_page_settings_form($form, &$form_state) {
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

  // Variable Settings for error page
  $form['babybel_variable_404_page'] = array(
    '#type' => 'fieldset',
    '#title' => t('404 Page'),
    '#group' => 'babybel_variable_tab',
  );

  $title = variable_get('babybel_variable_404_title_' . $settings_language . '', array('value' => '', 'format' => 'plain_text'));
  $form['babybel_variable_404_page']['babybel_variable_404_title_' . $settings_language . ''] = array(
    '#type' => 'text_format',
    '#title' => t('Title'),
    '#default_value' => $title['value'],
    '#format' => $title['format'],
    '#full_html' => FALSE,
    '#filter_html' => FALSE,
    '#required' => TRUE,
  );

  $form['babybel_variable_404_page']['babybel_variable_404_background_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#title' => t('Background'),
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_404_background_' . $settings_language . ''),
    '#theme' => 'babybel_variable_background_upload',
    //'#required' => TRUE,
  );

  $form['#field_uploads'] = array('babybel_variable_404_background_');

  $form['#submit'][] = 'babybel_variable_settings_form_update_status_managed_filed';

  return system_settings_form($form);
}

