<?php

$plugin = array(
  'title' => t('Text (1 & 2 Columns)'),
  'description' => t('The text module allows the creation of free text paragraphs. It has two betting options in forms: 1 or 2 columns.'),
  'category' => t('Modules'),
  'edit form' => 'module_text_node_form',
  'render callback' => 'v2_module_render',
  'admin' => array(
    'access arguments' => array('edit own module_text content')
  ),
  'defaults' => array()
);

/**
 * Implements hook_form().
 * This configuration form can support add/edit content in FO panels.
 */
function module_text_node_form($form, &$form_state) {
  $form = v2_node_form($form, $form_state);
  return $form;
}

/**
 * Implements hook_form_validate().
 */
function module_text_node_form_validate(&$form, &$form_state) {

}

/**
 * Implements hook_form_submit().
 * Assign node entity of embedded module to Panels.
 */
function module_text_node_form_submit($form, &$form_state) {
  v2_node_form_submit($form, $form_state);
}
