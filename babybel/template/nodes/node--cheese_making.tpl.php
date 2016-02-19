<?php

global $language;
$path = drupal_get_path_alias('our-secret', $language->language);
drupal_goto($path);
?>
