<?php
hide($content['comments']);
hide($content['links']);
?>
<?php print render($title_prefix); ?>
<?php print render($title_suffix); ?>
<h2 class="title-1 white-color"><?php print $node->title; ?></h2>
<?php if ($node->field_picture[LANGUAGE_NONE][0]['uri']): ?>
  <div class="thumb"><img src="<?php print image_style_url('639x530', $node->field_picture[LANGUAGE_NONE][0]['uri']) ?>" alt="<?php print $node->title; ?>">
  </div>
<?php endif; ?>
<div class="text-description-2 custom-margin">
    <div class="content custom-editor">
        <?php print nl2br($node->field_content[LANGUAGE_NONE][0]['value']); ?>
    </div>
</div>
