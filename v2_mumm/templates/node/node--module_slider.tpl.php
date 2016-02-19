<?php
/*
 * @file node--module_slider.tpl.php.
 *
 */
unset($content['comments']);
unset($content['links']);
$picture_instance = field_info_instance('node', 'field_slider_collection', 'module_slider');

$entity_type = 'field_collection_item';
$bundle_name = 'field_slider_collection';
$info = field_info_instances($entity_type, $bundle_name);
$crop_style_list = $info['field_visual_slider']['widget']['settings']['manualcrop_styles_list'];
ksort($crop_style_list);
$slider_second_video = variable_get('slider_second_video', SLIDER_SECOND_VIDEO);
$node_alias = drupal_lookup_path('alias', 'node/' .$node->nid);
?>
<div data-slider data-duration="<?php print $slider_second_video; ?>" class="slider home-slider spacing-bottom">
  <?php
  if (isset($content['field_slider_collection']['#items'])) :
    foreach ($content['field_slider_collection']['#items'] as $key => $item) :

      $field = field_collection_item_load($item['value']);
      $image = $field->field_visual_slider[LANGUAGE_NONE][0]['uri'];
      $video = '';
      $class = 'item';
      if ($field->field_background_video[LANGUAGE_NONE][0]['uri']) :
        $video = file_create_url($field->field_background_video[LANGUAGE_NONE][0]['uri']);
        $class = 'item video';
      endif;

      $interchange = '';
      if ($crop_style_list) :
        $interchange = v2_mumm_interchange_images($image, $crop_style_list, 'module_slider');
      else :
        $crop_style_list = array('1272x600', '270x270', 'thumbnail');
        $interchange = v2_mumm_interchange_images($image, $crop_style_list, 'module_slider');
      endif;

      $title = isset($field->field_title[LANGUAGE_NONE][0]['value']) ? $field->field_title[LANGUAGE_NONE][0]['value'] : '';
      $short_title = isset($field->field_short_title[LANGUAGE_NONE][0]['value']) ? $field->field_short_title[LANGUAGE_NONE][0]['value'] : '';
      $link = isset($field->field_cta[LANGUAGE_NONE][0]['url']) ? $field->field_cta[LANGUAGE_NONE][0]['url'] : '';
      $date = time();
      $external_url = v2_mumm_check_url_external($field->field_cta[LANGUAGE_NONE][0]['url']);
      $image_alt = !empty($field->field_visual_slider[LANGUAGE_NONE][0]['alt']) ? $field->field_visual_slider[LANGUAGE_NONE][0]['alt'] : $short_title ;
      ?>

      <div data-thumb="<?php print $interchange['data_thumb'] . '&amp;random=' . $date; ?>" data-thumb-content="<?php print $short_title; ?>"  data-thumb-alt="<?php print $image_alt;?>" class="<?php print $class; ?>">
        <div class="banner-item">
          <div class="inner">
            <?php if ($video) : ?>
              <video preload="auto" muted loop class="video-background"  data-loaded-video >
                <source src="<?php print $video . '?type=1'; ?>" type="video/mp4">
              </video>
            <?php endif; ?>
            <span data-interchange='<?php print $interchange['style_list']; ?>' data-type="background-image" class="image-background"></span>
            <div class="desc">
              <div class="wrap-content">
                <div class="content">
                  <h2 class="title">
                    <?php print $field->field_title[LANGUAGE_NONE][0]['value']; ?>
                  </h2>
                  <?php
                  if ($field->field_text[LANGUAGE_NONE][0]['value']) :
                    print '<p>' . nl2br($field->field_text[LANGUAGE_NONE][0]['value']) . '</p>';
                  endif;
                  ?>
                  <a href="<?php print $external_url['path']; ?>" title="<?php print $field->field_cta[LANGUAGE_NONE][0]['title']; ?>" class="btn btn-white"
                    <?php print ($external_url['external']) ? 'target="_blank"' : ''  ?>
                    data-tracking data-track-action="cta" data-track-category="slider-<?php print $node_alias; ?>" data-track-label="<?php print $external_url['path']; ?>" data-track-type="event" data-track-non-interaction="1">
                    <?php print $field->field_cta[LANGUAGE_NONE][0]['title']; ?>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
    endforeach;
  endif;
  ?>
</div>