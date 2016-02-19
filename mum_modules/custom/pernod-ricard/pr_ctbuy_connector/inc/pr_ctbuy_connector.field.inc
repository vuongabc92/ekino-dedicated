<?php

/**
 * Implements hook_field_info().
 */
function pr_ctbuy_connector_field_info() {
  return array(
    'pr_ctbuy_connector_ctbuy_field' => array(
      'label' => t('Click to buy Console : CTA'),
      'description' => t('Create a call to action link based on a remote product on the click to buy console.'),
      'default_widget' => 'pr_ctbuy_connector_field_widget_default',
      'default_formatter' => 'pr_ctbuy_connector_field_formatter_default',
    ),
  );
}

/**
 * Implements hook_field_formatter_info().
 */
function pr_ctbuy_connector_field_formatter_info() {
  return array(
    // This formatter just displays the hex value in the color indicated.
    'pr_ctbuy_connector_field_formatter_default' => array(
      'label' => t('Default CTA - Click to buy'),
      'field types' => array('pr_ctbuy_connector_ctbuy_field'),
      'settings'  => array(
        'class' => '',
      ),
    ),
  );
}


/**
 * Implements hook_field_validate().
 */
function pr_ctbuy_connector_field_validate($entity_type, $entity, $field, $instance, $langcode, $items, &$errors) {

  foreach ($items as $delta => $item) {
    if (!empty($item['remote_key'])) {
      if (!preg_match('@^\S*$@', $item['remote_key'])) {
        $errors[$field['field_name']][$langcode][$delta]['remote_key'] = array(
          'error' => 'remote_key_invalid',
          'message' => t('The format of the click to buy key is not correct.'),
        );
      }
    }

    $empty = 0;

    foreach ($item as $key => $value) {
       empty($value) ? $empty++ : $empty;
    }

    if ($empty === 1) {
      $errors[$field['field_name']][$langcode][$delta]['remote_key'] = array(
        'error' => 'must_fill_both',
        'message' => t('You must fill both the title and the Click to Buy Key.'),
      );
    }
  }
}

/**
 * Check if the field is empty
 */
function pr_ctbuy_connector_field_is_empty($item, $field) {
  $empty = false;

  foreach ($item as $key => $value) {
    if (empty($value)) {
      $empty = true;
    }
  }

  return $empty;
}

/**
 * Implements hook_field_formatter_view().
 */
function pr_ctbuy_connector_field_formatter_view($entity_type, $entity, $field, $instance, $langcode, $items, $display) {
  $element = array();
  $settings = $display['settings'];

  // Get class
  $class = isset($settings['class']) && !empty($settings['class']) ? $settings['class'] : '';


  switch ($display['type']) {

    case 'pr_ctbuy_connector_field_formatter_default':
      foreach ($items as $delta => $item) {
        $element[$delta] = array(
          '#theme' => 'ctbuy_link',
          '#key' => $item['remote_key'],
          '#text' => $item['title'],
          '#lang' => pr_ctbuy_connector_get_var_auto('pr_ctbuy_connector_lang') !== null ? pr_ctbuy_connector_get_var_auto('pr_ctbuy_connector_lang') : 'en',
          '#custom_class' => $class,
        );

      }
      break;
  }

  return $element;
}

/**
 * Implements hook_field_widget_info().
 */
function pr_ctbuy_connector_field_widget_info() {
    return array(

    'pr_ctbuy_connector_field_widget_default' => array(
      'label' => t('Default widget - Click to Buy'),
      'field types' => array('pr_ctbuy_connector_ctbuy_field'),
    ),
  );
}

/**
 * Implements hook_field_widget_form().
 */
function pr_ctbuy_connector_field_widget_form(&$form, &$form_state, $field, $instance, $langcode, $items, $delta, $element) {

  // Exit if not configured
  if (pr_ctbuy_connector_get_var_auto('pr_ctbuy_connector_key') === null ||
    pr_ctbuy_connector_get_var_auto('pr_ctbuy_connector_endpoint') === null) {

    $element['#markup'] = t("The click to buy Module is not properly configured, please check it : !url", array('!url' => l(t('here'), 'admin/prctbuyconnector/settings')));

    return $element;
  }

  // Exit if no connexion to the console is possible
  if (!pr_ctbuy_connector_check_connexion()) {
    $element['#markup'] = t("The click to buy Console is not responding correctly, please check the configuration !url, if the problem persist, please contact the administrator.", array('!url' => l(t('here'), 'admin/prctbuyconnector/settings')));
    return $element;
  }

  // Construct the widget
  $element += array(
    '#type' => 'fieldset',
  );

  $required = $element['#required'];
  $item =& $items[$delta];

  $element['remote_key'] = array(
    '#title' => t('Click to buy Console, Remote Key'),
    '#type' => 'textfield',
    '#required' => $required,
    '#autocomplete_path' => 'admin/prctbuyconnector/autocomplete',
    // use #default_value to prepopulate the element
    // with the current saved value
    '#default_value' => isset($item['remote_key']) ? $item['remote_key'] : '',
  );

  $element['title'] = array(
    '#title' => t('Click to buy Console, text of the CTA'),
    '#type' => 'textfield',
    '#required' => $required,
    // use #default_value to prepopulate the element
    // with the current saved value
    '#default_value' => isset($item['title']) ? $item['title'] : '',
  );

  // Set Parent
  $element['#field_parents'] = array($element['#field_name']);

  return $element;
}

/**
 * Implements hook_field_formatter_settings_form().
 */
function pr_ctbuy_connector_field_formatter_settings_form($field, $instance, $view_mode, $form, &$form_state) {
  //This gets the view_mode where our settings are stored
  $display = $instance['display'][$view_mode];
  //This gets the actual settings
  $settings = $display['settings'];
  //Initialize the element variable
  $element = array();
  //Add the class textfield
  $element['class'] = array(
    '#type'           => 'textfield',
    '#title'          => t('Custom Class'),
    '#description'    => t('A custom class to add to the CTB link <a>.'),
    '#default_value'  => $settings['class'],
  );

  return $element;
}


/**
 * Implements hook_field_formatter_settings_summary().
 */
function pr_ctbuy_connector_field_formatter_settings_summary($field, $instance, $view_mode) {
  $display = $instance['display'][$view_mode];
  $settings = $display['settings'];
  $summary = t('Custom class : @class', array(
    '@class'     => $settings['class']
  ));
  return $summary;
}
