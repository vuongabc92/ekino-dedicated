<?php

/**
 * @file
 * Variable for v2 modules.
 */


/**
 * Implements hook_settings_form().
 */
function v2_modules_variable_settings_form($form) {

  //get default value second for video in content type Slider.
  $slider_second_video = variable_get('slider_second_video', SLIDER_SECOND_VIDEO);

  $form['vars_tab'] = array(
    '#type' => 'vertical_tabs',
  );
  $form['slider'] = array(
    '#type' => 'fieldset',
    '#title' => t('Slider settings'),
    '#group' => 'vars_tab',
  );

  $form['slider']['slider_second_video'] = array(
    '#type' => 'textfield',
    '#title' => t('Duration in seconds for each slide'),
    '#default_value' => $slider_second_video,
    '#required' => TRUE,

  );

  return system_settings_form($form);
}
