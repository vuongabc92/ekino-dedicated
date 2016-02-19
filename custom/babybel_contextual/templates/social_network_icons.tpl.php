<?php
global $language, $base_url;
$path = baybel_get_path('images');

$twitter_url = $element['#content']['twitter_url'];
$twitter_title = $element['#content']['twitter_title'];
$facebook_url = $element['#content']['facebook_url'];
$facebook_title = $element['#content']['facebook_title'];
$youtube_url = $element['#content']['youtube_url'];
$youtube_title = $element['#content']['youtube_title'];
$instagram_url = $element['#content']['instagram_url'];
$instagram_title = $element['#content']['instagram_title'];
?>
<div class="wrap-content">
    <ul class="social-item">
        <?php if ($title_suffix): ?>
          <div class="<?php print $classes; ?>">
              <?php print render($title_suffix); ?>
            <?php endif; ?>
            <li>
                <a href="#" title="<?php print t('Newsletter'); ?>" class="icon-social icon-mail" data-popin>
                    <?php print t('Newsletter'); ?>
                </a>
            </li>
            <?php if (!empty($twitter_url)) { ?>
              <li>
                  <a target="_blank" href="<?php print $twitter_url; ?>" title="<?php print $twitter_title; ?>" class="icon-social icon-twitter">
                      <?php print $twitter_title; ?>
                  </a>
              </li>
            <?php } ?>

            <?php if (!empty($facebook_url)) { ?>
              <li>
                  <a target="_blank" href="<?php print $facebook_url; ?>" title="<?php print $facebook_title; ?>" class="icon-social icon-facebook">
                      <?php print $facebook_title; ?>
                  </a>
              </li>
            <?php } ?>

            <?php if (!empty($youtube_url)) { ?>
              <li>
                  <a target="_blank" href="<?php print $youtube_url; ?>" title="<?php print $youtube_title; ?>" class="icon-social icon-youtube">
                      <?php print $youtube_title; ?>
                  </a>
              </li>
            <?php } ?>
            <?php if (!empty($instagram_url)) : ?>
              <li>
                  <a target="_blank" href="<?php print $instagram_url; ?>" title="<?php print $instagram_title; ?>" class="icon-social icon-instagram">
                      <?php print $instagram_title; ?>
                  </a>
              </li>
            <?php endif; ?>

            <?php if ($title_suffix): ?>
          </div>
        <?php endif; ?>
    </ul>
</div>
