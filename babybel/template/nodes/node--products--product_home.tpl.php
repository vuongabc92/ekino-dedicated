<?php
hide($content['comments']);
hide($content['links']);
$subtitle = isset($node->field_subtitle[LANGUAGE_NONE][0]['value']) ? $node->field_subtitle[LANGUAGE_NONE][0]['value'] : '';
$color = babybel_common_switch_color_key_to_string($node->field_color[LANGUAGE_NONE][0]['rgb']);

$title_preview = isset($node->field_preview_picture[LANGUAGE_NONE][0]['title']) ? $node->field_preview_picture[LANGUAGE_NONE][0]['title'] : '';
$alt_preview = isset($node->field_preview_picture[LANGUAGE_NONE][0]['alt']) ? $node->field_preview_picture[LANGUAGE_NONE][0]['alt'] : '';
?>

<div class="item">
    <?php print render($title_prefix); ?>
    <?php print render($title_suffix); ?>
    <div class="inner text-<?php print $color; ?>"><img title="<?php print $title_preview; ?>" src="<?php print image_style_url('500x500', $node->field_preview_picture[LANGUAGE_NONE][0]['uri']); ?>" alt="<?php print $alt_preview; ?>">
        <h3 class="title-2"><?php print truncate_utf8($node->title, 50, TRUE, TRUE); ?></h3>
        <p class="decs"><?php print $subtitle; ?></p>
    </div>
</div>

