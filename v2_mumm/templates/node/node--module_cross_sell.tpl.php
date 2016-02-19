<?php
/*
 * @file node--module_cross_sell.tpl.php.
 *
 */
unset($content['comments']);
unset($content['links']);
?>
<div class="cross-sell spacing-bottom">
  <div class="grid-fluid">
    <div data-eqheight-products data-list-elements=".kind|.title" class="list-products list-products-2">
      <?php
      if (module_exists('nodeorder')) :
        if (isset($content['field_products']['#items'])) :
          $items = $content['field_products']['#items'];
          $length = count($items);
          $sort_items = array();
          foreach ($items as $key => $value) :
            $category = $value['node']->field_champagne_category['und'][0]['tid'];
            $taxonomy_category = taxonomy_term_load($category);
            if (array_key_exists($taxonomy_category->weight, $sort_items)) :
              $sort_items[count($sort_items)][$value['node']->nodeorder[$category]['weight']] = $value;
            else:
              $sort_items[$taxonomy_category->weight][$value['node']->nodeorder[$category]['weight']] = $value;
            endif;
          endforeach;
          // Sort follow weight of category.
          ksort($sort_items);
          foreach ($sort_items as $key => $value) :
            ksort($value);
            $sort_items[$key] = $value;
          endforeach;
          // Display item.
          $key_item = 0;
          foreach ($sort_items as $key => $value) :
            foreach ($value as $item) :
              if ($item['node']):
                $node_item = $item['node'];
                $node_item->node_alias_module = drupal_lookup_path('alias', 'node/' .$node->nid);
                $node_view = node_view($node_item, '');
                $node_view['#theme'] = 'node__cross_sell_item';
                $rendered_node = drupal_render($node_view);
                if (($key_item - 1) == $length && $length > 2):
                  $prefix = '<div class="product-item hidden-xs">';
                else :
                  $prefix = '<div class="product-item">';
                endif;
                echo $prefix . $rendered_node . '</div>';
                $key_item++;
              endif;
            endforeach;
            $key_item++;
          endforeach;
        endif;
      else:
        if (isset($content['field_products']['#items'])) :
          $length = count($content['field_products']['#items']);
          foreach ($content['field_products']['#items'] as $key => $item) :
            if ($item['node']):
              $node_item = $item['node'];
              $node_item->node_alias_module = drupal_lookup_path('alias', 'node/' .$node->nid);
              $node_view = node_view($node_item, '');
              $node_view['#theme'] = 'node__cross_sell_item';
              $rendered_node = drupal_render($node_view);
              if ($key == $length - 1 && $key > 1):
                $prefix = '<div class="product-item hidden-xs">';
              else :
                $prefix = '<div class="product-item">';
              endif;
              echo $prefix . $rendered_node . '</div>';
            endif;
          endforeach;
        endif;
      endif;
      ?>
    </div>
  </div>
</div>