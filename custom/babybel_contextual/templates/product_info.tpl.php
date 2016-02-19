<?php 
	$title = $element['#content']['title'];
	$subtitle = $element['#content']['subtitle'];
?>
<?php if($title_suffix): ?>
	<div class="<?php print $classes; ?>">
	<?php print render($title_suffix); ?>
<?php endif; ?>

<?php 
	if(!empty($title)) {
		print '<h2 class="title-1">' . $title . '</h2>';
	}
?>

<?php
	if(!empty($subtitle)) {
		print '<p class="text-description">' . $subtitle . '</p>';
	}
?>


<?php if($title_suffix): ?>
</div>
<?php endif; ?>

