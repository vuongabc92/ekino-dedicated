<?php
/*
 * @file
 * node--module_banner.tpl.php.
 *
 */
?>

<?php
$cta_url = isset($node->field_cta[LANGUAGE_NONE][0]['url']) ? $node->field_cta[LANGUAGE_NONE][0]['url'] : '';
$cta_title = isset($node->field_cta[LANGUAGE_NONE][0]['title']) ? $node->field_cta[LANGUAGE_NONE][0]['title'] : '';
$title = isset($node->field_cta_block_title[LANGUAGE_NONE][0]['value']) ? $node->field_cta_block_title[LANGUAGE_NONE][0]['value'] : '';
$external_url = v2_mumm_check_url_external($cta_url);
$image_src = isset($node->field_visual_action[LANGUAGE_NONE][0]['uri']) ? $node->field_visual_action[LANGUAGE_NONE][0]['uri'] : '';
$image_alt = !empty($node->field_visual_action[LANGUAGE_NONE][0]['alt']) ? $node->field_visual_action[LANGUAGE_NONE][0]['alt'] : strip_tags($title);
$introduction = isset($node->field_introduction[LANGUAGE_NONE][0]['value']) ? $node->field_introduction[LANGUAGE_NONE][0]['value'] : '';
$image_transparent = v2_mumm_custom_get_path('images');
$picture_instance = field_info_instance('node', 'field_visual_action', 'module_call_to_action');
$crop_style_list = $picture_instance['widget']['settings']['manualcrop_styles_list'];
ksort($crop_style_list);
$interchange = v2_mumm_interchange_images($image_src, $crop_style_list);

$class = '';
if (empty($image_src)):
  $class = 'none-image';
endif;

$node_alias = drupal_lookup_path('alias', 'node/' .$node->nid);
?>

<div class="call-to-action spacing-bottom <?php print $class; ?>">
  <div class="grid-fluid">
    <div class="inner">
      <div class="content">
        <div class="row">
          <?php if ($image_src): ?>
            <div class="col image">
              <img src="<?php print $image_transparent; ?>transparent.png" data-interchange='<?php print $interchange; ?>' alt="<?php print $image_alt; ?>">
            </div>
          <?php endif; ?>
          <div class="col desc">
            <?php if ($title): ?>
              <h2 class="title"><?php print $title; ?></h2>
            <?php endif; ?>
            <?php if ($introduction): ?>
              <h2 class="intro"><?php print nl2br($introduction); ?></h2>
            <?php endif; ?>
            <?php if ($external_url): ?>
              <a href="<?php print $external_url['path']; ?>" title="<?php print $cta_title; ?>" <?php print ($external_url['external']) ? 'target="_blank"' : ''  ?> class="btn red-btn"
                data-tracking data-track-action="cta" data-track-category="cta-<?php print $node_alias; ?>" data-track-label="<?php print $external_url['path']; ?>" data-track-type="event">
                <?php print $cta_title; ?>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
