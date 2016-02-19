<?php

function v2_form_admin_lists() {

	$module_path = drupal_get_path('module', 'v2_form');
	drupal_add_js(sprintf('%s/js/v2_form_lists.js', $module_path));

	$variable_prefix = 'v2_form_list';

	$settings_language = mumm_helpers_get_settings_language();
	$lists = array(
	  'title' => 'Title',
	  'tour_type' => 'Booking - Tour types',
	  'booking_time_requested' => 'Booking - Requested times',
	  'booking_prefered_language' => 'Booking - Prefered languages',
    'booking_your_experience' => 'Booking - Your experience',
    'topics' => 'Your- Topics'
	);

	$form = array();

	foreach ($lists as $name => $title) {
		$list_variable_name = sprintf('%s_%s_%s', $variable_prefix, $name, $settings_language);
		$values = explode('||', variable_get($list_variable_name));

		if (count($values) == 1 && $values[0] == NULL) {
			$list_variable_name = sprintf('%s_%s', $variable_prefix, $name);
			$values = explode('||', variable_get($list_variable_name));
		}

		$form[$name] = array(
		  '#type'        => 'fieldset',
		  '#title'       => t($title),
		  '#collapsible' => TRUE,
		  '#attributes'  => array(
			'id' => $name
		  )
		);

		$form[$name][sprintf('%s_%s', $name, 'values')] = array(
		  '#type'  => 'hidden',
		  '#default_value' => $values
		);
	}

	// @todo add language option

	$form['submit'] = array(
	  '#type'  => 'submit',
	  '#value' => t('Save configuration')
	);

	return $form;
}
