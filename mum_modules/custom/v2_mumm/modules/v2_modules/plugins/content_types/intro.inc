<?php

$plugin = array(
  'title' => t('Intro'),
  'description' => t('This module raises a header at the top of page.The structure is modular, it can not administer all
areas and can take different forms.'),
  'category' => t('Modules'),
  'edit form' => 'module_intro_node_form',
  'render callback' => 'v2_module_render',
  'defaults' => array()
);

/**
 * Implements hook_form().
 * This configuration form can support add/edit content in FO panels.
 */
function module_intro_node_form($form, &$form_state) {
  $form = v2_node_form($form, $form_state);
  return $form;
}

/**
 * Implements hook_form_validate().
 */
function module_intro_node_form_validate(&$form, &$form_state) {
  
}

/**
 * Implements hook_form_submit().
 * Assign node entity of embedded module to Panels.
 */
function module_intro_node_form_submit($form, &$form_state) {
  v2_node_form_submit($form, $form_state);
}
