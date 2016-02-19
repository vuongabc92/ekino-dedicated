<?php

/**
 * @file site-map.tpl.php
 *
 * Theme implementation to display the site map.
 *
 * Available variables:
 * - $message:
 * - $rss_legend:
 * - $front_page:
 * - $blogs:
 * - $books:
 * - $menus:
 * - $faq:
 * - $taxonomys:
 * - $additional:
 *
 * @see template_preprocess()
 * @see template_preprocess_site_map()
 */
 //echo "<pre>"; print_r($menus); exit;
global $base_url;
drupal_add_js($base_url.'/'.path_to_theme() . '/js/sitemap.js');
?>
<div class="sitemap">
	<h1>Sitemap</h1>
	<div class="inside-container">
		<?php print $menus; ?>
	</div>
</div>