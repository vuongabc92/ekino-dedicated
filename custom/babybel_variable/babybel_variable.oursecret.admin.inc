<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  Implements hook_settings_form().
 */
function babybel_variable_our_secret_settings_form($form, &$form_state) {
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
  $form['babybel_variable_our_secret_blocks'] = array(
    '#type' => 'fieldset',
    '#title' => t('Our secret blocks'),
    '#group' => 'babybel_variable_tab',
  );

  $articles = babybel_common_get_content_type('article');
  $options_article = array();
  if ($articles) {
    foreach ($articles as $id => $article) {
      $options_article[$id] = $article->title . ' (' . $id . ')';
    }
  }

  $merge_option_article = $options_article + array(0 => 'None');
  ksort($merge_option_article);

  $our_secret_id = babybel_variable_get_nid_translated('babybel_variable_our_secret_id');
  $our_secret_exists = array_key_exists($our_secret_id, $merge_option_article);

  $form['babybel_variable_our_secret_blocks']['babybel_variable_our_secret_id_' . $settings_language . ''] = array(
    '#type' => 'select',
    '#options' => $merge_option_article,
    '#title' => 'Secret recipe',
    '#default_value' => $our_secret_exists ? $our_secret_id : 0,
  );

  $blocks_milk_id = babybel_variable_get_nid_translated('babybel_variable_our_secret_blocks_milk_id');
  $blocks_milk_exists = array_key_exists($blocks_milk_id, $merge_option_article);

  $form['babybel_variable_our_secret_blocks']['babybel_variable_our_secret_blocks_milk_id_' . $settings_language . ''] = array(
    '#type' => 'select',
    '#options' => $merge_option_article,
    '#title' => 'Milk origin',
    '#default_value' => $blocks_milk_exists ? $blocks_milk_id : 0,
  );

  $cheeses = babybel_common_get_content_type('cheese_making');
  $options_cheese = array();
  if ($cheeses) {
    foreach ($cheeses as $id => $cheese) {
      $options_cheese[$id] = $cheese->title . ' (' . $id . ')';
    }
  }

  $merge_option_cheese = $options_cheese + array(0 => 'None');
  ksort($merge_option_cheese);

  $cheese_id = babybel_variable_get_nid_translated('babybel_variable_our_secret_cheese_id');
  $cheese_exists = array_key_exists($cheese_id, $merge_option_cheese);

  $form['babybel_variable_our_secret_blocks']['babybel_variable_our_secret_cheese_id_' . $settings_language . ''] = array(
    '#type' => 'select',
    '#options' => $merge_option_cheese,
    '#title' => 'Cheese making secrets',
    '#default_value' => $cheese_exists ? $cheese_id : 0,
  );

  $form['babybel_variable_our_secret_blocks']['babybel_variable_our_secret_background_header_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#title' => t('Cover image'),
    '#description' => '(*) Suggested image sizes: 1440x492',
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_our_secret_background_header_' . $settings_language . ''),
    '#theme' => 'babybel_variable_background_upload',
    //'#required' => TRUE,
  );

  $form['babybel_variable_our_secret_blocks']['babybel_variable_our_secret_button_text_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Our secret button text'),
    '#default_value' => variable_get('babybel_variable_our_secret_button_text_' . $settings_language . ''),
    '#required' => TRUE,
  );

  // Variable Settings for our secret meta
  $form['babybel_variable_our_secret_meta'] = array(
    '#type' => 'fieldset',
    '#title' => t('Our secret meta'),
    '#group' => 'babybel_variable_tab',
  );
  $form['babybel_variable_our_secret_meta']['babybel_variable_page_title_our_secret_' . $settings_language] = array(
    '#type' => 'textfield',
    '#title' => t('Page title'),
    '#default_value' => variable_get('babybel_variable_page_title_our_secret_' . $settings_language . ''),
    '#description' => t("Page title"),
  );
  $form['babybel_variable_our_secret_meta']['babybel_variable_meta_title_our_secret_' . $settings_language] = array(
    '#type' => 'textfield',
    '#title' => t('Meta title'),
    '#default_value' => variable_get('babybel_variable_meta_title_our_secret_' . $settings_language . ''),
    '#description' => t("Meta title"),
  );
  $form['babybel_variable_our_secret_meta']['babybel_variable_meta_desc_our_secret_' . $settings_language] = array(
    '#type' => 'textarea',
    '#title' => t('Meta description'),
    '#default_value' => variable_get('babybel_variable_meta_desc_our_secret_' . $settings_language . ''),
    '#description' => t("Meta description"),
  );
  $form['babybel_variable_our_secret_meta']['babybel_variable_meta_images_our_secret_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#description' => t('(*) Please upload file .png extension'),
    '#title' => t('Image for social network'),
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_meta_images_our_secret_' . $settings_language . ''),
    '#upload_validators' => array(
      'file_validate_extensions' => array('png'),
    ),
    '#theme' => 'babybel_variable_background_upload',
  );

  $form['#field_uploads'] = array(
    'babybel_variable_our_secret_background_header_',
    'babybel_variable_meta_images_our_secret_'
  );

  $form['#submit'][] = 'babybel_variable_settings_form_update_status_managed_filed';

  return system_settings_form($form);
}
