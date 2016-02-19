<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  Implements hook_settings_form().
 */
function babybel_variable_list_pages_settings_form($form, &$form_state) {
//  $settings_language = babybel_variable_get_settings_language();
//  if (!$form_state['rebuild']) {
//    babybel_variable_set_language_warning_message($settings_language);
//  }
//
//  $settings_links = babybel_variable_settings_language_switcher();
//  $form['settings_links'] = array(
//    '#markup' => $settings_links
//  );
//
//  $form['lang'] = array(
//    '#type' => 'hidden',
//    '#value' => $settings_language,
//  );

  $form['babybel_variable_tab'] = array(
    '#type' => 'vertical_tabs',
  );

  // Variable settings for list_pages
  $form['babybel_variable_list_pages_page'] = array(
    '#type' => 'fieldset',
    '#title' => t('List pages'),
    '#group' => 'babybel_variable_tab',
  );

  // List pages products
  $form['babybel_variable_list_pages_page']['babybel_variable_list_pages_url'] = array(
    '#type' => 'textarea',
    '#title' => t('List pages url'),
    '#default_value' => variable_get('babybel_variable_list_pages_url'),
  );

//  $form['babybel_variable_list_pages_page']['products']['babybel_variable_list_pages_products_' . $settings_language] = array(
//    '#type' => 'textarea',
//    '#title' => t('List email'),
//    '#default_value' => variable_get('babybel_variable_list_pages_products_' . $settings_language . ''),
//  );
//
//  // List pages our-secrets
//  $form['babybel_variable_list_pages_page']['our_secrets'] = array(
//    '#type' => 'fieldset',
//    '#title' => t('Our secrets'),
//  );
//
//  $form['babybel_variable_list_pages_page']['our_secrets']['babybel_variable_list_pages_our_secrets_' . $settings_language] = array(
//    '#type' => 'textarea',
//    '#title' => t('List our secrets'),
//    '#default_value' => variable_get('babybel_variable_list_pages_our_secrets_' . $settings_language . ''),
//  );
//
//  // List pages fun-stuff
//  $form['babybel_variable_list_pages_page']['fun_stuffs'] = array(
//    '#type' => 'fieldset',
//    '#title' => t('Fun stuffs'),
//  );
//
//  $form['babybel_variable_list_pages_page']['fun_stuffs']['babybel_variable_list_pages_fun_stuffs_' . $settings_language] = array(
//    '#type' => 'textarea',
//    '#title' => t('List fun stuffs'),
//    '#default_value' => variable_get('babybel_variable_list_pages_fun_stuffs_' . $settings_language . ''),
//  );
//
//  // List pages news
//  $form['babybel_variable_list_pages_page']['news'] = array(
//    '#type' => 'fieldset',
//    '#title' => t('News'),
//  );
//
//  $form['babybel_variable_list_pages_page']['news']['babybel_variable_list_pages_news_' . $settings_language] = array(
//    '#type' => 'textarea',
//    '#title' => t('List news'),
//    '#default_value' => variable_get('babybel_variable_list_pages_news_' . $settings_language . ''),
//  );

  return system_settings_form($form);
}