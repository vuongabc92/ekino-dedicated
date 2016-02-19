<?php

$plugin = array(
  'title' => t('Existing content from modules'),
  'description' => t('This module allows to inherit from the node existing.'),
  'category' => t('Existing'),
  'edit form' => 'existing_content_edit_form',
  'render callback' => 'v2_module_render',
  'defaults' => array()
);

/**
 * Implements hook_form().
 * This configuration form can support add/edit content in FO panels.
 */
function existing_content_edit_form($form, &$form_state) {
  global $language, $user;

  $conf = $form_state['conf'];
  if ($nid = $conf[$language->language]['nid']) {
    $form = v2_node_form($form, $form_state);
    $form['update'] = array('#type' => 'hidden', '#value' => $nid);
    return $form;
  }

  $query = db_select('node_type', 'nt')
      ->addTag('translatable')
      ->addTag('node_type_access')
      ->fields('nt')
      ->condition('nt.type', '^module_', 'REGEXP')
      ->orderBy('nt.type', 'ASC');
  $result = $query->execute()->fetchCol();

  $form['node'] = array(
    '#type' => 'entityreference',
    '#title' => t('Input node'),
    '#description' => t('Autocomplete'),
    '#era_entity_type' => 'node', // Mandatory.
    '#era_bundles' => $result, // Optional.
    '#era_cardinality' => 10,
    '#era_query_settings' => array(
      'property_conditions' => array(
        array('language', $user->language),
      ),
    ),
  );

  ctools_form_include_file($form_state, $form_state['plugin']['path'] . '/' . $form_state['plugin']['file']);

  return $form;
}

/**
 * Implements hook_form_validate().
 */
function existing_content_edit_form_validate(&$form, &$form_state) {
  if (isset($form_state['node'])) {
    $node_type = $form_state['node']->type;
    if ($node_type == 'module_slider') {
      $values = $form_state['values']['field_slider_collection'][LANGUAGE_NONE];
      foreach ($values as $key => $value) {
        $error = v2_modules_validate_slider($value, 'field_slider_collection', $key);
        if ($error) {
          return FALSE;
        }
      }
    }
  }
}

/**
 * Implements hook_form_submit().
 * Update the content existing.
 */
function existing_content_edit_form_submit($form, &$form_state) {
  if ($nids = array_keys($form_state['values']['node'])) {
    global $language;
    $form_state['conf'][$language->language]['nid'] = $nids[0];
  }
  elseif (isset($form_state['values']['update'])) {
    v2_node_form_submit($form, $form_state);
  }
  else {
    return;
  }
}
