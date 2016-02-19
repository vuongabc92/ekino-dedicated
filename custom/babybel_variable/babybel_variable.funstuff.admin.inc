<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  Implements hook_settings_form().
 */
function babybel_variable_fun_stuff_settings_form($form, &$form_state) {
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

  // Variable Settings for Fun Stuff Blocks
  $form['babybel_variable_funstuff_blocks'] = array(
    '#type' => 'fieldset',
    '#title' => t('Fun stuff blocks'),
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

  $first_id = babybel_variable_get_nid_translated('babybel_variable_funstuff_first_id');
  $first_exists = array_key_exists($first_id, $merge_option_article);

  $form['babybel_variable_funstuff_blocks']['babybel_variable_funstuff_first_id_' . $settings_language . ''] = array(
    '#type' => 'select',
    '#options' => $merge_option_article,
    '#title' => 'First block',
    '#default_value' => $first_exists ? $first_id : 0,
  );

  $supercheese_id = babybel_variable_get_nid_translated('babybel_variable_funstuff_supercheese_id');
  $supercheese_exists = array_key_exists($supercheese_id, $merge_option_article);

  $form['babybel_variable_funstuff_blocks']['babybel_variable_funstuff_supercheese_id_' . $settings_language . ''] = array(
    '#type' => 'select',
    '#options' => $merge_option_article,
    '#title' => 'Supper cheese block',
    '#default_value' => $supercheese_exists ? $supercheese_id : 0,
  );

  $waxcraft_id = babybel_variable_get_nid_translated('babybel_variable_funstuff_waxcraft_id');
  $waxcraft_exists = array_key_exists($waxcraft_id, $merge_option_article);

  $form['babybel_variable_funstuff_blocks']['babybel_variable_funstuff_waxcraft_id_' . $settings_language . ''] = array(
    '#type' => 'select',
    '#options' => $merge_option_article,
    '#title' => 'Wax craft blocks',
    '#default_value' => $waxcraft_exists ? $waxcraft_id : 0,
  );

  $form['babybel_variable_funstuff_blocks']['babybel_variable_funstuff_page_background_header_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#title' => t('Background header'),
    '#description' => '(*) Suggested image sizes: 1440x492',
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_funstuff_page_background_header_' . $settings_language . ''),
    '#theme' => 'babybel_variable_background_upload',
  );

  $form['babybel_variable_funstuff_blocks']['babybel_variable_funstuff_page_background_footer_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#description' => t('(*) Please upload file .png extension. <br/> (*) Suggested image sizes: 940x576.'),
    '#title' => t('Background footer'),
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_funstuff_page_background_footer_' . $settings_language . ''),
    '#upload_validators' => array(
      'file_validate_extensions' => array('png'),
    ),
    '#theme' => 'babybel_variable_background_upload',
  );

  // Variable Settings for Fun Stuff meta
  $form['babybel_variable_funstuff_meta'] = array(
    '#type' => 'fieldset',
    '#title' => t('Fun stuff meta'),
    '#group' => 'babybel_variable_tab',
  );
  $form['babybel_variable_funstuff_meta']['babybel_variable_page_title_funstuff_' . $settings_language] = array(
    '#type' => 'textfield',
    '#title' => t('Page title'),
    '#default_value' => variable_get('babybel_variable_page_title_funstuff_' . $settings_language . ''),
    '#description' => t("Page title"),
  );
  $form['babybel_variable_funstuff_meta']['babybel_variable_meta_title_funstuff_' . $settings_language] = array(
    '#type' => 'textfield',
    '#title' => t('Meta title'),
    '#default_value' => variable_get('babybel_variable_meta_title_funstuff_' . $settings_language . ''),
    '#description' => t("Meta title"),
  );
  $form['babybel_variable_funstuff_meta']['babybel_variable_meta_desc_funstuff_' . $settings_language] = array(
    '#type' => 'textarea',
    '#title' => t('Meta description'),
    '#default_value' => variable_get('babybel_variable_meta_desc_funstuff_' . $settings_language . ''),
    '#description' => t("Meta description"),
  );
  $form['babybel_variable_funstuff_meta']['babybel_variable_meta_images_funstuff_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#description' => t('(*) Please upload file .png extension'),
    '#title' => t('Image for social network'),
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_meta_images_funstuff_' . $settings_language . ''),
    '#upload_validators' => array(
      'file_validate_extensions' => array('png'),
    ),
    '#theme' => 'babybel_variable_background_upload',
  );

  $form['#field_uploads'] = array(
    'babybel_variable_funstuff_page_background_header_',
    'babybel_variable_funstuff_page_background_footer_',
    'babybel_variable_meta_images_funstuff_'
  );

  $form['#submit'] = array(
    'babybel_variable_settings_form_update_status_managed_filed',
  );

  return system_settings_form($form);
}
