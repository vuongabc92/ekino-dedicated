<?php
$title = $element['#content']['title'];
$desktop_path = $element['#content']['desktop_img_uri'];
$button_cta_title = $element['#content']['button_cta_title'];
$button_cta_url = $element['#content']['button_cta_url'];
global $language;
?>
<?php if ($title_suffix): ?>
  <div class="<?php print $classes; ?>">
      <?php print render($title_suffix); ?>
    <?php endif; ?>
    <?php
    if (!empty($title) || !empty($desktop_path) || !empty($button_cta_title) || !empty($button_cta_url)) {
      ?>

      <div class="push-block">
          <div class="row text-center">
              <div class="col-sm-6 thumb">
                  <?php
                  if (!empty($desktop_path)) {
                    ?>

                    <img src="<?php print image_style_url('408x193', $desktop_path); ?>" alt="Push">
                  <?php } ?>
              </div>
              <div class="col-sm-6 desc">
                  <?php
                  if (!empty($title)) {
                    ?>
                    <h3 class="title"><?php echo $title; ?></h3>
                  <?php } ?>
                  <?php
                  if (!empty($button_cta_title)):
                    $target_blank = url_is_external($button_cta_url) ? 'target="_blank"' : '';
                    ?>
                    <?php if ($target_blank): ?>
                      <a <?php print $target_blank; ?>href="<?php print $button_cta_url; ?>" title="<?php print $button_cta_title; ?>" class="btn-findout"><?php print $button_cta_title ?></a>
                    <?php else: ?>
                      <a  href="<?php print url($button_cta_url); ?>" title="<?php print $button_cta_title; ?>" class="btn-findout"><?php print $button_cta_title ?></a>
                    <?php endif; ?>
                  <?php endif; ?>
              </div>
              <?php
            }
            ?>
        </div>
        <!-- .text-center -->
    </div>
    <!-- .push-block -->
    <?php if ($title_suffix): ?>
  </div>
<?php endif; ?>





