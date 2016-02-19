<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  Implements hook_settings_form().
 */
function babybel_variable_homepage_settings_form($form, &$form_state) {
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

  // Variable Settings for Homepage Blocks
  $form['babybel_variable_homepage_blocks'] = array(
    '#type' => 'fieldset',
    '#title' => t('Homepage Blocks'),
    '#group' => 'babybel_variable_tab',
  );

  $sliders = babybel_common_get_content_type('slider');
  $options_slider = array();
  if ($sliders) {
    foreach ($sliders as $id => $slider) {
      $options_slider[$id] = $slider->title . ' (' . $id . ')';
    }
  }

  $merge_option_slider = $options_slider + array(0 => 'None');
  ksort($merge_option_slider);

  $slider_id = babybel_variable_get_nid_translated('babybel_variable_slider_id');
  $slider_exists = array_key_exists($slider_id, $merge_option_slider);

  $form['babybel_variable_homepage_blocks']['babybel_variable_slider_id_' . $settings_language . ''] = array(
    '#type' => 'select',
    '#options' => $merge_option_slider,
    '#title' => 'Slider',
    '#default_value' => $slider_exists ? $slider_id : 0,
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

  $article_id = babybel_variable_get_nid_translated('babybel_variable_article_id');
  $article_exists = array_key_exists($article_id, $merge_option_article);

  $form['babybel_variable_homepage_blocks']['babybel_variable_article_id_' . $settings_language . ''] = array(
    '#type' => 'select',
    '#options' => $merge_option_article,
    '#title' => 'Article',
    '#default_value' => $article_exists ? $article_id : 0,
  );

 $form['babybel_variable_homepage_blocks']['babybel_variable_products_title_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Home product title'),
    '#default_value' => variable_get('babybel_variable_products_title_' . $settings_language . ''),
    '#required' => TRUE,
  );

  $form['babybel_variable_homepage_blocks']['babybel_variable_products_subtitle_' . $settings_language . ''] = array(
    '#type' => 'textarea',
    '#title' => t('Home product subtitle'),
    '#default_value' => variable_get('babybel_variable_products_subtitle_' . $settings_language . ''),
    '#required' => TRUE,
  );

  $form['babybel_variable_homepage_blocks']['babybel_variable_products_button_text_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Home product button text'),
    '#default_value' => variable_get('babybel_variable_products_button_text_' . $settings_language . ''),
    '#required' => TRUE,
  );


  $form['babybel_variable_homepage_blocks']['babybel_variable_homepage_background_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#description' => t('(*) Upload a PNG image file with a transparent background. <br/> (*) Suggested image size: 940x576px'),
    '#title' => t('Background Footer'),
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_homepage_background_' . $settings_language . ''),
    '#upload_validators' => array(
      'file_validate_extensions' => array('png'),
    ),
    '#theme' => 'babybel_variable_background_upload',
    //'#required' => TRUE,
  );
  
  $form['babybel_variable_homepage_blocks']['babybel_variable_language_title_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Language Title'),
    '#default_value' => variable_get('babybel_variable_language_title_' . $settings_language . ''),
    '#required' => TRUE,
  );

  $form['babybel_variable_homepage_meta'] = array(
    '#type' => 'fieldset',
    '#title' => t('Homepage Meta'),
    '#group' => 'babybel_variable_tab',
  );
  $form['babybel_variable_homepage_meta']['babybel_variable_page_title_homepage_' . $settings_language] = array(
    '#type' => 'textfield',
    '#title' => t('Page title'),
    '#default_value' => variable_get('babybel_variable_page_title_homepage_' . $settings_language . ''),
    '#description' => t("Page title"),
  );
  $form['babybel_variable_homepage_meta']['babybel_variable_meta_title_homepage_' . $settings_language] = array(
    '#type' => 'textfield',
    '#title' => t('Meta title'),
    '#default_value' => variable_get('babybel_variable_meta_title_homepage_' . $settings_language . ''),
    '#description' => t("Meta title"),
  );
  $form['babybel_variable_homepage_meta']['babybel_variable_meta_desc_homepage_' . $settings_language] = array(
    '#type' => 'textarea',
    '#title' => t('Meta description'),
    '#default_value' => variable_get('babybel_variable_meta_desc_homepage_' . $settings_language . ''),
    '#description' => t("Meta description"),
  );
  $form['babybel_variable_homepage_meta']['babybel_variable_meta_images_homepage_' . $settings_language . ''] = array(
    '#type' => 'managed_file',
    '#description' => t('(*) Please upload file .png extension'),
    '#title' => t('Image for social network'),
    '#upload_location' => 'public://',
    '#default_value' => variable_get('babybel_variable_meta_images_homepage_' . $settings_language . ''),
    '#upload_validators' => array(
      'file_validate_extensions' => array('png'),
    ),
    '#theme' => 'babybel_variable_background_upload',
    //'#required' => TRUE,
  );

  $form['#field_uploads'] = array(
    'babybel_variable_homepage_background_',
    'babybel_variable_meta_images_homepage_'
  );


  $form['#submit'][] = 'babybel_variable_settings_form_update_status_managed_filed';

  return system_settings_form($form);
}
