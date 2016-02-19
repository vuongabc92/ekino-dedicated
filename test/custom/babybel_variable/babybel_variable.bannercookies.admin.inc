<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  Implements hook_settings_form().
 */
function babybel_variable_banner_cookies_settings_form($form, &$form_state) {
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

  // Variable Settings for banner cookies
  $form['babybel_variable_banner_cookies'] = array(
    '#type' => 'fieldset',
    '#title' => t('Banner cookies'),
    '#group' => 'babybel_variable_tab',
  );

  $form['babybel_variable_banner_cookies']['babybel_variable_banner_cookies_message_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Message'),
    '#default_value' => variable_get('babybel_variable_banner_cookies_message_' . $settings_language . ''),
    '#required' => TRUE,
  );

  $form['babybel_variable_banner_cookies']['babybel_variable_banner_cookies_dismiss_' . $settings_language . ''] = array(
    '#type' => 'textfield',
    '#title' => t('Dismiss'),
    '#default_value' => variable_get('babybel_variable_banner_cookies_dismiss_' . $settings_language . ''),
    '#required' => TRUE,
  );

  $form['babybel_variable_banner_cookies']['babybel_variable_banner_cookies_learnmore_cta_link_' . $settings_language . ''] = array(
    '#type' => 'link_field',
    '#field_name' => 'link_field',
    '#language' => $settings_language,
    '#field_parents' => array(),
    '#delta' => 0,
    '#default_value' => array(
      'title' => variable_get('babybel_variable_banner_cookies_learnmore_cta_link_title_' . $settings_language . ''),
      'url' => variable_get('babybel_variable_banner_cookies_learnmore_cta_link_url_' . $settings_language . ''),
    ),
  );

  $form['#submit'] = array(
    'babybel_variable_banner_cookies_settings_cta_link'
  );

  return system_settings_form($form);
}

function babybel_variable_banner_cookies_settings_cta_link(&$form, &$form_state) {
  $settings_language = babybel_variable_get_settings_language();

  $title = $form_state['values']['title'];
  $url = $form_state['values']['url'];

  if ('/' == substr($url, 0, 1)) {
    $url = substr($url, 1);
  }

  if ('www' == substr($url, 0, 3)) {
    $url = 'http://' . $url;
  }

  variable_set('babybel_variable_banner_cookies_learnmore_cta_link_title_' . $settings_language . '', $title);
  variable_set('babybel_variable_banner_cookies_learnmore_cta_link_url_' . $settings_language . '', $url);
}