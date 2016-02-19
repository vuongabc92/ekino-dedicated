<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  Implements hook_settings_form().
 */
function babybel_variable_basicpage_settings_form($form, &$form_state)
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

  // Term & Conditional meta
  $form['babybel_variable_termconditions_meta'] = array(
    '#type' => 'fieldset',
    '#title' => t('Term Conditions Meta'),
    '#group' => 'babybel_variable_tab',
  );
  $form['babybel_variable_termconditions_meta']['babybel_variable_page_title_termconditions_' . $settings_language] = array(
    '#type' => 'textfield',
    '#title' => t('Page title'),
    '#default_value' => variable_get('babybel_variable_page_title_termconditions_' . $settings_language . ''),
    '#description' => t("Page title"),
  );
  $form['babybel_variable_termconditions_meta']['babybel_variable_meta_title_termconditions_' . $settings_language] = array(
    '#type' => 'textfield',
    '#title' => t('Meta title'),
    '#default_value' => variable_get('babybel_variable_meta_title_termconditions_' . $settings_language . ''),
    '#description' => t("Meta title"),
  );
  $form['babybel_variable_termconditions_meta']['babybel_variable_meta_desc_termconditions_' . $settings_language] = array(
    '#type' => 'textarea',
    '#title' => t('Meta description'),
    '#default_value' => variable_get('babybel_variable_meta_desc_termconditions_' . $settings_language . ''),
    '#description' => t("Meta description"),
  );
  $form['babybel_variable_termconditions_meta']['babybel_variable_meta_images_termconditions_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#description' => t('(*) Please upload file .png extension'),
    '#title' => t('Image for social network'),
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_meta_images_termconditions_' . $settings_language . ''),
    '#upload_validators' => array(
      'file_validate_extensions' => array('png'),
    ),
    '#theme' => 'babybel_variable_background_upload',
  );

  //Private meta
  $form['babybel_variable_privacy_meta'] = array(
    '#type' => 'fieldset',
    '#title' => t('Privacy Meta'),
    '#group' => 'babybel_variable_tab',
  );
  $form['babybel_variable_privacy_meta']['babybel_variable_page_title_privacy_' . $settings_language] = array(
    '#type' => 'textfield',
    '#title' => t('Page title'),
    '#default_value' => variable_get('babybel_variable_page_title_privacy_' . $settings_language . ''),
    '#description' => t("Page title"),
  );
  $form['babybel_variable_privacy_meta']['babybel_variable_meta_title_privacy_' . $settings_language] = array(
    '#type' => 'textfield',
    '#title' => t('Meta title'),
    '#default_value' => variable_get('babybel_variable_meta_title_privacy_' . $settings_language . ''),
    '#description' => t("Meta title"),
  );
  $form['babybel_variable_privacy_meta']['babybel_variable_meta_desc_privacy_' . $settings_language] = array(
    '#type' => 'textarea',
    '#title' => t('Meta description'),
    '#default_value' => variable_get('babybel_variable_meta_desc_privacy_' . $settings_language . ''),
    '#description' => t("Meta description"),
  );
  $form['babybel_variable_privacy_meta']['babybel_variable_meta_images_privacy_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#description' => t('(*) Please upload file .png extension'),
    '#title' => t('Image for social network'),
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_meta_images_privacy_' . $settings_language . ''),
    '#upload_validators' => array(
      'file_validate_extensions' => array('png'),
    ),
    '#theme' => 'babybel_variable_background_upload',
  );

  $form['#field_uploads'] = array(
    'babybel_variable_meta_images_termconditions_',
    'babybel_variable_meta_images_privacy_'
  );
  $form['#submit'][] = 'babybel_variable_settings_form_update_status_managed_filed';
  
// Default Meta
  $form['babybel_variable_default_meta'] = array(
    '#type' => 'fieldset',
    '#title' => t('Default Meta'),
    '#group' => 'babybel_variable_tab',
  );
  $form['babybel_variable_default_meta']['babybel_variable_meta_title_default_' . $settings_language] = array(
    '#type' => 'textfield',
    '#title' => t('Meta title'),
    '#default_value' => variable_get('babybel_variable_meta_title_default_' . $settings_language . ''),
    '#description' => t("Meta title"),
  );
  $form['babybel_variable_default_meta']['babybel_variable_meta_desc_default_' . $settings_language] = array(
    '#type' => 'textarea',
    '#title' => t('Meta description'),
    '#default_value' => variable_get('babybel_variable_meta_desc_default_' . $settings_language . ''),
    '#description' => t("Meta description"),
  );
  return system_settings_form($form);
}
