<?php

/**
 * @file
 * Batch node.
 */

/**
 * First batch operation for duplicating content.
 */
function babybel_duplication_content($translation_data, &$context) {
  if (!isset($context['sandbox']['progress'])) {
    $context['sandbox']['progress'] = 0;
  }

  if (!isset($context['sandbox'][$translation_data['node_type']]['max'])) {
    $untranslated_nodes = babybel_duplication_get_untranslated_nodes($translation_data);
    $context['sandbox'][$translation_data['node_type']]['untranslated_nodes'] = $untranslated_nodes;
    $context['sandbox'][$translation_data['node_type']]['max'] = count($untranslated_nodes);
  }

  while (!empty($context['sandbox'][$translation_data['node_type']]['untranslated_nodes'])) {
    $source_node = array_shift($context['sandbox'][$translation_data['node_type']]['untranslated_nodes']);
    $translation_node = babybel_duplication_content_node($source_node, $translation_data);
    babybel_duplication_content_update_batch($translation_data, $source_node, $translation_node, $context);
  }
}

/**
 * Update displayed message for the babybel_duplication_content operation.
 */
function babybel_duplication_content_update_batch($translation_data, $source_node, $translated_node, &$context) {
  $context['sandbox']['progress'] ++;
  $context['results'][$translation_data['node_type']]['translated content'][] = $translated_node;
  $context['message'] = sprintf('Duplicating "%s" (<em>%s</em>)', node_type_get_name($source_node), check_plain($source_node->title)
  );
  $context['finished'] = count($context['results'][$translation_data['node_type']]) >= $context['sandbox'][$translation_data['node_type']]['max'];
}

/**
 * Set the node references.
 */
function babybel_duplication_node_references($node_type, $translation_language, &$context) {
  if (!isset($context['sandbox']['progress'])) {
    $context['sandbox']['progress'] = 0;
  }

  if (!isset($context['sandbox'][$node_type]['nodes'])) {
    $nodes = db_select('node', 'n')
      ->condition('type', $node_type, '=')
      ->condition('language', $translation_language, '=')
      ->fields('n', array('nid'))
      ->execute()
      ->fetchAllAssoc('nid');

    $context['sandbox'][$node_type]['nodes'] = node_load_multiple(array_keys($nodes));
    $context['sandbox'][$node_type]['fields'] = field_info_instances('node', $node_type);
    $context['sandbox'][$node_type]['max'] = count($context['sandbox'][$node_type]['nodes']);
  }

  $result = array();

  for ($i = 0; $i < 5; $i++) {
    if (!empty($context['sandbox'][$node_type]['nodes'])) {
      $node = array_shift($context['sandbox'][$node_type]['nodes']);
      $node_wrapper = entity_metadata_wrapper('node', $node);
      foreach ($context['sandbox'][$node_type]['fields'] as $field) {
        babybel_duplication_update_node_references($node_wrapper, $node_wrapper->$field['field_name']);
      }
      $node_wrapper->save();
      $result[] = $node_wrapper->value();
    }
  }

  $context['sandbox']['last_node'] = array_values(array_slice($result, -1, 1, TRUE));

  babybel_duplication_node_references_update_batch($node_type, $result, $context);
}

/**
 * Update displayed message for the babybel_duplication_node_references_update_batch operation.
 */
function babybel_duplication_node_references_update_batch($node_type, $results, &$context) {
  $context['sandbox']['progress'] ++;
  if (!isset($context['results'][$node_type])) {
    $context['results'][$node_type] = $results;
  }
  else {
    $context['results'][$node_type] = array_merge($context['results'][$node_type], $results);
  }

  $last_node = isset($context['sandbox']['last_node']) ? reset($context['sandbox']['last_node']) : NULL;

  if ($last_node) {
    $context['message'] = sprintf('Updating references of content "%s" (<em>%s</em>)', node_type_get_name($last_node), check_plain($last_node->title)
    );
  }
  $context['finished'] = count($context['results'][$node_type]) >= $context['sandbox'][$node_type]['max'];
}

/**
 * Function called once all operations of the batch have been performed.
 */
function babybel_duplication_content_finished($success, $results, $operations) {
  if ($success) {
    drupal_set_message(t('Content successfully duplicated.'));
  }
  else {
    $error_operation = reset($operations);
    drupal_set_message(t('An error occurred while processing @operation with arguments : @args', array('@operation' => $error_operation[0], '@args' => print_r($error_operation[0], TRUE))));
  }
}

