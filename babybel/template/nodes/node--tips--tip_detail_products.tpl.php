<?php
$key = isset($node->field_color[LANGUAGE_NONE][0]['rgb']) ? $node->field_color[LANGUAGE_NONE][0]['rgb'] : '';
$color = babybel_common_switch_color_key_to_string($key);

$alt_picture = isset($node->field_picture[LANGUAGE_NONE][0]['alt']) ? $node->field_picture[LANGUAGE_NONE][0]['alt'] : '';
$title_picture = isset($node->field_picture[LANGUAGE_NONE][0]['title']) ? $node->field_picture[LANGUAGE_NONE][0]['title'] : '';
?>
<?php print render($title_prefix); ?>
<?php print render($title_suffix); ?>

<div class="tabs-panel <?php print $color; ?>-bgd">
    <?php if (isset($node->field_picture[LANGUAGE_NONE][0]['uri'])) { ?>
      <div class="row inner">
          <div class="col-md-5 left-panel">
              <div class="img-circle">
                  <img title="<?php print $title_picture; ?>" src="<?php print image_style_url('280x280', $node->field_picture[LANGUAGE_NONE][0]['uri']); ?>" alt="<?php print $alt_picture; ?>">
              </div>
          </div>
          <!-- .col-md-5 -->
          <div class="col-md-7 right-panel">
              <div class="content">
                  <h3 class="title"><?php print $node->title; ?></h3>
                  <div class="description custom-editor">
                      <?php print $node->field_content[LANGUAGE_NONE][0]['value']; ?>
                  </div>
              </div>
          </div>
          <!-- .col-md-7 -->
          <a href="#" title="close" class="btn-panel-close">close</a>
      </div>
      <!-- .row inner -->
    <?php } else { ?>
      <div class="inner">
          <div class="content">
              <h3 class="title"><?php print $node->title; ?></h3>
              <div class="description custom-editor">
                  <?php print $node->field_content[LANGUAGE_NONE][0]['value']; ?>
              </div>
          </div>
          <!-- .content -->
          <a href="#" title="close" class="btn-panel-close">close</a>
      </div>
      <!-- .inner -->
    <?php } ?>
</div>
<!-- .tabs-panel -->