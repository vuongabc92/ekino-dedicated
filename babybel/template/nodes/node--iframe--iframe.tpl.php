<?php
$field_iframe_url = isset($node->field_iframe_url[LANGUAGE_NONE][0]['url']) ? $node->field_iframe_url[LANGUAGE_NONE][0]['url'] : '';
$image_uri = isset($node->field_mobile_image[LANGUAGE_NONE][0]['uri']) ? $node->field_mobile_image[LANGUAGE_NONE][0]['uri'] : '';

$status_scrollbar = isset($node->field_enable_scrollbar[LANGUAGE_NONE][0]['value']) ? $node->field_enable_scrollbar[LANGUAGE_NONE][0]['value'] : 0;
//field_enable_scrollbar
//krumo($node);
$class_scrollbar = 'scrolling="no"';
$add_class = '';
if ($status_scrollbar) {
  $class_scrollbar = 'scrolling="yes"';
  $add_class = 'scroll-iframe';
}

$introduction = isset($node->field_introduction_long_text[LANGUAGE_NONE][0]['value']) ? $node->field_introduction_long_text[LANGUAGE_NONE][0]['value'] : '';
?>
<?php if ($field_iframe_url || $image_uri) { ?>
  <div class="news-cover-block">
      <?php print render($title_prefix); ?>
      <?php print render($title_suffix); ?>
      <h2 class="title-1"><?php print $node->title; ?></h2>
      <div class="text-description"><?php print '<p>' . nl2br($introduction) . '</p>'; ?></div>
      <div class="content <?php print $add_class; ?>" >
          <?php
          if ($field_iframe_url) {
            print '<div class="embed-responsive embed-responsive-16by7 hidden-xs">';
            print '<iframe ' . $class_scrollbar . ' src="' . str_replace('http:', '', $field_iframe_url) . '" frameborder="0" allowfullscreen=""></iframe>';
            print '</div>';
          }
          ?>
          <?php
          if ($image_uri) {
            ?>
            <a href="<?php print $field_iframe_url; ?>" title="<?php print $node->title; ?>" target="_blank" class="visible-xs">
                <img src="<?php print image_style_url('1440x801', $image_uri); ?>" alt="<?php print $node->title; ?>">
            </a>
            <?php
          }
          ?>
      </div>
      <!-- .content -->
  </div>
  <!-- .news-cover-block -->
<?php } ?>