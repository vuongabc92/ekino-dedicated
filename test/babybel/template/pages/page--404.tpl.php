<?php
global $language, $base_url;

$current_lang = $language->language;
$image_path = baybel_get_path('images');
?>
<style>
    .contextual-links-region:hover a.contextual-links-trigger {
        display: block;
    }
</style>
<?php print theme('babybel_cookie_banner'); ?>
<div class="app app-agegate">
  <div class="page-not-found background-layer text-center">
    <div class="logo-agegate text-center">
      <img src="<?php print $logo; ?>" alt="Babybel logo" class="picto">
    </div>
    <?php print babybel_contextual_render('banner_404'); ?>
    <!-- .banner -->
    <div class="container">
      <div class="content">
        <?php print babybel_contextual_render('content_404'); ?>
        <?php
          $lang = $GLOBALS['language']->provider;
          $language_selection_page_url = variable_get('language_selection_page_path', 'language_selection');
          if ($lang != 'locale-url') {
            echo '<ul class="list-menu"><li><a href="' . $base_url . '/' . $language_selection_page_url . '">Choose your country</a></li></ul>';
          } else {
            print babybel_contextual_render('main_menu_footer', array('class' => 'list-menu'));
          }
        ?>
      </div>
      <!-- .content -->
    </div>
    <!-- .container-->
  </div>
  <!-- .page-not-found -->
</div>
<!-- .app-agegate -->

<footer role="contentinfo">

</footer>
