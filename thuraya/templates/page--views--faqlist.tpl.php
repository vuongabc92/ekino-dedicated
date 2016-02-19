<?php
/**
 * Regions:
 * - $page['header']: Items for the header region.
 * - $page['navigation']: Items for the navigation region, below the main menu (if any).
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['footer']: Items for the footer region.
 * - $page['bottom']: Items to appear at the bottom of the page below the footer.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see zen_preprocess_page()
 * @see template_process()
 */
global $base_url;
drupal_add_js($base_url.'/'.path_to_theme() . '/js/faq.js');
?>
<div class="ui-page">
  <!--  Header Section -->
 <?php  print $mod_header;?>
 <!--  /Header Section -->
  <!--  Content Section -->
  <div class="ui-content">
  <div>
  <div class="ui-page-content">
   <div class="main-container">
	<!--  Product Listing -->
	<div class="solutions-details">
		<div class="breadcrumbs">
			<?php $breadcrumb=str_replace('href="//"','href="/"',$breadcrumb); ?>
			<?php print $breadcrumb; ?>
		</div>
		<div class="faq">
			<?php print render($title_suffix); ?>
			<?php print $messages; ?>
			<?php print render($tabs); ?>
			<?php print render($page['help']); ?>
			<?php if ($action_links): ?>
			<ul class="action-links"><?php print render($action_links); ?></ul>
			<?php endif; ?>
			<?php print render($page['content']); ?>                
        </div>
	</div>
   </div>
    <!-- /Solutions -->
    </div>
	</div>
  </div>
  <!--  /Content Section -->
  <!-- Footer -->
  <?php  print $mod_footer;?>
<!-- /Footer -->
</div>
