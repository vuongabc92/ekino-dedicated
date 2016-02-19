<?php if($title_suffix): ?>
	<div class="<?php print $classes; ?>">
	<?php print render($title_suffix); ?>
<?php endif; ?>
<?php 

	if(isset($element['#content']['content'])) {
		print $element['#content']['content'];
	}
?>
<?php if($title_suffix): ?>
</div>
<?php endif; ?>