<?php
$color = babybel_common_switch_color_key_to_string($node->field_color[LANGUAGE_NONE][0]['rgb']);
?>
<?php print render($title_prefix); ?>
<?php print render($title_suffix); ?>

<a class="inner text-<?php print $color; ?>" title="<?php print $node->title; ?>" href="#">
    <img alt="<?php print $node->field_preview_picture[LANGUAGE_NONE][0]['alt']; ?>" src="<?php print image_style_url('467x467', $node->field_preview_picture[LANGUAGE_NONE][0]['uri']); ?>">
    <h3 class="title-2"><?php print truncate_utf8($node->title, 50, TRUE, TRUE); ?></h3>
</a>

