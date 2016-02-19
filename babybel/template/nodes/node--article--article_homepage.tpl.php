<?php
hide($content['comments']);
hide($content['links']);
?>

<div class="caption">
	<?php print render($title_prefix); ?>
    <?php print render($title_suffix); ?>
	<h2 class="title-1"><?php print $node->title; ?></h2>
    <?php if ($content['field_picture']['#items'][0]['uri']): ?>
      <img src="<?php print image_style_url('940x530', $content['field_picture']['#items'][0]['uri']); ?>" alt="<?php print $node->title; ?>">
    <?php endif; ?>
    <div class="text-description custom-editor"><?php print $content['field_content']['#items'][0]['value']; ?></div>
</div>