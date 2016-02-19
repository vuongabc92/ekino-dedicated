<?php

/**
 * implementation of hook_panels_layouts()
 */
// Plugin definition
$plugin = array(
  'title' => t('Thuraya Single column'),
  'category' => t('Thuraya Columns: 1'),
  'icon' => 'thuraya-onecol.png',
  'theme' => 'panels_thuraya_onecol',
  'regions' => array('middle' => t('Middle column')),
);
