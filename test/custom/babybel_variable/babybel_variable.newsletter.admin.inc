<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  Implements hook_settings_form().
 */
function babybel_variable_newsletter_settings_form($form, &$form_state) {
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

  // Variable Settings for Newsletter
  $form['babybel_variable_newsletter_page'] = array(
    '#type' => 'fieldset',
    '#title' => t('Newsletter page'),
    '#group' => 'babybel_variable_tab',
  );

  // Webform
  $form['babybel_variable_newsletter_page']['webform'] = array(
    '#type' => 'fieldset',
    '#title' => t('Form input'),
  );

  $webforms = babybel_common_get_content_type('webform');
  $options_webform = array();
  if ($webforms) {
    foreach ($webforms as $id => $webform) {
      $options_webform[$id] = $webform->title . ' (' . $id . ')';
    }
  }

  $merge_option_webform = $options_webform + array(0 => 'None');
  ksort($merge_option_webform);

  $webform_id = variable_get('babybel_variable_newsletter_webform_id_' . $settings_language . '');
  $webform_exists = array_key_exists($webform_id, $merge_option_webform);

  $form['babybel_variable_newsletter_page']['webform']['babybel_variable_newsletter_webform_id_' . $settings_language . ''] = array(
    '#type' => 'select',
    '#options' => $merge_option_webform,
    '#title' => 'Webform ID',
    '#default_value' => $webform_exists ? $webform_id : 0,
  );

  // Form Input
  $form['babybel_variable_newsletter_page']['form_input'] = array(
    '#type' => 'fieldset',
    '#title' => t('Form input'),
  );

  $form['babybel_variable_newsletter_page']['form_input']['babybel_variable_newsletter_form_input_title_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Title'),
    '#default_value' => variable_get('babybel_variable_newsletter_form_input_title_' . $settings_language . ''),
    '#required' => TRUE,
  );

  $form['babybel_variable_newsletter_page']['form_input']['babybel_variable_newsletter_form_input_image_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#title' => t('Background'),
    '#description' => '(*) Suggest image size: 375x310',
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_newsletter_form_input_image_' . $settings_language . ''),
    '#upload_validators' => array(
      'file_validate_extensions' => array('png'),
    ),
    '#theme' => 'babybel_variable_background_upload',
    '#required' => TRUE,
  );


  $form['babybel_variable_newsletter_page']['form_input']['babybel_variable_newsletter_form_input_text_button_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Text in button'),
    '#default_value' => variable_get('babybel_variable_newsletter_form_input_text_button_' . $settings_language . ''),
    '#required' => TRUE,
  );

  // Form Success
  $form['babybel_variable_newsletter_page']['form_success'] = array(
    '#type' => 'fieldset',
    '#title' => t('Form success'),
  );

  $form['babybel_variable_newsletter_page']['form_success']['babybel_variable_newsletter_form_success_image_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#title' => t('Background'),
    '#description' => '(*) Suggest image size: 275x225',
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_newsletter_form_success_image_' . $settings_language . ''),
    '#upload_validators' => array(
      'file_validate_extensions' => array('png'),
    ),
    '#theme' => 'babybel_variable_background_upload',
    '#required' => TRUE,
  );

  $title = variable_get('babybel_variable_newsletter_form_success_content_' . $settings_language . '', array('value' => '', 'format' => 'plain_text'));
  $form['babybel_variable_newsletter_page']['form_success']['babybel_variable_newsletter_form_success_content_' . $settings_language . ''] = array(
    '#type' => 'text_format',
    '#title' => t('Title'),
    '#default_value' => $title['value'],
    '#format' => $title['format'],
    '#full_html' => FALSE,
    '#filter_html' => FALSE,
    '#required' => TRUE,
  );

  $form['babybel_variable_newsletter_page']['form_success']['babybel_variable_newsletter_form_success_cta_link_' . $settings_language . ''] = array(
    '#type' => 'link_field',
    '#field_name' => 'link_field',
    '#language' => $settings_language,
    '#field_parents' => array(),
    '#delta' => 0,
    '#default_value' => array(
      'title' => variable_get('babybel_variable_newsletter_form_success_cta_link_title_' . $settings_language . ''),
      'url' => variable_get('babybel_variable_newsletter_form_success_cta_link_url_' . $settings_language . ''),
      '#field_required' => TRUE,
    ),
  );

  // Message error
  $form['babybel_variable_newsletter_page']['message_error'] = array(
    '#type' => 'fieldset',
    '#title' => t('Error message'),
  );

  $form['babybel_variable_newsletter_page']['message_error']['babybel_variable_newsletter_message_error_name_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('First name and last name message error'),
    '#default_value' => strip_tags(variable_get('babybel_variable_newsletter_message_error_name_' . $settings_language . '')),
    '#required' => TRUE,
  );

  $form['babybel_variable_newsletter_page']['message_error']['babybel_variable_newsletter_message_error_email_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Email message error'),
    '#default_value' => strip_tags(variable_get('babybel_variable_newsletter_message_error_email_' . $settings_language . '')),
    '#required' => TRUE,
  );

  $form['babybel_variable_newsletter_page']['message_error']['babybel_variable_newsletter_message_error_email_exists_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Email exists message error'),
    '#default_value' => strip_tags(variable_get('babybel_variable_newsletter_message_error_email_exists_' . $settings_language . '')),
    '#required' => TRUE,
  );

  // Black-list
  $form['babybel_variable_newsletter_page']['black_list'] = array(
    '#type' => 'fieldset',
    '#title' => t('Black list'),
  );

  $form['babybel_variable_newsletter_page']['black_list']['babybel_variable_newsletter_email_blacklist_' . $settings_language] = array(
    '#type' => 'textarea',
    '#title' => t('List email'),
    '#default_value' => variable_get('babybel_variable_newsletter_email_blacklist_' . $settings_language . ''),
  );

  $form['#field_uploads'] = array('babybel_variable_newsletter_form_input_image_', 'babybel_variable_newsletter_form_success_image_');

  $form['#submit'][] = 'babybel_variable_settings_form_update_status_managed_filed';

  $form['#submit'] = array(
    'babybel_variable_settings_form_update_status_managed_filed',
    'babybel_variable_newsletter_settings_form_button_cta_link'
  );

  return system_settings_form($form);
}

function babybel_variable_newsletter_settings_form_button_cta_link(&$form, &$form_state) {
  $settings_language = babybel_variable_get_settings_language();

  $title = $form_state['values']['title'];
  $url = $form_state['values']['url'];

  if ('/' == substr($url, 0, 1)) {
    $url = substr($url, 1);
  }

  if ('www' == substr($url, 0, 3)) {
    $url = 'http://' . $url;
  }

  // Form Success
  variable_set('babybel_variable_newsletter_form_success_cta_link_title_' . $settings_language . '', $title);
  variable_set('babybel_variable_newsletter_form_success_cta_link_url_' . $settings_language . '', $url);
}

/**
 *  Implements hook_settings_form().
 */
function babybel_variable_newsletter_settings_form_validate($form, $form_state) {

  $title = $form_state['values']['title'];
  $url = $form_state['values']['url'];

  if (empty($title)) {
    form_set_error('title', t('Field title not empty'));
  }
  if (empty($url)) {
    form_set_error('url', t('Field url not empty'));
  }
}