/**
 * Get all the nodes of the source language which haven't been translated yet in the choosen language.
 */
function babybel_duplication_get_untranslated_nodes($translation_data) {
  $source_nodes = db_select('node', 'n')
    ->condition('type', $translation_data['node_type'], '=')
    ->condition('language', $translation_data['source_language'], '=')
    ->fields('n', array('nid', 'tnid'))
    ->execute()
    ->fetchAllAssoc('nid');

  $source_nodes_with_translation = db_select('node', 'n')
    ->condition('type', $translation_data['node_type'], '=')
    ->condition('language', $translation_data['source_language'], '=')
    ->condition('tnid', 0, '!=')
    ->fields('n', array('tnid'))
    ->execute()
    ->fetchAllAssoc('tnid');

  $translated_nodes = db_select('node', 'n')
    ->condition('type', $translation_data['node_type'], '=')
    ->condition('language', $translation_data['translation_language'], '=')
    ->condition('tnid', 0, '!=')
    ->fields('n', array('nid', 'tnid'))
    ->execute()
    ->fetchAllAssoc('tnid');

  $translated_nodes_from_source = array_intersect(array_keys($source_nodes_with_translation), array_keys($translated_nodes));

  foreach ($source_nodes as $key => $source_node) {
    if (!in_array($source_node->nid, array_values($translated_nodes_from_source)) || !in_array($source_node->tnid, array_values($translated_nodes_from_source))) {
      $source_nodes[] = node_load($source_node->nid);
    }
    unset($source_nodes[$key]);
  }

  return $source_nodes;
}

/**
 * Translate a node.
 */
function babybel_duplication_content_node($source_node, $translation_data) {
  // Stop if node has already a translation in the given language
  $translated_node = babybel_get_translated_node($source_node, $translation_data['translation_language']);
  if ($translated_node->nid != $source_node->nid) {
    return $translated_node;
  }

  // If the source code has no tnid, set it to its nid
  if ($source_node->tnid == 0) {
    $source_node->tnid = $source_node->nid;
    node_save($source_node);
  }

  /*
   * Prepare translated node :
   *  - clone the source node
   *  - set the appropriate fields to NULL so a new node will be created
   *  - set the language and the user information
   */
  global $user;
  $translated_node = clone $source_node;
  $null_fields = array('nid', 'vid', 'uuid', 'vuuid', 'created', 'changed', 'revision_timestamp');
  foreach ($null_fields as $field) {
    $translated_node->$field = NULL;
  }
  $translated_node->language = $translation_data['translation_language'];
  $translated_node->uid = $user->uid;
  $translated_node->name = $user->name;

  node_save($translated_node);


  /*
   * Update fields :
   *  - translate field collections
   *  - set translated taxonomy terms
   */
  $translated_node_wrapper = entity_metadata_wrapper('node', $translated_node);
  $node_fields = field_info_instances('node', $source_node->type);
  foreach ($node_fields as $field) {
    $field_name = $field['field_name'];
    $field_wrapper = $translated_node_wrapper->$field_name;
    babybel_duplication_content_fields($translated_node_wrapper, $field_wrapper, $field['field_name']);
  }

  // Duplicate metatags
  //babybel_duplication_node_metatags($source_node, $translated_node);

  return $translated_node;
}

/**
 * Translate fields :
 *  - term reference fields
 *  - content fields
 */
function babybel_duplication_content_fields(&$parent_field, &$child_field, $child_field_name) {
  if (!is_object($child_field)) {
    return;
  }

  $field_class = get_class($child_field);

  switch ($field_class) {
    case 'EntityListWrapper' :
      $field_items = $child_field->value();
      foreach ($field_items as $field_item) {
        babybel_duplication_content_fields($parent_field, $field_item, $child_field_name);
      }
      break;

    case 'EntityDrupalWrapper' :
      $field_value = $child_field->value();

      // Field collection
      if (is_object($field_value) && get_class($field_value) == 'FieldCollectionItemEntity') {
        babybel_duplication_content_field_collection($parent_field->value(), $child_field->value());
      }

      // Taxonomy
      if (is_object($field_value) && get_class($field_value) == 'stdClass') {
        babybel_duplication_content_fields($parent_field, $field_value, $child_field_name);
      }
      break;

    case 'FieldCollectionItemEntity' :
      babybel_duplication_content_field_collection($parent_field->value(), $child_field);
      break;

    case 'stdClass' :
      // Taxonomy
      if (isset($child_field->tid) && isset($child_field->i18n_tsid)) {
        babybel_duplication_content_taxonomy_term($child_field, $parent_field->value(), $child_field_name);
      }
  }
}

