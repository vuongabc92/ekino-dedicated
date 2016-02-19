<?php

/**
 * @file html.tpl.php.
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE tag.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 */
global $base_path;
?>
<?php print $doctype; ?>
<!--[if IE 9 ]>
<html lang="<?php print $language->prefix; ?>"
      dir="<?php print $language->dir; ?>" <?php print $rdf->version . $rdf->namespaces; ?> class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="<?php print $language->prefix; ?>"
      dir="<?php print $language->dir; ?>" <?php print $rdf->version . $rdf->namespaces; ?>>
<!--<![endif]-->
<head<?php print $rdf->profile; ?>>
  <title><?php print $head_title; ?></title>
  <?php print $head; ?>
  <?php //print render($page['content']['metatags']); ?>
  <?php print $styles; ?>
  <?php
  if (!empty($html5shim)):
    print $html5shim;
  endif; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<style>
    .contextual-links-region:hover a.contextual-links-trigger {
        display: block;
    }
</style>
</head>
<body class="<?php print $classes; ?>" <?php print $attributes; ?>>
<div class="overlay"></div>
<?php print $page_top; ?>
<?php print $page; ?>
<?php print $page_bottom; ?>

<?php print $scripts; ?>

<?php global $language; ?>

<?php
$active_trail = menu_get_active_trail();
$ga_pageview_title_array = array();
foreach ($active_trail as $item) {
  if ($item['href'] != '<front>') {
    $ga_pageview_title_array[] = $item['title'];
  }
}
$ga_pageview_title = implode(' > ', $ga_pageview_title_array);
?>

<!-- Google Analytics User Opt-out-->
<script>
var gaProperties = ['UA-20824513-1','UA-53820128-1','UA-53820128-14','UA-62714801-12','UA-62714801-51'];

// Disable tracking if the opt-out cookie exists.

gaProperties.forEach(function(gaProperty) {
  var disableStr = 'ga-disable-' + gaProperty;
  if (document.cookie.indexOf(disableStr + '=true') > -1) {
    window[disableStr] = true;
  }
});

</script>
<!-- End Google Analytics User Opt-out-->

<!-- Google Analytics -->
<!--<script>
  (function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function () {
      (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date();
    a = s.createElement(o),
      m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
  })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

  ga('create', 'UA-20824513-1', 'auto');
  ga('send', 'pageview', {
    'page': '<?php //printf('%s/%s', $language->prefix, drupal_get_path_alias(current_path())); ?>',
    'title': '<?php //print $ga_pageview_title; ?>'
  });

  setTimeout("ga('send','event','NoBounce','Over 30 seconds',{'nonInteraction': 1})", 30000);
</script>-->
<!-- End Google Analytics -->

<!-- Tag Manager -->
<!--<noscript>
  <iframe src='//dmp.pernod-ricard.com/JScript/iframe.php?container=TEROCwEHTEhdUEZQ' height='0' width='0' style='display:none;visibility:hidden'></iframe>
</noscript>-->
<!--<script>(function(d, s,id)
  { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = '//dmp.pernod-ricard.com/JScript/pernod-ricard-api.js?container=TEROCwEHTEhdUEZQ'; fjs.parentNode.insertBefore(js, fjs.nextSibling); }
  (document, 'script','pdrd_'+new Date().getTime()));</script>-->
<!-- End Tag Manager -->
</body>
</html>
