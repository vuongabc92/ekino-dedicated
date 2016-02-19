<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Page list tip.
 * @return page
 */
function page_champagne_rituals($share = FALSE) {
  $results = get_champagne_rituals();
  return theme('v2_champagne_rituals_page', array('champagne_rituals' => $results, 'share' => $share));
}

/**
 * Load more list tip.
 * @return page
 */
function load_more_champagne_rituals() {

  $results = get_champagne_rituals();
  $content = array();
  $nodes = $results['nodes'];
  $page = $_GET['page'];
  $remain = count($nodes);
  if ($page == ($results['max_page'] - 1)) {
    $remain = 0;
  }
  if ($nodes) :
    foreach ($nodes as $node) :
    $node_details = node_load($node->nid);
      $node_view = node_view($node_details, '');
      $node_view['#theme'] = 'node__champagne_ritual_item';
      $rendered_node = drupal_render($node_view);
      $content[] = $rendered_node;
    endforeach;
  endif;
  $json = array(
    'status' => "ok",
    'remain' => $remain,
    'content' => $content,
  );
  return drupal_json_output($json);
  die;
}

/**
 * Get champagne rituals.
 */
function get_champagne_rituals() {
  global $language;
  $limit = V2_LIST_TIP_LIMIT;
  // Get item page .
  $query = db_select('node', 'n');
  $query->leftJoin('field_data_field_ritual_number', 'a', 'a.entity_id = n.nid');
  $query->fields('n', array('nid'))
      ->condition('n.type', 'champagne_ritual')
      ->condition('n.language', $language->language)
      ->condition('n.status', 1)
      ->orderBy('CAST(a.field_ritual_number_value AS UNSIGNED)', 'ASC');
  $query = $query->extend('PagerDefault');
  $total_items = $query->getCountQuery()->execute()->fetchField();
  $query->limit($limit);
  $result = $query->execute()->fetchAll();

  // Get sum pager.
  $max_page = ceil($total_items / $limit);
  $build = array();
  if (!empty($result)) {
    $build = array(
      'nodes' => $result,
      'pager' => array(
        '#theme' => 'pager',
      ),
      'max_page' => $max_page,
      'total' => $total_items,
    );
  }
  return $build;
}
