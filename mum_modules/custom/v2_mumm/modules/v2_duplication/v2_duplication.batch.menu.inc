<?php

/**
 * @file
 * Batch menu.
 */

/**
 * First operation for duplicating menus
 * Create translation sets if those don't already exists
 *
 * @param $duplication_data
 * @param $context
 */
function v2_duplication_menu_set_translation_sets($duplication_data, &$context) {
	$menu_name = $duplication_data['menu_name'];
	$menu_info = menu_load($menu_name);
	$context['message'] = sprintf('Creating translation sets for "%s".', $menu_info['title']);

	$menu = mumm_helpers_get_localized_menu_tree($menu_name, $duplication_data['source_language']);
	$flatten_menu = v2_duplication_flatten_menu($menu);

	foreach ($flatten_menu as $menu_item) {
		$result[] = v2_duplication_menu_item_set_translation_set($menu_item);
	}
}

/**
 * Second operation for duplicating menus
 * Duplicate all menu links
 *
 * @param $duplication_data
 * @param $context
 */
function v2_duplication_menu_duplicate($duplication_data, &$context) {
	$menu_name = $duplication_data['menu_name'];
	$menu_info = menu_load($menu_name);

	if (!isset($context['sandbox']['menu_items'])) {
		$menu = mumm_helpers_get_localized_menu_tree($menu_name, $duplication_data['source_language']);
		$context['sandbox']['menu_items'] = v2_duplication_flatten_menu($menu);
		$context['sandbox']['count'] = 0;
	}

	$result = array();
	if (empty($context['sandbox']['menu_items'])) {
		// Let modules make changes to the menu
		drupal_alter('v2_duplication_menu', $duplication_data);

		$context['finished'] = TRUE;
	} else {
		$menu_item = array_shift($context['sandbox']['menu_items']);
		$result[] = v2_duplication_translate_menu_item($menu_item, $duplication_data['translation_language'], $context['sandbox']['count']);
		$context['message'] = sprintf('Duplicating "%s" (<em>%s</em>).', $menu_info['title'], $menu_item['link_title']);
		$context['sandbox']['count']++;
		$context['finished'] = FALSE;
	}
}

/**
 * Function called once all operations are done.
 *
 * @param $success
 * @param $results
 * @param $operations
 */
function v2_duplication_menu_finished($success, $results, $operations) {
	if ($success) {
		menu_rebuild();
		drupal_set_message(t('Menus successfully duplicated.'));
	} else {
		$error_operation = reset($operations);
		drupal_set_message(t('An error occurred while processing @operation with arguments : @args', array('@operation' => $error_operation[0], '@args' => print_r($error_operation[0], TRUE))));
	}
}

/**
 * Helper function to flatten the menu tree
 *
 * @param $menu
 * @param array $result
 * @return array
 */
function v2_duplication_flatten_menu($menu, $result = array()) {
	foreach ($menu as $menu_item) {
		$result[] = $menu_item['link'];

		if (!empty($menu_item['below'])) {
			$result = $result + v2_duplication_flatten_menu($menu_item['below'], $result);
		}
	}
	return $result;
}

/**
 * Set the translation set for one menu item
 *
 * @param $menu_link
 */
function v2_duplication_menu_item_set_translation_set($menu_item) {
	$menu_link = $menu_item;
	if (isset($menu_item['link'])) {
		$menu_link = $menu_item['link'];
	}

	if ($menu_link['language'] == LANGUAGE_NONE) {
		return;
	}

	$result = array();
	$result['language'] = $menu_link['language'];

	if ($menu_link['i18n_tsid'] == 0) {
		// Create translation set
		$translation_set = i18n_translation_set_create('menu_link');

		// Update menu link
		$menu_link['i18n_tsid'] = $translation_set->tsid;
		$menu_link['customized'] = 1;
		menu_link_save($menu_link);

		// Update translation set
		$translation_set->add_item($menu_link, $menu_link['language']);
		$translation_set->save();
	}
}

/**
 * Translate one menu item
 *
 * @param $source_menu_item
 * @param $translation_language
 */
function v2_duplication_translate_menu_item($source_menu_item, $translation_language) {
	$source_menu_item_link = $source_menu_item;

	if (isset($source_menu_item['link'])) {
		$source_menu_item_link = $source_menu_item['link'];
	}

	if ($source_menu_item_link['language'] == LANGUAGE_NONE) {
		return;
	}

	// Check if a translation of this menu item already exists
	$translated_menu_item_mlid = db_select('menu_links', 'ml')
		->condition('i18n_tsid', $source_menu_item_link['i18n_tsid'], '=')
		->condition('language', $translation_language, '=')
		->fields('ml', array('mlid'))
		->execute()
		->fetchCol();

	if ($translated_menu_item_mlid) {
		return;
	}

	// Create new menu item
	$localized_menu_item = array();
	$t_fields = array('link_title', 'link_path', 'menu_name', 'module', 'i18n_tsid', 'expanded', 'router_path', 'weight', 'hidden', 'options');
	foreach ($t_fields as $t_field) {
		$localized_menu_item[$t_field] = $source_menu_item_link[$t_field];
	}
	$localized_menu_item['language'] = $translation_language;

	// Set parent menu item if exists
	if ($source_menu_item_link['plid'] != 0) {
		$source_parent_i18n_stid = db_select('menu_links', 'ml')
			->fields('ml', array('i18n_tsid'))
			->condition('menu_name', $source_menu_item_link['menu_name'])
			->condition('language', $source_menu_item_link['language'])
			->condition('mlid', $source_menu_item_link['plid'])
			->execute()
			->fetchField();

		$translated_plid = db_select('menu_links', 'ml')
			->fields('ml', array('mlid'))
			->condition('menu_name', $source_menu_item_link['menu_name'])
			->condition('language', $translation_language)
			->condition('i18n_tsid', $source_parent_i18n_stid)
			->execute()
			->fetchField();

		$localized_menu_item['plid'] = $translated_plid;
	}

	$localized_mlid = menu_link_save($localized_menu_item);
	$saved_localized_menu_item = menu_link_load($localized_mlid);

	v2_duplication_menu_item_set_localized_menu_path($saved_localized_menu_item);

	// Add it to the translation set
	if ($source_menu_item_link['i18n_tsid'] != 0) {
		$translation_set = i18n_translation_set_load($source_menu_item_link['i18n_tsid'], 'menu_link');
		$translation_set->add_item($saved_localized_menu_item, $translation_language);
		$translation_set->save(TRUE);
	}

	// Set visibility
	$visibility = (is_string($source_menu_item_link['hidden']) && $source_menu_item_link['hidden'] == '1') ? 1 : 0;
	db_update('menu_links')
		->fields(array('hidden' => $visibility))
		->condition('mlid', $localized_mlid)
		->execute();

	return $visibility;
}

/**
 * Set the path for one menu item
 *
 * @param $menu_item
 */
function v2_duplication_menu_item_set_localized_menu_path($menu_item) {
	$menu_item_link = $menu_item;
	if (isset($menu_item['link'])) {
		$menu_item_link = $menu_item['link'];
	}

	if ($menu_item_link['language'] == LANGUAGE_NONE || $menu_item_link['router_path'] != 'node/%') {
		return;
	}

	$source_path = $menu_item_link['link_path'];
	$source_nid = mumm_helpers_get_nid_from_path($source_path);
	$translated_node = mumm_helpers_get_translated_node(node_load($source_nid), $menu_item_link['language']);

	$menu_item_link['link_path'] = sprintf('node/%d', $translated_node->nid);
	menu_link_save($menu_item_link);
	node_save($translated_node);
}