<?php
global $language;

$current_lang = $language->language;
$producs_title = babybel_variable_get('babybel_variable_products_title', $current_lang);
$producs_subtitle = babybel_variable_get('babybel_variable_products_subtitle', $current_lang);
?>
<?php if($title_suffix): ?>
	<div class="<?php print $classes; ?>">
	<?php print render($title_suffix); ?>
<?php endif; ?>
<h2 class="title-1"><?php print $producs_title; ?></h2>
<p class="text-description"><?php print nl2br($producs_subtitle); ?></p>
<?php if($title_suffix): ?>
</div>
<?php endif; ?>
