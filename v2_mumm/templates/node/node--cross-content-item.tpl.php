<?php
/*
 * @file node--cross-content-item.tpl.php.
 *
 */
$kind = '';
$type = $node->type;
$node_alias = isset($node->node_alias_module) ? $node->node_alias_module : '';
$tracking_args = 'data-tracking data-track-action="cta" data-track-category="cross-content-'. $node_alias .'" data-track-label="'.$node_url.'" data-track-type="event"';
// Get kind of content.
if ($type == 'article') :
  $kind = taxonomy_term_load($node->field_article_category[LANGUAGE_NONE][0]['tid']);
  $kind = $kind->name;
  $kind = '<a href="'.$node_url.'" title="'. strip_tags($node->title) .'" class="link-title" '.$tracking_args.'>'. $kind.'</a>';
elseif ($type == 'champagne_ritual') :
  $field_ritual_number = field_get_items('node', $node, 'field_ritual_number');
  $field_ritual_number = !empty($field_ritual_number[0]['value']) ? $field_ritual_number[0]['value'] : '';
  $kind = _hs_resource_get('tips_n°','plain', FALSE, FALSE, FALSE, 'Tips n°'). str_pad($field_ritual_number, 2, 0, STR_PAD_LEFT);
  $kind = '<a href="'.$node_url.'" title="'. strip_tags($node->title) .'" class="link-title" '.$tracking_args.'>'. $kind.'</a>';
  $kind = hs_resource_contextual_link('tips_n°', $kind);
endif;
// Get style image.
$picture_instance = field_info_instance('node', 'field_picture_collection', $type);
$crop_style_list = $picture_instance['widget']['settings']['manualcrop_styles_list'];
$image_src = isset($node->field_picture[LANGUAGE_NONE][0]['uri']) ? $node->field_picture[LANGUAGE_NONE][0]['uri'] : '';
$image_alt = !empty($node->field_picture[LANGUAGE_NONE][0]['alt']) ? $node->field_picture[LANGUAGE_NONE][0]['alt'] : strip_tags($node->title);
$interchange = '';

if ($crop_style_list) :
  $interchange = v2_mumm_interchange_images($image_src, $crop_style_list, $type);
else :
  $crop_style_list = array('340x340', '340x340', '340x340');
  $interchange = v2_mumm_interchange_images($image_src, $crop_style_list, $type);
endif;
$buy_now_get_language = _hs_resource_get('read_more','plain', FALSE, FALSE, FALSE, 'Read more');
$read_more = '<a href="'.$node_url.'" title="'.$buy_now_get_language.'" class="btn btn-white" '.$tracking_args.'>'.$buy_now_get_language.'</a>';
?>

<?php print render($title_prefix); ?>
<div class="visual">
    <a href="<?php print $node_url; ?>" title="<?php print strip_tags($node->title); ?>" class="image-wrap">
    <img src="<?php print $interchange['data_thumb']; ?>" data-interchange='<?php print $interchange['style_list']; ?>' alt="<?php print $image_alt; ?>" class="product-image"/>
  </a>
  <div class="roll-over">
    <div class="inner">
      <div class="content">
          <?php print hs_resource_contextual_link('read_more', $read_more); ?>
      </div>
    </div>
  </div>
</div>
<h3 class="kind">
  <?php print $kind;?>
</h3>
<h1 class="title">
    <a href="<?php print $node_url; ?>" title="<?php print strip_tags($node->title); ?>" class="link-title" <?php echo $tracking_args; ?>>
    <?php print $node->title; ?>
  </a>
</h1>
<?php print render($title_suffix); ?>
