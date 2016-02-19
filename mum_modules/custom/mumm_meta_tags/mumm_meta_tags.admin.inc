<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function mumm_meta_tags_setting_form($form, &$form_state) {
    $form = array();

    $settings_language = mumm_helpers_get_settings_language();
    $list_meta = variable_get('list_meta', array());

    if (!$form_state['rebuild']) {
        mummm_helpers_set_language_warning_message($settings_language);
    }

    $settings_links = mumm_helpers_settings_language_switcher();
    $form['settings_links'] = array(
      '#markup' => $settings_links
    );
    $form['lang'] = array(
      '#type' => 'hidden',
      '#value' => $settings_language,
    );

    $category = category_list_metatags();
    foreach ($category as $key => $item) {
        $form['group_meta_' . $key] = array(
          '#type' => 'fieldset',
          '#title' => $item,
          '#collapsible' => TRUE,
          '#collapsed' => FALSE,
        );

        $form['group_meta_' . $key]['meta_title_' . $key] = array(
          '#type' => 'textfield',
          '#title' => t('Title'),
          '#default_value' => isset($list_meta[$settings_language]['title_' . $key]) ? $list_meta[$settings_language]['title_' . $key] : '',
          '#description' => t("Meta title"),
        );

        $form['group_meta_' . $key]['meta_description_' . $key] = array(
          '#type' => 'textarea',
          '#title' => t('Description'),
          '#default_value' => isset($list_meta[$settings_language]['desc_' . $key]) ? $list_meta[$settings_language]['desc_' . $key] : '',
          '#description' => t("Meta description"),
        );
    }

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Save configuration')
    );
    return $form;
}

function mumm_meta_tags_setting_form_submit($form, &$form_state) {
    $vars = $form_state['values'];
    $list_meta = variable_get('list_meta', array());
    $categories = category_list_metatags();
    foreach ($categories as $key => $item) {
        $list_meta[$vars['lang']]['title_' . $key] = $vars['meta_title_' . $key];
        $list_meta[$vars['lang']]['desc_' . $key] = $vars['meta_description_' . $key];
    }
    variable_set('list_meta', $list_meta);
    drupal_set_message(t('The new changes have been updated'));
}

function category_list_metatags() {

    return array(
      'is_front' => t('Home page'),
      'portraits' => t('Portraits'),
      'champagne-rituals' => t('Champagne rituals'),
    );
}
