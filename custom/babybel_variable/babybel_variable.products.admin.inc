<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  Implements hook_settings_form().
 */
function babybel_variable_products_settings_form($form, &$form_state) {
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

  // Variable Settings for Products Blocks
  $form['babybel_variable_products_blocks'] = array(
    '#type' => 'fieldset',
    '#title' => t('Products Blocks'),
    '#group' => 'babybel_variable_tab',
  );

  // Products page info
  $form['babybel_variable_products_blocks']['products_page_info'] = array(
    '#type' => 'fieldset',
    '#title' => t('Products page info'),
  );

  $form['babybel_variable_products_blocks']['products_page_info']['babybel_variable_products_title_products_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Products title'),
    '#default_value' => variable_get('babybel_variable_products_title_products_' . $settings_language . ''),
    '#required' => TRUE,
  );

  $form['babybel_variable_products_blocks']['products_page_info']['babybel_variable_products_subtitle_products_' . $settings_language . ''] = array(
    '#type' => 'textarea',
    '#title' => t('Products subtitle'),
    '#default_value' => variable_get('babybel_variable_products_subtitle_products_' . $settings_language . ''),
    '#required' => TRUE,
  );

  $form['babybel_variable_products_blocks']['products_page_info']['babybel_variable_products_products_page_background_header_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#title' => t('Background header'),
    '#description' => 'Suggested image sizes: 1440x492',
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_products_products_page_background_header_' . $settings_language . ''),
    '#theme' => 'babybel_variable_background_upload',
  );

  $form['babybel_variable_products_blocks']['products_page_info']['babybel_variable_products_products_page_background_footer_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#description' => t('(*) Please upload file .png extension. <br/> Suggested image sizes: 940x576.'),
    '#title' => t('Background footer'),
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_products_products_page_background_footer_' . $settings_language . ''),
    '#upload_validators' => array(
      'file_validate_extensions' => array('png'),
    ),
    '#theme' => 'babybel_variable_background_upload',
  );

  // Push block
  $form['babybel_variable_products_blocks']['push_block'] = array(
    '#type' => 'fieldset',
    '#title' => t('Push block'),
  );

  $form['babybel_variable_products_blocks']['push_block']['babybel_variable_products_push_block_title_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Push block title'),
    '#default_value' => variable_get('babybel_variable_products_push_block_title_' . $settings_language . ''),
  );

  $form['babybel_variable_products_blocks']['push_block']['babybel_variable_products_push_block_cta_link_' . $settings_language . ''] = array(
    '#type' => 'link_field',
    '#field_name' => 'link_field',
    '#language' => $settings_language,
    '#field_parents' => array(),
    '#delta' => 0,
    '#default_value' => array(
      'title' => variable_get('babybel_variable_products_push_block_cta_link_title_' . $settings_language . ''),
      'url' => variable_get('babybel_variable_products_push_block_cta_link_url_' . $settings_language . ''),
    ),
  );

  $form['babybel_variable_products_blocks']['push_block']['babybel_variable_products_push_block_desktop_img_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#title' => t('Desktop image'),
    '#description' => t('(*) Please upload file .png extension'),
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_products_push_block_desktop_img_' . $settings_language . ''),
    '#upload_validators' => array(
      'file_validate_extensions' => array('png'),
    ),
    '#theme' => 'babybel_variable_background_upload',
  );

  $form['babybel_variable_products_blocks']['push_block']['babybel_variable_products_push_block_tablet_img_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#description' => t('(*) Please upload file .png extension'),
    '#title' => t('Tablet image'),
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_products_push_block_tablet_img_' . $settings_language . ''),
    '#upload_validators' => array(
      'file_validate_extensions' => array('png'),
    ),
    '#theme' => 'babybel_variable_background_upload',
  );

  $form['babybel_variable_products_meta'] = array(
    '#type' => 'fieldset',
    '#title' => t('Products Meta'),
    '#group' => 'babybel_variable_tab',
  );
  $form['babybel_variable_products_meta']['babybel_variable_page_title_products_' . $settings_language] = array(
    '#type' => 'textfield',
    '#title' => t('Page title'),
    '#default_value' => variable_get('babybel_variable_page_title_products_' . $settings_language . ''),
    '#description' => t("Page title"),
  );
  $form['babybel_variable_products_meta']['babybel_variable_meta_title_products_' . $settings_language] = array(
    '#type' => 'textfield',
    '#title' => t('Meta title'),
    '#default_value' => variable_get('babybel_variable_meta_title_products_' . $settings_language . ''),
    '#description' => t("Meta title"),
  );
  $form['babybel_variable_products_meta']['babybel_variable_meta_desc_products_' . $settings_language] = array(
    '#type' => 'textarea',
    '#title' => t('Meta description'),
    '#default_value' => variable_get('babybel_variable_meta_desc_products_' . $settings_language . ''),
    '#description' => t("Meta description"),
  );
  $form['babybel_variable_products_meta']['babybel_variable_meta_images_products_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#description' => t('(*) Please upload file .png extension'),
    '#title' => t('Image for social network'),
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_meta_images_products_' . $settings_language . ''),
    '#upload_validators' => array(
      'file_validate_extensions' => array('png'),
    ),
    '#theme' => 'babybel_variable_background_upload',
  );

  $form['#field_uploads'] = array(
    'babybel_variable_products_products_page_background_footer_',
    'babybel_variable_products_products_page_background_header_',
    'babybel_variable_products_push_block_tablet_img_',
    'babybel_variable_products_push_block_desktop_img_',
    'babybel_variable_meta_images_products_',
  );

  $form['#submit'] = array(
    'babybel_variable_settings_form_update_status_managed_filed',
    'babybel_variable_products_settings_form_button_cta_link'
  );

  return system_settings_form($form);
}

function babybel_variable_products_settings_form_button_cta_link(&$form, &$form_state) {
  $settings_language = babybel_variable_get_settings_language();

  $title = $form_state['values']['title'];
  $url = $form_state['values']['url'];

  if ('/' == substr($url, 0, 1)) {
    $url = substr($url, 1);
  }

  if ('www' == substr($url, 0, 3)) {
    $url = 'http://' . $url;
  }

  variable_set('babybel_variable_products_push_block_cta_link_title_' . $settings_language . '', $title);
  variable_set('babybel_variable_products_push_block_cta_link_url_' . $settings_language . '', $url);
}
