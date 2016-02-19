<?php
hide($content['comments']);
hide($content['links']);
global $language;

$background_color = isset($node->field_background_color[LANGUAGE_NONE][0]['rgb']) ? $node->field_background_color[LANGUAGE_NONE][0]['rgb'] : '';
$title = $node->title;
$cta_title = isset($node->field_cta[LANGUAGE_NONE][0]['title']) ? $node->field_cta[LANGUAGE_NONE][0]['title'] : '';
$cta_url = isset($node->field_cta[LANGUAGE_NONE][0]['url']) ? $node->field_cta[LANGUAGE_NONE][0]['url'] : '#';
$background_fid = isset($node->field_background_image[LANGUAGE_NONE][0]['fid']) ? $node->field_background_image[LANGUAGE_NONE][0]['fid'] : '';
$content = isset($node->field_content[LANGUAGE_NONE][0]['value']) ? $node->field_content[LANGUAGE_NONE][0]['value'] : '';
$hiden_title_status = $node->field_hide_title[LANGUAGE_NONE][0]['value'];
$image_fid = $node->field_image[LANGUAGE_NONE][0]['fid'];

$background_source = file_load($background_fid);
$background_path = file_create_url($background_source->uri);

$image_source = file_load($image_fid);
$image_path = file_create_url($image_source->uri);

$background_class = '';
$background_style = '';
$button_class = '';
$hidden_class = '';

if ($cta_title && $cta_url && ($cta_title != $cta_url) && !url_is_external($cta_title)) {
  $background_class = 'background-cta';
  if($content) {
    $background_class = '';
  }
  $button_class = 'btn-viewmore style-1';
}
else {
  $background_class = 'background-only';
  $button_class = 'link-viewmore';
  $cta_title = '';
}

if ($background_source) {
  $background_style = 'background-image: url(' . $background_path . ')';
}
else {
  $background_style = 'background-color: ' . $background_color . ';';

  if(!$cta_title && $cta_url) {
    $background_class = 'content-only';
  }
}

?>

<div class="wrap-box">
<?php print render($title_prefix); ?>
            <?php print render($title_suffix); ?>
    <div class="box <?php print $background_class; ?>" style="<?php print $background_style; ?>">
        <div class="content custom-editor">
            <?php
            if ($image_source) {
              ?>
              <img alt="<?php print $node->title; ?>" src="<?php print $image_path; ?>">
            <?php } ?>

            <?php
            if (!$hiden_title_status) {
              ?>
              <h3 class="title-box"><span class="symbol"></span><?php print truncate_utf8($node->title, 50, TRUE, TRUE); ?></h3>
            <?php } ?>
            <?php if ($content) { ?>
              <div class="desc">
                  <p><?php print $content; ?></p>
              </div>
        <?php } ?>
        </div>
        <!-- .content -->
        <?php
        $target_blank = url_is_external($cta_url) ? 'target="_blank"' : '';
        $cta_title = url_is_external($cta_title) ? '' : $cta_title;
        ?>
        <div class="wrap-btn">
            <?php
            if ($cta_url != '#') :
              ?>
              <?php if ($target_blank): ?>
                <a <?php print $target_blank; ?> class="<?php print $button_class; ?>" title="<?php print $cta_title; ?>" href="<?php print $cta_url; ?>"><?php print $cta_title; ?></a>
              <?php else: ?>
                <a  class="<?php print $button_class; ?>" title="<?php print $cta_title; ?>" href="<?php print url($cta_url); ?>"><?php print $cta_title; ?></a>
  <?php endif; ?>
<?php endif; ?>
        </div>
    </div>
    <!-- .box -->
</div>
<!-- .wrap-box -->
