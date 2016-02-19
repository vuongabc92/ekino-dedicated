<?php

/*
 * @file node--module_banner.tpl.php.
 *
 */

$picture_instance = field_info_instance('node', 'field_visual_banner', 'module_banner');
$crop_style_list = $picture_instance['widget']['settings']['manualcrop_styles_list'];
$image = isset($node->field_visual_banner[LANGUAGE_NONE][0]['uri']) ? $node->field_visual_banner[LANGUAGE_NONE][0]['uri'] : '';
ksort($crop_style_list);
$interchange = v2_mumm_interchange_images($image, $crop_style_list);

$section_name = isset($node->field_section_name[LANGUAGE_NONE][0]['value']) ? $node->field_section_name[LANGUAGE_NONE][0]['value'] : '';
$sub_title = isset($node->field_preview_subtitle[LANGUAGE_NONE][0]['value']) ? $node->field_preview_subtitle[LANGUAGE_NONE][0]['value'] : '';
$link = isset($node->field_cta[LANGUAGE_NONE][0]['url']) ? $node->field_cta[LANGUAGE_NONE][0]['url'] : '';
$external_url = v2_mumm_check_url_external($link);
$node_alias = drupal_lookup_path('alias', 'node/' .$node->nid);
?>

<div class="banner-block banner-item spacing-bottom">
  <div class="grid-fluid">
    <div class="inner">
      <span data-interchange='<?php print $interchange; ?>' data-type="background-image" class="image-background"></span>
      <div class="desc">
        <div class="wrap-content">
          <div class="content">
            <?php if ($section_name): ?>
              <span class="topic"><?php print $section_name; ?></span>
            <?php endif; ?>
            <h1 class="title"><?php print $node->title; ?></h1>
            <?php if ($sub_title): ?>
              <p><?php print $sub_title; ?></p>
            <?php endif; ?>

            <?php if ($external_url): ?>
              <a href="<?php print $external_url['path']; ?>" title="<?php print $node->field_cta[LANGUAGE_NONE][0]['title']; ?>" class="btn btn-white"
                data-tracking data-track-action="cta" data-track-category="banner-<?php print $node_alias; ?>" data-track-label="<?php print $external_url['path']; ?>" data-track-type="event"
                <?php print ($external_url['external']) ? 'target="_blank"' : ''  ?>>
                <?php print $node->field_cta[LANGUAGE_NONE][0]['title']; ?>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
