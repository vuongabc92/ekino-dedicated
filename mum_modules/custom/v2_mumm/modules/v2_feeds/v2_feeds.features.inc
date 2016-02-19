<?php
/**
 * @file
 * v2_feeds.features.inc
 */

/**
 * Implements hook_image_default_styles().
 */
function v2_feeds_image_default_styles() {
  $styles = array();

  // Exported image style: v2_feeds_thumbnail.
  $styles['v2_feeds_thumbnail'] = array(
    'name' => 'v2_feeds_thumbnail',
    'label' => 'Wall of Victories - Thumbnail',
    'effects' => array(
      1 => array(
        'label' => 'Scale and crop',
        'help' => 'Scale and crop will maintain the aspect-ratio of the original image, then crop the larger dimension. This is most useful for creating perfectly square thumbnails without stretching the image.',
        'effect callback' => 'image_scale_and_crop_effect',
        'dimensions callback' => 'image_resize_dimensions',
        'form callback' => 'image_resize_form',
        'summary theme' => 'image_resize_summary',
        'module' => 'image',
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => 390,
          'height' => 390,
        ),
        'weight' => 1,
      ),
    ),
  );

  return $styles;
}
