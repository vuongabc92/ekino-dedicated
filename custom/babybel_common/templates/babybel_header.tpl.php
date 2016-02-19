<?php
global $language;
global $base_url;

$path = baybel_get_path('images');
$main_menu = babybel_common_get_main_menu('head', 'main-menu');
?>
<div class="container"><a href="javascript:;" title="Menu mobile" class="btn-menu"><span class="icon icon-burger"></span></a>
    <div class="wrap-logo">
        <a href="<?php print url('/'); ?>" title="<?php print t('Babybel'); ?>" class="logo">
            <img src="<?php print theme_get_setting('logo'); ?>" alt="<?php print t('Babybel'); ?>">
        </a>
    </div>
    <a href="javascript:;" title="<?php print t('Close'); ?>" class="btn-close nav-close"><span class="icon icon-close"></span></a>
    <div data-navigation data-mobile-nav class="navigation">
        <nav class="menu-bar">
            <ul>
                <?php print babybel_contextual_render('main_menu_header'); ?>
            </ul>
        </nav>
        <div class="list-social">
            <?php print babybel_contextual_render('social_network_icons'); ?>

            <?php
            $languages = language_list();
            // get country code from prefix with structure XX-YY; XX->language code, YY->country code.
            $cur_country = substr($language->prefix, -2);
            // get language title.
            $languaga_title = variable_get('babybel_variable_language_title_' . $language->language . '', 'Language');
            if (is_array($languages) && count($languages)) :
              foreach ($languages as $key => $value) :
                // find another language for current country.
                if (($cur_country == substr($key, -2)) && ($language->prefix != $value->prefix)) :
                  $current_path = current_path();
                  $lang_path = "";
                  $str_url = explode('/', $current_path);
                  if ($str_url[0] == "node") {
                    $current_path = translation_path_get_translations($current_path)[$value->language];
                  }
                  if ($current_path) {
                    $lang_path = drupal_get_path_alias($current_path, $value->language);
                  }
                  print '<div class="wrap-content">'
                      . '<h2 class="label-language visible-xs visible-sm">' . $languaga_title . '</h2>'
                      . '<ul class="switch-language">'
                      . '<li>'
                      . '<a href="' . $base_url . '/' . $value->prefix . '/' . $lang_path . '" title="' . $value->native . '" class="title-language">'
                      . substr($value->prefix, 0, 2)
                      . '</a>'
                      . '</li>'
                      . '</ul>'
                      . '</div>';
                endif;
              endforeach;
            endif;
            ?>
        </div>
        <!--        <div class="group">
                    <a href="#" title="App store" class="apps-link">
                        <img src="<?php //print $path;                   ?>/img-apple-app.png" alt="App store">
                    </a>
                    <a href="#" title="Google play" class="apps-link">
                        <img src="<?php //print $path;                   ?>/img-google-app.png" alt="Google play">
                    </a>
                </div>-->

        <div class="group">
            <?php print babybel_contextual_render('googleplay_appstore_icon'); ?>
        </div>
    </div>
    <div class="overlay-navigation"></div>
</div>
