<?php

/*
 * @file
 * v2-search-product-champagne-item.tpl
 *
 */
?>
<?php

foreach ($nodes as $key => $node) :
  $node_details = node_load($node->nid);
  $node_view = node_view($node_details, '');
  $node_view['#theme'] = 'node__cross_sell_item';
  $rendered_node = drupal_render($node_view);
  $prefix = '<div class="product-item">';
  echo $prefix . $rendered_node . '</div>';
endforeach;
?>