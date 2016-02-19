<?php
/*
 * @file
 * node--module_intro.tpl.php.
 *
 */
?>
<?php
$image_src = isset($node->field_visual_intro[LANGUAGE_NONE][0]['uri']) ? $node->field_visual_intro[LANGUAGE_NONE][0]['uri'] : '';
$image_alt = !empty($node->field_visual_intro[LANGUAGE_NONE][0]['alt']) ? $node->field_visual_intro[LANGUAGE_NONE][0]['alt'] : strip_tags($node->title);
$picture_instance = field_info_instance('node', 'field_visual_intro', 'module_intro');
$crop_style_list = $picture_instance['widget']['settings']['manualcrop_styles_list'];
$interchange = v2_mumm_interchange_images($image_src, $crop_style_list);

$sub_title = isset($node->field_subtitle[LANGUAGE_NONE][0]['value']) ? $node->field_subtitle[LANGUAGE_NONE][0]['value'] : '';
$content = isset($node->field_content[LANGUAGE_NONE][0]['value']) ? $node->field_content[LANGUAGE_NONE][0]['value'] : '';
$image_transparent = v2_mumm_custom_get_path('images');
?>
<div class="intro-block spacing-bottom">
  <div class="grid-fluid">
    <?php  if ($image_src) : ?>
        <img src="<?php print image_style_url('1272x600', $image_src); ?>" alt="<?php print $image_alt; ?>"/>
    <?php  endif; ?>
    <h1 class="title-medium"><?php print $node->title; ?></h1>
    <?php if ($sub_title): ?>
      <h2 class="sub-title"><?php print $sub_title; ?></h2>
    <?php endif; ?>
    <?php if ($content): ?>
      <div class="desc">
        <div><?php print nl2br($content); ?></div>
      </div>
    <?php endif; ?>
  </div>
</div>