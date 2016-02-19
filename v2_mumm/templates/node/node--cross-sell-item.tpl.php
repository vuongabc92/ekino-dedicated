<?php
/*
 * @file
 * node--cross-sell-item.tpl.php.
 *
 */
$kind = taxonomy_term_load($node->field_champagne_category[LANGUAGE_NONE][0]['tid']);

$picture_instance = field_info_instance('node', 'field_picture_collection', 'product_champagne');
$crop_style_list = $picture_instance['widget']['settings']['manualcrop_styles_list'];
$image_src = isset($node->field_picture_collection[LANGUAGE_NONE][0]['uri']) ? $node->field_picture_collection[LANGUAGE_NONE][0]['uri'] : '';
$prefix_title =$node->field_champagne_brand[LANGUAGE_NONE][0]['value'];
$image_alt = !empty($node->field_picture_collection[LANGUAGE_NONE][0]['alt']) ? $node->field_picture_collection[LANGUAGE_NONE][0]['alt'] : $prefix_title . ' ' . strip_tags($node->title);
$interchange = '';
if ($crop_style_list) :
  ksort($crop_style_list);
  $interchange = v2_mumm_interchange_images($image_src, $crop_style_list, 'product_champagne');
else :
  $crop_style_list = array('product_champagne__315x451_', 'product_champagne__315x451_', 'product_champagne__315x451_');
  $interchange = v2_mumm_interchange_images($image_src, $crop_style_list, 'product_champagne');
endif;

$buy_url = isset($node->field_click_to_buy[LANGUAGE_NONE][0]['remote_key']) ? $node->field_click_to_buy[LANGUAGE_NONE][0]['remote_key'] : '';
$buy_url_title = isset($node->field_click_to_buy[LANGUAGE_NONE][0]['title']) ? $node->field_click_to_buy[LANGUAGE_NONE][0]['title'] : '';
$language_buy = variable_get('pr_ctbuy_connector_lang');
$node_alias = isset($node->node_alias_module) ? $node->node_alias_module : '';
?>
<?php
print render($title_prefix);
?>
<?php if ($block->subject): ?>
  <h2<?php print $title_attributes; ?>><?php print $block->subject ?></h2>
<?php endif; ?>
<?php print render($title_suffix); ?>

  <a href="<?php print $node_url; ?>" title="<?php print $prefix_title . ' ' . strip_tags($node->title); ?>" class="info"
  data-tracking data-track-action="cta" data-track-category="cross-product-<?php print $node_alias; ?>" data-track-label="<?php print url('node/' . $node->nid); ?>" data-track-type="event">
  <img src="<?php print $interchange['data_thumb'] ?>" alt="<?php print $image_alt; ?>" data-interchange='<?php print $interchange['style_list']; ?>' class="product-image"/>
  <h2 class="kind"><?php print $kind->name; ?></h2>
  <h1 class="title"><?php print $prefix_title.'<br/>'.$node->title; ?></h1></a>
<?php if ($buy_url && $buy_url_title): ?>
  <a href="javascript:void(0)" title="<?php print $buy_url_title; ?>" class="cta btn btn-black" data-ctbuy-key="<?php print $buy_url; ?>" data-ctbuy-lang="<?php print $language_buy; ?>"
    data-tracking data-track-action="cta" data-track-category="cross-product-<?php print $node_alias; ?>" data-track-label="<?php print url('node/' . $node->nid); ?>" data-track-type="event">
    <?php print $buy_url_title; ?>
  </a>
<?php else: ?>
  <a href="<?php print $node_url; ?>" title="<?php print $prefix_title . ' ' . strip_tags($node->title); ?>" class="cta btn btn-black" data-tracking data-track-action="cta" data-track-category="cross-product-<?php print $node_alias; ?>" data-track-label="<?php print url('node/' . $node->nid); ?>" data-track-type="event">
    <?php print _hs_resource_get('discover','plain', FALSE, FALSE, FALSE, 'Discover'); ?>
  </a>
<?php endif; ?>
