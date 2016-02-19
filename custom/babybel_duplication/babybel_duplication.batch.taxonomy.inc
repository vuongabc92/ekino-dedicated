<?php

/**
 * @file
 * Batch taxonomy.
 */
function babybel_duplication_taxonomy($duplication_data, &$context) {
  // Init batch.
  $taxonomy = $duplication_data['taxonomy'];
  $context['message'] = sprintf('Duplicating terms of taxonomy "%s".', $taxonomy->name);

  $s_tids = db_select('taxonomy_term_data', 'ttd')
    ->fields('ttd', array('tid'))
    ->condition('vid', $taxonomy->vid)
    ->condition('language', $duplication_data['source_language'])
    ->execute()
    ->fetchCol();
  $s_terms = taxonomy_term_load_multiple($s_tids);

  if (count($s_terms) > 0) {
    babybel_duplication_translate_taxonomy_terms($taxonomy, $s_terms, $duplication_data['translation_language']);
  }
}

function babybel_duplication_taxonomy_finished($success, $results, $operations) {
  if ($success) {
    drupal_set_message(t('Taxonomy successfully duplicated.'));
  }
  else {
    $error_operation = reset($operations);
    drupal_set_message(t('An error occurred while processing @operation with arguments : @args', array('@operation' => $error_operation[0], '@args' => print_r($error_operation[0], TRUE))));
  }
}

/**
 * Duplicate taxonomy terms
 *
 * @param $taxonomy
 * @param $s_terms
 * @param $t_language
 * @return array
 */
function babybel_duplication_translate_taxonomy_terms($taxonomy, $s_terms, $t_language) {
  foreach ($s_terms as $s_term) {
    // check isset taxonomy by language
    if ($s_term->language !== $t_language) {
      $s_language = $s_term->language;
      $translations[$s_language] = $s_term;
      // Create new term
      $t_term = (object) $s_term;
      unset($t_term->tid);
      $t_term->language = $t_language;
      taxonomy_term_save($t_term);

      $translations[$t_language] = $t_term;
      // set translate
      if (!empty($translations)) {
        $translation_set = i18n_translation_set_create('taxonomy_term', $s_term->vocabulary_machine_name);
        $translation_set
          ->reset_translations($translations)
          ->save(TRUE);
      }
    }
  }
}
