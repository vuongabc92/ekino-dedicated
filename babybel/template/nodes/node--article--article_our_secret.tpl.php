<?php
hide($content['comments']);
hide($content['links']);
?>
<div class="container">
    <?php print render($title_prefix); ?>
    <?php print render($title_suffix); ?>
    <h2 class="title-1"><?php print $node->title; ?></h2>
    <?php if (isset($node->field_introduction[LANGUAGE_NONE][0]['value'])): ?>
      <div class="text-description custom-editor">
          <p><?php print isset($node->field_introduction[LANGUAGE_NONE][0]['value']) ? $node->field_introduction[LANGUAGE_NONE][0]['value'] : ''; ?></p>
      </div>
    <?php endif; ?>
    <?php if ($node->field_picture[LANGUAGE_NONE][0]['uri']): ?>
      <div class="thumb"><img src="<?php print image_style_url('940x576', $node->field_picture[LANGUAGE_NONE][0]['uri']) ?>" alt="<?php print $node->title; ?>">
      </div>
    <?php endif; ?>

    <div class="content custom-editor">
        <?php print nl2br($node->field_content[LANGUAGE_NONE][0]['value']); ?>
    </div>
</div>