/**
 * Create a new field collection item.
 */
function babybel_duplication_content_field_collection($host_node, $source_fc) {
  // Create the new field_collection
  $new_fc = clone $source_fc;
  $new_fc->item_id = '';
  $new_fc->save(TRUE);

  // Remove the record from the source field collection
  $table_name = sprintf('field_data_%s', $source_fc->field_name);
  $table_field_preview_name = sprintf('%s_value', $source_fc->field_name);
  $table_field_revision_id_name = sprintf('%s_revision_id', $source_fc->field_name);

  db_update($table_name)
    ->fields(array(
      $table_field_preview_name => $new_fc->item_id,
      $table_field_revision_id_name => $new_fc->revision_id
    ))
    ->condition('entity_id', $host_node->nid)
    ->condition($table_field_preview_name, $source_fc->item_id)
    ->execute();

  return $new_fc;
}

/**
 * Update in database the taxonomy terms linked to a field_data_.
 */
function babybel_duplication_content_taxonomy_term($child_field, $parent_field, $child_field_name) {
  $source_term = taxonomy_term_load($child_field->tid);
  $taxonomy = taxonomy_vocabulary_machine_name_load($source_term->vocabulary_machine_name);
  $taxonomy_tree = i18n_taxonomy_get_tree($taxonomy->vid, $parent_field->language);

  foreach ($taxonomy_tree as $term) {
    if ($term->i18n_tsid == $child_field->i18n_tsid && $term->language == $parent_field->language) {
      $table_name = sprintf('field_data_%s', $child_field_name);
      $table_field_name = sprintf('%s_tid', $child_field_name);

      db_update($table_name)
        ->fields(array($table_field_name => $term->tid))
        ->condition('entity_id', $parent_field->nid)
        ->condition($table_field_name, $child_field->tid)
        ->execute();
    }
  }
}

/**
 * Assign the meta tags of the source node to the translated one.
 */
function babybel_duplication_node_metatags($s_node, $t_node) {
  $metatag_value = db_select('metatag', 'm')
    ->fields('m', array('data'))
    ->condition('entity_type', 'node')
    ->condition('entity_id', $s_node->nid)
    ->execute()
    ->fetchField();

  db_update('metatag')
    ->fields(array('data' => $metatag_value))
    ->condition('entity_type', 'node')
    ->condition('entity_id', $t_node->nid)
    ->execute();
}

/**
 * Update the node references of one node.
 *
 * @param $parent_entity
 * @param $child_field
 */
function babybel_duplication_update_node_references(&$parent_entity, &$child_field) {
  if (!is_object($child_field)) {
    return;
  }

  $field_class = get_class($child_field);

  switch ($field_class) {
    case 'EntityListWrapper' :
      foreach ($child_field as $key => $field_item) {
        babybel_duplication_update_node_references($parent_entity, $field_item);
      }
      break;

    case 'EntityDrupalWrapper' :
      $field_value = (array) $child_field->value();

      if (is_object($field_value) && get_class($field_value) == 'stdClass') {
        $translated_node = babybel_get_translated_node($child_field->value(), $parent_entity->language->value());
        $child_field->set($translated_node);
      }

      // Node references in field collections
      elseif (is_object($field_value) && get_class($field_value) == 'FieldCollectionItemEntity') {

      }
      break;
  }
}

/**
 * If the source node is in the panel of a block.
 */
function babybel_duplication_update_panel_node_translate($pids = null, $source_nid, $nid, $language_origin, $language_trans) {
// get all list pannel
  $sql = db_select('panels_pane', 'pp')
    ->fields('pp');
  // Get by pids or get by all.
  if ($pids != null) {
    $sql->condition('pid', $pids);
  }
  $result = $sql->execute()->fetchAll();
  //
  foreach ($result as $value) {
    $configuration = unserialize($value->configuration);
    //  check node isset panel
    if ($configuration[$language_origin]['nid'] && $configuration[$language_origin]['nid'] == $source_nid) {
      // set configuration
      $configuration[$language_trans] = $configuration[$language_origin];
      $configuration[$language_trans]['nid'] = $nid;
      $value->configuration = serialize($configuration);
      // update db
      $panel_updated = db_update('panels_pane')
        ->fields(array(
          'configuration' => $value->configuration,
        ))
        ->condition('pid', $value->pid)
        ->execute();
    }
    else {
      continue;
    }
  }
}
