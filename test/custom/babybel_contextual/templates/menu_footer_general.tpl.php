<?php if($title_suffix): ?>
	<div class="<?php print $classes; ?>">
	<?php print render($title_suffix); ?>
<?php endif; ?>
<ul class="menu-copyright">
<?php 
	if(isset($element['#content']['menu_footer_content'])) {
		print $element['#content']['menu_footer_content'];
	}
?>
</ul>
<?php if($title_suffix): ?>
</div>
<?php endif; ?>