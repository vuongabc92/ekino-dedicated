<?php
/**
 * @file
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
 * - $head_title: A modified version of the page title, for use in the TITLE
 *   tag.
 * - $head_title_array: (array) An associative array containing the string parts
 *   that were used to generate the $head_title variable, already prepared to be
 *   output as TITLE tag. The key/value pairs may contain one or more of the
 *   following, depending on conditions:
 *   - title: The title of the current page, if any.
 *   - name: The name of the site.
 *   - slogan: The slogan of the site, if any, and if there is no title.
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
 *
 * @ingroup themeable
 */
$path = path_to_theme();
Global $base_url;
$base_url;
?>
<!DOCTYPE html>
<!--[if IE 8]><html lang="en" class="no-js ie ie8"><![endif]-->
<!--[if IE 9]><html lang="en" class="no-js ie ie9"><![endif]-->
<!--[if gt IE 9]><!-->
<html xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?> class="no-js">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <?php print $head; ?>
        <title><?php if(isset($title)) print $title. ' '; print $head_title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui, user-scalable=no">
        <meta content="text/html;charset=utf-8">
        <link rel="icon" href="images/favicon.ico" type="image/x-icon" sizes="16x16">
        <!--[if lte IE 9]><link rel="stylesheet" href="css/ie.css"><![endif]-->
        <?php print $styles; ?>
        <script src="<?php print $base_url .'/'. $path; ?>/js/modernizr.js"></script>
        <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <?php print $scripts; ?>

    </head>
    <body class="<?php print $classes; ?>">
        <?php print $page_top; ?>
        <?php print $page; ?>
        <?php print $page_bottom; ?>
    </body>
</html>