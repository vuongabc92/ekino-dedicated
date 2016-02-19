<?php

/**
 * @file
 * Content form upload logo for header and footer
 */
function v2_menu_form_logo($form, &$form_state) {

  $form['logo']['logo_header_desktop'] = array(
    '#type' => 'managed_file',
    '#title' => 'Logo header',
    '#default_value' => variable_get('logo_header_desktop'),
    '#description' => t("Logo will display on desktop and tablet."),
    '#upload_location' => 's3://',
    '#upload_validators' => array(
      'file_validate_extensions' => array('gif png jpg jpeg svg'),
    // Pass the maximum file size in bytes
    ),
  );
  $form['logo']['logo_header_mobile'] = array(
    '#type' => 'managed_file',
    '#title' => 'Logo header for mobile',
    '#default_value' => variable_get('logo_header_mobile'),
    '#description' => t("Logo will display on mobile."),
    '#upload_location' => 's3://',
    '#upload_validators' => array(
      'file_validate_extensions' => array('gif png jpg jpeg svg'),
    // Pass the maximum file size in bytes
    ),
  );
  $form['logo']['logo_footer_desktop'] = array(
    '#type' => 'managed_file',
    '#title' => 'Logo footer',
    '#default_value' => variable_get('logo_footer_desktop'),
    '#description' => t("Logo will display on desktop and tablet."),
    '#upload_location' => 's3://',
    '#upload_validators' => array(
      'file_validate_extensions' => array('gif png jpg jpeg svg'),
    // Pass the maximum file size in bytes
    ),
  );
  $form['logo']['logo_footer_mobile'] = array(
    '#type' => 'managed_file',
    '#title' => 'Logo footer for mobile',
    '#default_value' => variable_get('logo_footer_mobile'),
    '#description' => t("Logo will display on mobile."),
    '#upload_location' => 's3://',
    '#upload_validators' => array(
      'file_validate_extensions' => array('gif png jpg jpeg svg'),
    // Pass the maximum file size in bytes
    ),
  );

  $form['actions']['#type'] = 'actions';
  $form['actions']['submit'] = array('#type' => 'submit', '#value' => t('Save configuration'));

  if (!empty($_POST) && form_get_errors()) {
    drupal_set_message(t('The settings have not been saved because of the errors.'), 'error');
  }
  $form['#submit'][] = 'v2_menu_form_logo_submit';
  // By default, render the form using theme_system_settings_form().
  if (!isset($form['#theme'])) {
    $form['#theme'] = 'system_settings_form';
  }

  return $form;
}

function v2_menu_form_logo_submit($form, &$form_state) {
  // Array logo.
  global $user;
  $logo_arr = array('logo_header_desktop', 'logo_header_mobile', 'logo_footer_desktop', 'logo_footer_mobile');
  foreach ($logo_arr as $value) {
    $logo = file_load($form_state['input'][$value]['fid']);
    if ($logo) {
      $logo->status = FILE_STATUS_PERMANENT;
      file_save($logo);
      // Record that the module (in this example, user module) is using the file.
      file_usage_add($logo, 'v2_menu', 'v2_menu', $user->uid);
    }
  }

  // Exclude unnecessary elements.
  form_state_values_clean($form_state);

  foreach ($form_state['values'] as $key => $value) {
    variable_set($key, $value);
  }

  drupal_set_message(t('The configuration options have been saved.'));
}
