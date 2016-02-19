<?php
/*
 * @file
 * node--module_video.tpl.php.
 *
 */
$image_transparent = v2_mumm_custom_get_path('images');
?>
<?php
$uri_image_video = isset($node->field_video_player[LANGUAGE_NONE][0]['thumbnail_path']) ? $node->field_video_player[LANGUAGE_NONE][0]['thumbnail_path'] : NULL;
$video_title = isset($node->field_video_title[LANGUAGE_NONE][0]['value']) ? $node->field_video_title[LANGUAGE_NONE][0]['value'] : '';
$field_introduction = isset($node->field_introduction[LANGUAGE_NONE][0]['value']) ? $node->field_introduction[LANGUAGE_NONE][0]['value'] : '';
$image = isset($node->field_video_image[LANGUAGE_NONE][0]['uri']) ? $node->field_video_image[LANGUAGE_NONE][0]['uri'] : '';
$url_video = $node->field_video_player['und'][0]['video_url'];
// Get id video for url youtube.
$video_id = get_id_youtube_from_url($url_video);
//Condition image and video youtube.
$image_alt = !empty($node->field_video_image[LANGUAGE_NONE][0]['alt']) ? $node->field_video_image[LANGUAGE_NONE][0]['alt'] : strip_tags($node->title);

if ($image) :
  $crop_style_list = array('780x495', '780x495', '780x495');
  $interchange = v2_mumm_interchange_images($image, $crop_style_list);
else:
  $image = '//img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg';
  $interchange = '["' . $image . '","' . $image . '","' . $image . '"]';
endif;

$node_alias = drupal_lookup_path('alias', 'node/' .$node->nid);
?>
<div class="video-block spacing-bottom">
  <?php if ($video_title): ?>
    <h2 class="title"><?php print $video_title; ?></h2>
  <?php endif; ?>
    <div class="desc">
        <?php if ($field_introduction): ?>
          <p><?php print nl2br($field_introduction); ?></p>
        <?php endif; ?>
    </div>    
  <div data-video-src="<?php print $url_video; ?>" data-type="<?php print $video_name; ?>" data-video-frame class="video">
    <img src="<?php print $image_transparent; ?>transparent.png" data-interchange='<?php print $interchange; ?>' alt="<?php print $image_alt; ?>">
    <a href="javascript:void(0)" title="<?php print $video_title; ?>" class="icon icon-play"
      data-tracking data-track-action="play" data-track-category="video-<?php print $node_alias; ?>" data-track-label="<?php print $video_id; ?>" data-track-type="event">
      <?php print $video_title; ?>
    </a>
  </div>
</div>
