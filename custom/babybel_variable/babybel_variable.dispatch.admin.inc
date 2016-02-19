<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  Implements hook_settings_form().
 */
function babybel_variable_dispatch_settings_form($form, &$form_state) {
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

  // Variable Settings for dispatch page
  $form['babybel_variable_dispatch_page'] = array(
    '#type' => 'fieldset',
    '#title' => t('Dispatch Page'),
    '#group' => 'babybel_variable_tab',
  );

  $form['babybel_variable_dispatch_page']['babybel_variable_dispatch_title_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Dispatch title'),
    '#default_value' => variable_get('babybel_variable_dispatch_title_' . $settings_language . ''),
    '#required' => TRUE,
  );

  $form['babybel_variable_dispatch_page']['babybel_variable_dispatch_map_sticky_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#title' => t('Map sticky'),
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_dispatch_map_sticky_' . $settings_language . ''),
    '#theme' => 'babybel_variable_background_upload',
    //'#required' => TRUE,
  );

  $form['#field_uploads'] = array('babybel_variable_dispatch_map_sticky_');

  $form['#submit'][] = 'babybel_variable_settings_form_update_status_managed_filed';

  $form['babybel_variable_dispatch_meta'] = array(
    '#type' => 'fieldset',
    '#title' => t('Dispatch Meta'),
    '#group' => 'babybel_variable_tab',
  );
  $form['babybel_variable_dispatch_meta']['babybel_variable_meta_page_dispatch_' . $settings_language] = array(
    '#type' => 'textfield',
    '#title' => t('Page title'),
    '#default_value' => variable_get('babybel_variable_meta_page_dispatch_' . $settings_language . ''),
    '#description' => t("Page title"),
  );
  $form['babybel_variable_dispatch_meta']['babybel_variable_meta_title_dispatch_' . $settings_language] = array(
    '#type' => 'textfield',
    '#title' => t('Meta title'),
    '#default_value' => variable_get('babybel_variable_meta_title_dispatch_' . $settings_language . ''),
    '#description' => t("Meta title"),
  );
  $form['babybel_variable_dispatch_meta']['babybel_variable_meta_desc_dispatch_' . $settings_language] = array(
    '#type' => 'textarea',
    '#title' => t('Meta description'),
    '#default_value' => variable_get('babybel_variable_meta_desc_dispatch_' . $settings_language . ''),
    '#description' => t("Meta description"),
  );
  $form['babybel_variable_dispatch_meta']['babybel_variable_meta_images_dispatch_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#description' => t('(*) Please upload file .png extension'),
    '#title' => t('Image for social network'),
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_meta_images_dispatch_' . $settings_language . ''),
    '#upload_validators' => array(
      'file_validate_extensions' => array('png'),
    ),
    '#theme' => 'babybel_variable_background_upload',
    //'#required' => TRUE,
  );

  return system_settings_form($form);
}
