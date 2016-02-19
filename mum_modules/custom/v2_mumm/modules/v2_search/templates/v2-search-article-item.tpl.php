<?php

/*
 * @file
 * v2-search-article-item.tpl
 *
 */
?>
<?php
foreach ($nodes as $key => $node) :
  $node_details = node_load($node->nid);
  $node_view = node_view($node_details, '');
  $node_view['#theme'] = 'node__cross_content_item';
  $rendered_node = drupal_render($node_view);
  if ($key == 0):
    $prefix = '<div data-rollover class="product-item">';
  else :
    $prefix = '<div data-rollover class="product-item hidden-xs">';
  endif;
  echo $prefix . $rendered_node . '</div>';

endforeach;
?>        