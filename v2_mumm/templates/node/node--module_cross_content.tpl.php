<?php
/*
 * @file node--module_cross_content.tpl.php.
 *
 */

unset($content['comments']);
unset($content['links']);
$class = 'spacing-bottom';
$cta_enable = false;
$external_url = array();
if ($node->field_cross_cotnent_cta && $node->field_cross_cotnent_cta[LANGUAGE_NONE][0]['url']):
  $cta_title = $node->field_cross_cotnent_cta[LANGUAGE_NONE][0]['title'];
  $cta_url = $node->field_cross_cotnent_cta[LANGUAGE_NONE][0]['url'];
  $external_url = v2_mumm_check_url_external($cta_url);
  $class = '';
  $cta_enable = true;
endif;

?>
<div class="cross-content <?php print $class; ?>">
  <div class="grid-fluid">
    <div class="list-products list-products-1">
      <?php
      if (isset($content['field_contents']['#items'])) :
        foreach ($content['field_contents']['#items'] as $key => $item) :
          if ($item['node']) :
            $node_item = $item['node'];
            $node_item->node_alias_module = drupal_lookup_path('alias', 'node/' .$node->nid);
            $node_view = node_view($node_item, '');
            $node_view['#theme'] = 'node__cross_content_item';
            $node_parent = $node;
            $rendered_node = drupal_render($node_view);
            if ($key == 0):
              $prefix = '<div data-rollover class="product-item">';
            elseif($cta_enable) :
              $prefix = '<div data-rollover class="product-item hidden-xs">';
            endif;
            echo $prefix . $rendered_node . '</div>';
          endif;
        endforeach;
      endif;
      ?>
    </div>
  </div>
</div>
<?php if ($external_url): ?>
<a href="<?php print $external_url['path']; ?>" title="<?php print $cta_title; ?>" class="btn btn-gray center-btn alltip-btn" <?php print ($external_url['external']) ? 'target="_blank"' : ''  ?>><?php print $cta_title; ?></a>
<?php endif; ?>
