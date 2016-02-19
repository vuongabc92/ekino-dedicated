<?php
	$img_path = image_style_url('1440x492', $element['#content']['uri']);
?>

<?php if($title_suffix): ?>
	<div class="<?php print $classes; ?>">
	<?php print render($title_suffix); ?>
<?php endif; ?>

<?php 
	if($element['#content']['uri']) {
?>
<div class="page-cover visible-md visible-lg">
    <img alt="Babybel" src="<?php print $img_path; ?>">
</div>
<!-- .page-cover -->
<?php 
	}
?>

<?php if($title_suffix): ?>
</div>
<?php endif; ?>


