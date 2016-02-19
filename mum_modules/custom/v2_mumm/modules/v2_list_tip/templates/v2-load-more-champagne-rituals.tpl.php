<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php
$nodes = $champagne_rituals['nodes'];
if ($nodes) :
  ?>
  <?php
  foreach ($nodes as $node) :
    $node_view = node_view($node, '');
    $node_view['#theme'] = 'node__champagne_ritual_item';
    $rendered_node = drupal_render($node_view);
    echo $rendered_node;
  endforeach;
  ?>
  <?php
endif;
?>
