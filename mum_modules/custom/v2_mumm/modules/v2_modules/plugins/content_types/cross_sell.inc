<?php

$plugin = array(
  'title' => t('Cross sell'),
  'description' => t('This module allows you to highlight products only.'),
  'category' => t('Modules'),
  'edit form' => 'module_cross_sell_node_form',
  'render callback' => 'v2_module_render',
  'defaults' => array()
);

/**
 * Implements hook_form().
 * This configuration form can support add/edit content in FO panels.
 */
function module_cross_sell_node_form($form, &$form_state) {
  $form = v2_node_form($form, $form_state);
  return $form;
}

/**
 * Implements hook_form_validate().
 */
function module_cross_sell_node_form_validate(&$form, &$form_state) {
  
}

/**
 * Implements hook_form_submit().
 * Assign node entity of embedded module to Panels.
 */
function module_cross_sell_node_form_submit($form, &$form_state) {
  v2_node_form_submit($form, $form_state);
}
