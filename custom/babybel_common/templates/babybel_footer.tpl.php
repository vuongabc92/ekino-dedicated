<?php
global $language;
$lang_code = $language->language;

$app_logo = babybel_common_check_file('img-apple-app.png', 'en');
$google_logo = babybel_common_check_file('img-google-app.png', 'en');

$path = baybel_get_path('images');

$main_menu = babybel_common_get_main_menu('footer', 'main-menu');
$footer_menu = babybel_common_get_main_menu('footer', 'menu-footer-menu');
?>
<div class="container">
    <div class="row">
        <div class="col-sm-8 hidden-xs">
          <?php
            if ($main_menu) {
              print babybel_contextual_render('main_menu_footer', array('class' => 'menu-footer'));
            }
          ?>
        </div>
        <div class="col-sm-4 list-social">
            <?php print babybel_contextual_render('social_network_icons'); ?>
        </div>
    </div>
    <div class="copyright">
        <div class="row">
            <div class="col-sm-8">
                <?php
                print babybel_contextual_render('menu_footer');
                ?>
                <p class="copyright-text">&copy; <?php print t('Babybel 2015') ?><span class="hidden-xs">. <?php print t('All Rights Reserved') ?></span></p>
            </div>
            <div class="col-sm-4 hidden-xs">
                <div class="group">
                  <?php print babybel_contextual_render('googleplay_appstore_icon'); ?>
                </div>
            </div>
        </div>
    </div>
</div>