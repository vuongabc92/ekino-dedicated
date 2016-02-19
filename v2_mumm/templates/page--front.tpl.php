<?php
/**
 * @file page--front.tpl.php.
 *
 */
global $language, $base_url;
$path = $base_url . '/' . path_to_theme();
?>
<!-- region popup age gate -->
<?php
if ($page['popup_ageg_ate']) :
  print render($page['popup_ageg_ate']);
endif;
?>
<!-- end -->
<div id="wrapper">
    <header class="main-header">
        <div class="grid-fluid">
            <div class="hidden-xs">
                <?php if ($logo_header_desktop): ?>
                  <a class="logo" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"
                    data-tracking data-track-action="click" data-track-category="header" data-track-label="logo" data-track-type="event">
                    <img src="<?php print file_create_url($logo_header_desktop->uri); ?>" alt="<?php print t('Mumm logo'); ?>" />
                  </a>
                <?php endif; ?>
                <?php
                if ($page['header_main_menu']) :
                  print render($page['header_main_menu']);
                endif;
                ?>
                <div class="tool-block">
                    <?php
                    if ($page['header_menu_right']):
                      print render($page['header_menu_right']);
                    endif;
                    ?>
                </div>
            </div>

            <?php if ($logo_header_mobile): ?>
              <div class="hidden-sm">
                  <a class="logo" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"
                    data-tracking data-track-action="click" data-track-category="header" data-track-label="logo" data-track-type="event">
                    <img src="<?php print file_create_url($logo_header_mobile->uri); ?>" alt="<?php print t('Mumm logo'); ?>"/>
                  </a>
                  <button type="button" name="menu-btn" id="menu-btn" title="" class="icon icon-burger" data-trigger-popup="popup-mobile"
                    data-tracking data-track-action="click" data-track-category="header" data-track-label="menu-burger" data-track-type="event">
                    <span class="line"></span>
                  </button>
              </div>
            <?php endif; ?>
            <?php
            if ($page['search']):
              print render($page['search']);
            endif;
            ?>

        </div>

    </header>
    <main>

        <?php if ($messages): ?>
          <div class="drupal-messages">
              <?php print $messages; ?>
          </div>
        <?php endif; ?>

        <?php print render($page['content_pre']); ?>

        <?php print render($page['content']); ?>

        <?php print render($page['content_post']); ?>

        <?php if ($page['sidebar_first']): ?>
          <div class="sidebar-first">
              <?php print render($page['sidebar_first']); ?>
          </div>
        <?php endif; ?>

        <?php if ($page['sidebar_second']): ?>
          <div class="sidebar-second">
              <?php print render($page['sidebar_second']); ?>
          </div>
        <?php endif; ?>

    </main>

    <footer class="main-footer">

        <!-- region footer bottom -->
        <div class="footer-bottom">
            <div class="grid-fluid">
                <div class="mention-health">
                    <div class="legal-wraper">
                      <p data-legal class="legal legal-fixed"><?php print v2_age_gate_variable_get('mention_health', $language->language); ?></p>
                    </div>
                    <?php if ($language->language == 'fr-fr') : ?>
                      <a href="http://www.consignesdetri.fr" title="www.consignesdetri.fr" class="recycling-instructions" target="_blank">
                          <span>
                              <?php print t('Our packages are subject of a set tri for more information: www.consignesdetri.fr'); ?>
                          </span>
                      </a>
                    <?php endif; ?>
                </div>
                <div class="sitemap-block">
                    <?php if ($logo_footer_desktop || $logo_footer_mobile): ?>
                      <div class="logo-footer">
                          <a class="logo hidden-xs" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"
                            data-tracking data-track-action="click" data-track-category="footer" data-track-label="logo" data-track-type="event">
                            <img src="<?php print file_create_url($logo_footer_desktop->uri); ?>" alt="<?php print t('Mumm logo'); ?>" />
                          </a>
                          <a class="logo hidden-sm visible-xs" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"
                            data-tracking data-track-action="click" data-track-category="footer" data-track-label="logo" data-track-type="event">
                            <img src="<?php print file_create_url($logo_footer_mobile->uri); ?>" alt="<?php print t('Mumm logo'); ?>" />
                          </a>

                      </div>

                    <?php endif; ?>
                    <!-- region sitemap -->
                    <?php
                    if ($page['footer_sitemap']) :
                      print render($page['footer_sitemap']);
                    endif;
                    ?>
                    <!-- end -->
                </div>
                <!-- region country -->
                <?php
                if ($page['footer_country']) :
                  print render($page['footer_country']);
                endif;
                ?>
                <!-- end -->
                <!-- region menu footer -->
                <?php
                if ($page['footer_menu']) :
                  print render($page['footer_menu']);
                endif;
                ?>
                <!-- end -->
            </div>
        </div>
    </footer>

</div>
<div class="overlay black">&nbsp;</div>
<div class="overlay white">&nbsp;</div>
<div class="overlay-agegate black">&nbsp;</div>
<div class="loading">
    <div class="inner"><img src="<?php print $path; ?>/images/loading-icon.gif" alt="<?php print t('loading'); ?>">
    </div>
</div>
<!-- region menu footer -->
<?php
if ($page['popup']) :
  print render($page['popup']);
endif;
?>
<!-- end -->