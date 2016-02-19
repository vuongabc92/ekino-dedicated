<?php

global $language;
$path = drupal_get_path_alias('news', $language->language);
drupal_goto($path);
?>
