<?php
/**
 * @file
 * page.tpl.php.
 * Default theme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/garland.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 * - $page['topbar']
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
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
          <a class="logo" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home">
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