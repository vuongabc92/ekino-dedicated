<?php

/**
 * @file
 * slider.inc
 */

$plugin = array(
  'title' => t('Social Media Channel'),
  'description' => t('This module allows add content for block Social Media Channel.'),
  'category' => t('Modules'),
  'edit form' => 'module_social_media_node_form',
  'render callback' => 'widgets_render',  
  'defaults' => array()
);

/**
 * Implements hook_form().
 * This configuration form can support add/edit content in FO panels.
 */
function module_social_media_node_form($form, &$form_state) {
  $form = widgets_node_form($form, $form_state);
  return $form;
}

/**
 * Implements hook_form_validate().
 */
function module_social_media_node_form_validate(&$form, &$form_state) {

}

/**
 * Implements hook_form_submit().
 * Assign node entity of embedded module to Panels.
 */
function module_social_media_node_form_submit($form, &$form_state) {
  widgets_node_form_submit($form, $form_state);
}
