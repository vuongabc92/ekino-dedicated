<?php

/**
 * @file
 * Batch HS Resource.
 */

function v2_duplication_hs_resource($duplication_data, &$context)
{
    $source_language = $duplication_data['source_language'];
    $target_language = $duplication_data['translation_language'];

    // Get list of source translations.
    /*$sources_query = db_select('hs_resource_translation', 't');
    $sources_query->innerJoin('hs_resource', 'r', 't.rid = r.rid');
    $sources_query
        ->fields('r', array('rid', 'term'))
        ->fields('t', array('rtid', 'value', 'format'));
    $sources_query->condition('language', $source);

    $source_translations = $sources_query->execute()->fetchAll();*/

    // Get resource translations, keyed by term.
    $source_translations = hs_resource_get_resources($source_language);
    $target_translations = hs_resource_get_resources($target_language);

    // Filter source translations to those not available in the target language.
    $new_translations = array_diff_key($source_translations, $target_translations);

    // Generate and save new translations.
    $failed = array();
    array_walk($new_translations, function ($translation) use ($target_language, &$failed) {
        // Set the target language on the translation.
        $translation->language = $target_language;

        // Prevent an "undefined property" warning when saving.
        $translation->rtid = NULL;

        // Save translation to database.
        $saved = hs_resource_save_translation($translation, $translation);
        $saved = rand(FALSE, TRUE);
        if (!$saved) {
            $failed[$translation->term] = $translation->term;
        }
    });

    $count_total = count($new_translations);
    $count_failed = count($failed);
    $count_updated = $count_total - $count_failed;

    $context['results']['total_count'] = $count_total;
    $context['results']['update_count'] = $count_updated;
    $context['results']['fail_count'] = $count_failed;
}

function v2_duplication_hs_resource_finished($success, $results, $operations)
{
    if ($success) {
        drupal_set_message(format_plural(
            $results['update_count'],
            '1 resource was successfully duplicated.',
            '@count resources were successfully duplicated.'
        ));
    } else {
        $error_operation = reset($operations);
        drupal_set_message(t('An error occurred while processing @operation with arguments : @args', array('@operation' => $error_operation[0], '@args' => print_r($error_operation[0], TRUE))));
    }
}
