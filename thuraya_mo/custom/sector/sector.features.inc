<?php
/**
 * @file
 * sector.features.inc
 */

/**
 * Implements hook_node_info().
 */
function sector_node_info() {
  $items = array(
    'product' => array(
      'name' => t('product'),
      'base' => 'node_content',
      'description' => t('Product & Solutions Pages'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  return $items;
}
