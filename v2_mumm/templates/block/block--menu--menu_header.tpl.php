<?php

/**
 * @file block--menu--menu_header.tpl.php.
 * Render block menu--menu header
 *
 */
?>
<?php print $mothership_poorthemers_helper;  ?>

  <?php print render($title_prefix); ?>
  
  
  <?php print $content ?>

  <?php if (!theme_get_setting('mothership_classes_block_contentdiv') AND $block->module == "block"): ?>
  <div <?php print $content_attributes; ?>>
  
  </div>
<?php endif ?>
<?php print render($title_suffix); ?>
