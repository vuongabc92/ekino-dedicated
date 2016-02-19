<?php if($title_suffix): ?>
    <div class="<?php print $classes; ?>">
    <?php print render($title_suffix); ?>
<?php endif; ?>

<?php 
    if($element['#content']['image_path']) {
?>
        <img alt="Babybel" src="<?php print $element['#content']['image_path']; //print image_style_url('639x530', $background_footer->uri); ?>">
<?php 
    }
?>

<?php if($title_suffix): ?>
</div>
<?php endif; ?>

