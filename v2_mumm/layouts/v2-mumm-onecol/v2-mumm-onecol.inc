<?php

/**
 * implementation of hook_panels_layouts()
 */
// Plugin definition
$plugin = array(
  'title' => t('V2 Mumm Single column'),
  'category' => t('V2 Mumm Columns: 1'),
  'icon' => 'v2-mumm-onecol.png',
  'theme' => 'panels_v2_mumm_onecol',
  'regions' => array('middle' => t('Middle column')),
);
