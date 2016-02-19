<?php

/**
 * @file
 * Batch variable.
 */
function babybel_duplication_variables($duplication_data, &$context) {
  $source_language = $duplication_data['source_language'];
  $target_language = $duplication_data['translation_language'];
  $webforms = babybel_common_get_content_type('webform','node',1,2);
  
  if ($webforms) {
    foreach ($webforms as $id => $webform) {
      if($webform->language == $target_language)
      $webform_id = $webform->vid;
      
    }
  }
  $variables = baybel_variable_get_all('babybel_variable', $source_language);

  foreach ($variables as $item) {
    $array = explode('_', $item);
    if('babybel_variable_newsletter_webform_id_'.$source_language == $item){
      $value = $webform_id;
    } else {
      $value = variable_get($item);
    }
        
    if ($array) {
      end($array);
      $key = key($array);
      $array[$key] = $target_language;
      $clone_variable = implode('_', $array);
      if (!variable_get($clone_variable)) {
        variable_set($clone_variable, $value);
      }
      if('babybel_variable_newsletter_webform_id_'.$target_language == $clone_variable){
        variable_set($clone_variable, $value);
      }
    }
  }
}

function babybel_duplication_variables_finished($success, $results, $operations) {
  if ($success) {
    drupal_set_message(t('Variables successfully duplicated.'));
  }
  else {
    $error_operation = reset($operations);
    drupal_set_message(t('An error occurred while processing @operation with arguments : @args', array('@operation' => $error_operation[0], '@args' => print_r($error_operation[0], TRUE))));
  }
}
