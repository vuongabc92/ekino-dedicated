<?php
/**
 * @file
 * Batch variable.
 */

function v2_duplication_variables($duplication_data, &$context)
{
	$source_language = $duplication_data['source_language'];
	$target_language = $duplication_data['translation_language'];

	$variable_slugs = mumm_helpers_get_constants('MUMM', 'SLUG', TRUE);
   
	foreach ($variable_slugs as $slug) {
		$values = variable_get($slug);
		if (isset($values[$target_language])) {
			continue;
		}

		$duplication_data['variable_slug']  = $slug;
		drupal_alter('mumm_duplication_variables', $values, $duplication_data);
  	variable_set($slug, $values);
	}
}

function v2_duplication_variables_finished($success, $results, $operations)
{
	if ($success) {
		drupal_set_message(t('Variables successfully duplicated.'));
	} else {
		$error_operation = reset($operations);
		drupal_set_message(t('An error occurred while processing @operation with arguments : @args', array('@operation' => $error_operation[0], '@args' => print_r($error_operation[0], TRUE))));
	}
}
