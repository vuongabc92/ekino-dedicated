<?php
global $language;
?>
<?php if ($title_suffix): ?>
  <div class="<?php print $classes; ?>">
      <?php print render($title_suffix); ?>
    <?php endif; ?>


    <?php
    global $base_root;
    $button_text = $element['#content']['content'];
    if (!empty($button_text)) {
      ?>
      <div class="text-center"><a href="<?php print url('products'); ?>" title="<?php print $button_text; ?>" class="btn-viewmore"><?php print $button_text; ?></a>
        <?php } ?>


        <?php if ($title_suffix): ?>
      </div>
    <?php endif; ?>


