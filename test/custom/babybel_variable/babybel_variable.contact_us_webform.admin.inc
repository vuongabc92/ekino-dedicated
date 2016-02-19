<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  Implements hook_settings_form().
 */
function babybel_variable_contact_us_webform_settings_form($form, &$form_state) {
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

  // Variable Settings for our secret blocks
  $form['babybel_variable_contact_us_blocks'] = array(
    '#type' => 'fieldset',
    '#title' => t('Error Messages for Contact Us webform'),
    '#group' => 'babybel_variable_tab',
  );

  $webforms = babybel_common_get_content_type('webform');
  $options_webform = array();
  if (!empty($webforms) && count($webforms)) {
    foreach ($webforms as $id => $webform) {
      $options_webform[$id] = $webform->title . ' (' . $id . ')';
    }
  }

  $merge_option_webform = $options_webform + array(0 => 'None');
  ksort($merge_option_webform);

  $webform_id = babybel_variable_get_nid_translated('babybel_variable_contact_us_webform_id');
  $webform_exists = array_key_exists($webform_id, $merge_option_webform);

  $form['babybel_variable_contact_us_blocks']['babybel_variable_contact_us_webform_id_' . $settings_language . ''] = array(
    '#type' => 'select',
    '#options' => $merge_option_webform,
    '#title' => 'Webforms',
    '#default_value' => $webform_exists ? $webform_id : 0,
  );

  $form['babybel_variable_contact_us_blocks']['babybel_variable_contact_us_required_field_message_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Required field error message'),
    '#default_value' => variable_get('babybel_variable_contact_us_required_field_message_' . $settings_language . ''),
  );
  
  $form['babybel_variable_contact_us_blocks']['babybel_variable_contact_us_incorrect_email_message_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Incorrect email error message'),
    '#default_value' => variable_get('babybel_variable_contact_us_incorrect_email_message_' . $settings_language . ''),
  );
  
  $form['babybel_variable_contact_us_blocks']['babybel_variable_contact_us_email_not_match_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Email 1 and Email 2 mismatch error message'),
    '#default_value' => variable_get('babybel_variable_contact_us_email_not_match_' . $settings_language . ''),
  );
  
  $form['babybel_variable_contact_us_blocks']['babybel_variable_contact_us_type_phone_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t(' Incorrect phone number error message'),
    '#default_value' => variable_get('babybel_variable_contact_us_type_phone_' . $settings_language . ''),
  );
  
  return system_settings_form($form);
}
