<?php
/*
 * @file node--module_image_text.tpl.php.
 *
 */

$picture_instance = field_info_instance('node', 'field_visual_image_text', 'module_image_text');
$crop_style_list = $picture_instance['widget']['settings']['manualcrop_styles_list'];

$image = isset($node->field_visual_image_text[LANGUAGE_NONE][0]['uri']) ? $node->field_visual_image_text[LANGUAGE_NONE][0]['uri'] : '';
$interchange = v2_mumm_interchange_images($image, $crop_style_list);
$field_subtitle = isset($node->field_subtitle[LANGUAGE_NONE][0]['value']) ? $node->field_subtitle[LANGUAGE_NONE][0]['value'] : '';
$field_introduction = isset($node->field_article_introduction[LANGUAGE_NONE][0]['value']) ? $node->field_article_introduction[LANGUAGE_NONE][0]['value'] : '';

$button_url = isset($node->field_cta[LANGUAGE_NONE][0]['url']) ? $node->field_cta[LANGUAGE_NONE][0]['url'] : '';
$button_title = isset($node->field_cta[LANGUAGE_NONE][0]['title']) ? $node->field_cta[LANGUAGE_NONE][0]['title'] : '';
$external_url = v2_mumm_check_url_external($button_url);

$field_maps_long = isset($node->field_gmap_long[LANGUAGE_NONE][0]['value']) ? $node->field_gmap_long[LANGUAGE_NONE][0]['value'] : '';
$field_maps_lat = isset($node->field_gmap_lat[LANGUAGE_NONE][0]['value']) ? $node->field_gmap_lat[LANGUAGE_NONE][0]['value'] : '';

$marker_icon_src = v2_mumm_custom_get_path('images') . 'icon-pin.png';
$title_size = $node->field_title_size[LANGUAGE_NONE][0]['value'];

$type_col = isset($node->field_type_text[LANGUAGE_NONE][0]['value']) ? $node->field_type_text[LANGUAGE_NONE][0]['value'] : '';
$one_column = isset($node->field_one_column[LANGUAGE_NONE][0]['value']) ? $node->field_one_column[LANGUAGE_NONE][0]['value'] : '';
$tow_column_one = isset($node->field_two_column[LANGUAGE_NONE][0]['value']) ? $node->field_two_column[LANGUAGE_NONE][0]['value'] : '';
$tow_column_two = isset($node->field_two_column[LANGUAGE_NONE][1]['value']) ? $node->field_two_column[LANGUAGE_NONE][1]['value'] : '';
//Condition enable button readmore.
$enable_readmore = true;
if (!empty($type_col)):
  if (empty($field_introduction) && empty($one_column) && empty($tow_column_one) && empty($tow_column_two) && empty($field_maps_long) && empty($field_maps_lat)):
    $enable_readmore = false;
  endif;
else:
  $enable_readmore = false;
endif;
$read_more_get_language = _hs_resource_get('read_more','plain', FALSE, FALSE, FALSE, 'Read more');
$read_more = '<button type="button" name="open-button" title="'.$read_more_get_language.'" class="btn btn-gray open-btn">'.$read_more_get_language.'</button>';
$close_get_language = _hs_resource_get('close','plain', FALSE, FALSE);
$close = '<button type="button" name="close-button" title="'.$close_get_language.'" class="btn btn-gray close-btn">'.$close_get_language.'</button>';

$node_alias = drupal_lookup_path('alias', 'node/' .$node->nid);
?>
<div class="image-text banner-item spacing-bottom">
  <div class="grid-fluid">
    <div class="inner"><span data-interchange='<?php print $interchange; ?>' data-type="background-image" class="image-background"></span></div>
    <div data-read-more="" class="description">
      <h1 class="image-title <?php print ($title_size == 0) ? 'large' : 'small'; ?>"><?php print $node->title; ?></h1>
      <?php if($field_subtitle): ?>
        <h2 class="sub-title"><?php print $field_subtitle; ?></h2>
      <?php endif; ?>
      <p><?php print nl2br($field_introduction); ?></p>
      <?php if ($enable_readmore): ?>
        <?php print hs_resource_contextual_link('read_more', $read_more, 'open-btn'); ?>
      <?php endif; ?>
      <div class="content">
        <?php if ($type_col == '1column'): ?>
          <div class="editor">
            <?php if (!empty($field_maps_long) || !empty($field_maps_lat)): ?>
              <div data-gmap="" data-lat="<?php print trim($field_maps_lat); ?>" data-long="<?php print trim($field_maps_long); ?>" data-icon-marker="<?php print $marker_icon_src; ?>" class="map-frame spacing-bottom hidden-sm visible-xs"></div>
            <?php endif; ?>

            <?php if ($one_column): ?>
              <?php print $one_column; ?>
            <?php endif; ?>
            <?php if (!empty($field_maps_long) || !empty($field_maps_lat)): ?>
              <div data-gmap="" data-lat="<?php print trim($field_maps_lat); ?>" data-long="<?php print trim($field_maps_long); ?>" data-icon-marker="<?php print $marker_icon_src; ?>" class="map-frame hidden-xs"></div>
            <?php endif; ?>
            <?php if (!empty($button_title) || !empty($button_url)): ?>
              <a href="<?php print $external_url['path']; ?>" title="<?php print $button_title; ?>" class="btn red-btn center-btn" <?php print ($external_url['external']) ? 'target="_blank"' : ''; ?>
                data-tracking data-track-action="cta" data-track-category="image-text-<?php print $node_alias; ?>" data-track-label="<?php print $external_url['path']; ?>" data-track-type="event">
                <?php print $button_title; ?>
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <?php if ($type_col == '2column'): ?>
          <div class="editor two-col border">
            <div class="row">
              <?php if (!empty($field_maps_long) || !empty($field_maps_lat)): ?>
                <div data-gmap="" data-lat="<?php print trim($field_maps_lat); ?>" data-long="<?php print trim($field_maps_long); ?>" data-icon-marker="<?php print $marker_icon_src; ?>" class="map-frame spacing-bottom hidden-sm visible-xs"></div>
              <?php endif; ?>
              <?php if ($tow_column_one): ?>
                <div class="col">
                  <?php print $tow_column_one; ?>
                </div>
              <?php endif; ?>
              <?php if (!empty($tow_column_two) || !empty($field_maps_long) || !empty($field_maps_lat)): ?>
                <div class="col">
                  <?php print $tow_column_two; ?>
                  <?php if (!empty($field_maps_long) || !empty($field_maps_lat)): ?>
                    <div data-gmap="" data-lat="<?php print trim($field_maps_lat); ?>" data-long="<?php print trim($field_maps_long); ?>" data-icon-marker="<?php print $marker_icon_src; ?>" class="map-frame hidden-xs"></div>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>
            <?php if (!empty($button_title) || !empty($button_url)): ?>
              <a href="<?php print $external_url['path']; ?>" title="<?php print $button_title; ?>" class="btn red-btn center-btn" <?php print ($external_url['external']) ? 'target="_blank"' : ''; ?>
                data-tracking data-track-action="cta" data-track-category="image-text-<?php print $node_alias; ?>" data-track-label="<?php print $external_url['path']; ?>" data-track-type="event">
                <?php print $button_title; ?>
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
        <?php print hs_resource_contextual_link('close', $close); ?>
      </div>
    </div>
  </div>
</div>
