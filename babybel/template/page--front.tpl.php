<?php
/**
 * @file Page front template.
 */
global $language, $base_url;
$current_lang = $language->language;
$image_path = baybel_get_path('images');
$fid_footer_home = babybel_variable_get('babybel_variable_homepage_background', $language->language, '');
$background_footer_home = file_load($fid_footer_home);
?>
<style>
    .contextual-links-region:hover a.contextual-links-trigger {
        display: block;
    }
</style>
<?php print theme('babybel_cookie_banner'); ?>
<?php print theme('babybel_newsletter'); ?>

<div class="app">
    <div class="inner">
        <header class="header">
            <?php print render($page['header']); ?>
        </header>
        <!--data-type="open|closed|archives"-->
        <div id="home" data-type="open">
            <?php
            // Slider Content.
            $slider = babybel_variable_get_nid_translated('babybel_variable_slider_id');
            if ($slider) {
              $node_slider = node_load($slider);
              $node_slider_status = isset($node_slider->status) ? $node_slider->status : 0;
              if ($node_slider && $node_slider_status) {
                $views_slider = node_view($node_slider, 'slider');
                print drupal_render($views_slider);
              }
            }
            ?>
            <div class="block-1">
                <?php
                $article_id = babybel_variable_get_nid_translated('babybel_variable_article_id');
                if ($article_id) {
                  $article = node_load($article_id);
                  $article_status = isset($article->status) ? $article->status : 0;
                  if ($article && $article_status) {
                    print '<div class="container">';
                    $view_article = node_view($article, 'article_homepage');
                    print drupal_render($view_article);
                    if ($article->field_video_player[LANGUAGE_NONE][0]['nid']) {
                      $video_nid = babybel_variable_get_nid_node_translated($article->field_video_player[LANGUAGE_NONE][0]['nid'], $article_id);
                      $video = node_load($video_nid);
                      //$video = node_load($article->field_video_player[LANGUAGE_NONE][0]['nid']);
                      $video_status = isset($video->status) ? $video->status : 0;
                      if ($video && $video_status) {
                        $view_video = node_view($video, 'video_player');
                        print drupal_render($view_video);
                      }
                    }
                    print '</div>';
                  }
                }
                ?>
            </div>
            <!-- Block Social feed -->
            <?php
            $display_facebook = variable_get('babybel_variable_social_display_homepage_' . $current_lang . '');
            $display_twitter = variable_get('babybel_variable_social_twitter_display_homepage_' . $current_lang . '');
            $display_instagram = variable_get('babybel_variable_social_instagram_display_homepage_' . $current_lang . '');
            if ($display_facebook || $display_twitter || $display_instagram) {
              $block_content = babybel_contextual_render('social_content_facebook_feed');
              ?><div class="block-2 facebook-post-block">
              <?php print $block_content; ?>
              </div>
              <?php
            }
            ?>
            <?php
            $products = babybel_common_get_products();
            if ($products) {
              ?>
              <div class="<?php print $display_facebook || $display_twitter || $display_instagram || strlen($block_content) > 0 ? '' : 'block-2'  ?>  product-slide <?php print (!$background_footer_home) ? 'padding-bottom-1' : ''; ?>">
                  <div class="container">
                      <?php print babybel_contextual_render('product_info_homepage'); ?>
                      <div class="slider">
                          <div data-slider data-set-arrow-height='true' data-set-arrow-top=".product-slide" data-infinite="true" data-slide=".item" data-dots="true" data-mobile-dots="true" data-item-num="3" data-test-ting="true" data-mode="carousel" data-autoplay="false" class="list-product clearfix">
                              <?php
                              $view_products = node_view_multiple($products, 'product_home', 0, $language->language);
                              print drupal_render($view_products);
                              ?>
                          </div>
                      </div>
                      <?php print babybel_contextual_render('homepage_button_product'); ?>
                  </div>
              </div>
          </div>
        <?php } ?>
        <?php if ($background_footer_home): ?>
          <div class="background-block">
              <?php
              print babybel_contextual_render('background_footer_home_page');
              ?>
          </div>
        <?php endif; ?>
        <!-- background-block -->
    </div>
</div>
<footer class="footer">
    <?php print render($page['footer']); ?>
</footer>
</div>
<script async defer src="//platform.instagram.com/en_US/embeds.js"></script>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
