<?php
global $language, $base_root;
$image_uri = isset($node->field_picture[LANGUAGE_NONE][0]['uri']) ? $node->field_picture[LANGUAGE_NONE][0]['uri'] : '';
$content = isset($node->field_content[LANGUAGE_NONE][0]['value']) ? $node->field_content[LANGUAGE_NONE][0]['value'] : '';
$intro = isset($node->field_introduction[LANGUAGE_NONE][0]['value']) ? $node->field_introduction[LANGUAGE_NONE][0]['value'] : '';
?>
<?php print render($title_prefix); ?>
<?php print render($title_suffix); ?>
  <h2 class="title-1"><?php print $node->title; ?></h2>
  <!-- .introduce -->
  <?php // if($intro) { ?>
  <!--<div class="text-description">-->
      <!--<p><?php // print $intro; ?></p>-->
  <!--</div>-->
  <?php // }?>
  <!-- .thumb -->
  <?php
    if($image_uri) {
      print '<div class="thumb">';
      print '<img src="' . image_style_url('1440x801', $image_uri) . '" alt="' . $node->title . '">';
      print '</div>';
    }
  ?>
  <!-- .content -->
  <?php if($content) { ?>
  <div class="content custom-editor">
    <?php print $content; ?>
  </div>
<?php } ?>
