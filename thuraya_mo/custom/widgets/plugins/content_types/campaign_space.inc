<?php

/**
 * @file
 * product.inc
 */

$plugin = array(
  'title' => t('Campaign space'),
  'description' => t('This module allows add content for block Campaign space.'),
  'category' => t('Modules'),
  'edit form' => 'module_campaign_space_node_form',
  'render callback' => 'widgets_render',  
  'defaults' => array()
);

/**
 * Implements hook_form().
 * This configuration form can support add/edit content in FO panels.
 */
function module_campaign_space_node_form($form, &$form_state) {
  $form = widgets_node_form($form, $form_state);
  return $form;
}

/**
 * Implements hook_form_validate().
 */
function module_campaign_space_node_form_validate(&$form, &$form_state) {

}

/**
 * Implements hook_form_submit().
 * Assign node entity of embedded module to Panels.
 */
function module_campaign_space_node_form_submit($form, &$form_state) {
  widgets_node_form_submit($form, $form_state);
}
