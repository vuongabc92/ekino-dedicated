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
global $language, $base_url;
$account_tagging = variable_get('config_tagging_acount');

$social_url = $base_url . '/' . $language->prefix;
$social_urls['fb'] = mumm_helpers_get_variable_localized_value(V2_BLOCKS_FACEBOOK_LINK_VAR_SLUG, V2_BLOCKS_PUSHES_VAR_DEFAULT, $language->language);
$social_urls['yt'] = mumm_helpers_get_variable_localized_value(V2_BLOCKS_YOUTUBE_LINK_VAR_SLUG, V2_BLOCKS_PUSHES_VAR_DEFAULT, $language->language);
$social_urls['tw'] = mumm_helpers_get_variable_localized_value(V2_BLOCKS_TWITTER_LINK_VAR_SLUG, V2_BLOCKS_PUSHES_VAR_DEFAULT, $language->language);
$social_urls['in'] = mumm_helpers_get_variable_localized_value(V2_BLOCKS_INSTAGRAM_LINK_VAR_SLUG, V2_BLOCKS_PUSHES_VAR_DEFAULT, $language->language);

$arg = arg();
// Add keyword to GA.
if(isset($arg[0]) && $arg[1] == 'search' && isset($_GET['keyword'])):
  $keyword_search = '?keyword=' . $_GET['keyword'];
endif;

?>
<?php
if (drupal_is_front_page()) {
  $ga_pageview_title_array[] = $ga_page_title;
} else {
  $ga_pageview_title_array = array();
  $segments = v2_segment_path($node_ga);
  if ($segments) {
    foreach ($segments as $segment) {
      $ga_pageview_title_array[] = strip_tags($segment);
    }
  }
}
$current_path = current_path();
if (isset($current_path) && $current_path == 'age-gate') {
  $ga_pageview_title_array[] = $ga_page_title;
}
$ga_pageview_title = implode(' > ', $ga_pageview_title_array);
?>

<?php print $doctype; ?>
<html lang="<?php print $language->prefix; ?>">
<head<?php print $rdf->profile; ?>>
  <title><?php print $head_title; ?></title>
  <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <![endif]-->
  <?php print $head; ?>
  <script>
    window.fbAsyncInit = function () {
      // init the FB JS SDK
      FB.init({
        appId: '<?php print variable_get('mumm_social_facebook_app_id'); ?>', // App ID from the app dashboard
        version: 'v2.4', // Check Facebook Login status
        xfbml: true  // Look for social plugins on the page
      });
    };
    (function (d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {
        return;
      }
      js = d.createElement(s);
      js.id = id;
      js.src = '//connect.facebook.net/en_US/sdk.js';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>
  <?php print $styles; ?>
  <?php
  if (!empty($html5shim)):
    print $html5shim;
  endif;
  ?>
</head>
<body class="<?php print $classes; ?>" <?php print $attributes; ?> data-track-type="event" data-track-category="age_gate-version1" data-track-action="bypass" data-track-label="" data-track-value="" data-track-non-interaction="true">
  <div class="overlay"></div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>

  <?php print $scripts; ?>

  <!-- Google Analytics User Opt-out-->
  <script>
    var gaProperties = ['UA-20824513-1', 'UA-53820128-1', 'UA-53820128-14', 'UA-62714801-12', 'UA-62714801-51'];

    // Disable tracking if the opt-out cookie exists.
    gaProperties.forEach(function (gaProperty) {
      var disableStr = 'ga-disable-' + gaProperty;
      if (document.cookie.indexOf(disableStr + '=true') > -1) {
        window[disableStr] = true;
      }
    });

    // Opt-out function
    function gaOptout() {
      gaProperties.forEach(function (gaProperty) {
        var disableStr = 'ga-disable-' + gaProperty;
        document.cookie = disableStr + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
        window[disableStr] = true;
      });
      alert('<?php echo t('Cookies have been disabled'); ?>');
    }
    // Opt-out function
    function gaOptout() {
      gaProperties.forEach(function (gaProperty) {
        var disableStr = 'ga-disable-' + gaProperty;
        document.cookie = disableStr + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
        window[disableStr] = true;
      });
      alert('<?php echo t('Cookies have been disabled'); ?>');
    }
  </script>
  <!-- End Google Analytics User Opt-out-->

  <!-- Google Analytics -->
  <script>
    // Init Google Analytics
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
    ga('create', '<?php print $account_tagging; ?>', 'auto');
    ga('send', {
      'hitType': 'pageview',
      'page': '<?php printf('%s/%s', $language->prefix, drupal_get_path_alias(current_path() . $keyword_search)); ?>',
      'title': '<?php print $ga_pageview_title; ?>'
    });
    setTimeout("ga('send','event','NoBounce','Over 30 seconds',{'nonInteraction': 1})",30000)

  </script>
  <!-- End Google Analytics -->

  <!-- Global DMP Project BlueKai Optout -->
  <script type="text/javascript">
    jQuery('.optOut').click(function (e) {
      e.preventDefault();
      ifrm = document.createElement("IFRAME");
      ifrm.setAttribute("src", "//tags.bluekai.com/set_ignore");
      ifrm.style.width = 0 + "px";
      ifrm.style.height = 0 + "px";
      document.body.appendChild(ifrm);
      alert('<?php echo t('Cookies have been disabled'); ?>');
    });
  </script>
  <!-- End Global DMP Project BlueKai Optout -->

  <!-- Specify social profiles for Google -->
  <script type="application/ld+json">
    {
    "@context" : "http://schema.org",
    "@type" : "Organization",
    "name" : "Champagne Mumm",
    "url" : "<?php print $social_url; ?>",
    "sameAs" : [
    <?php
      foreach ((array) $social_urls as $social_url) {
        if ($social_url['newsletter'])
          echo "\"" . $social_url['newsletter'] . "\",\r\n";
      }
    ?>
    ]
    }
  </script>

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
