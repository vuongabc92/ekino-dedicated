<?php
/**
 * @file
 * Dan Thuraya's theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template normally located in the
 * modules/system directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
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
 * - $hide_site_name: TRUE if the site name has been toggled off on the theme
 *   settings page. If hidden, the "element-invisible" class is added to make
 *   the site name visually hidden, but still accessible.
 * - $hide_site_slogan: TRUE if the site slogan has been toggled off on the
 *   theme settings page. If hidden, the "element-invisible" class is added to
 *   make the site slogan visually hidden, but still accessible.
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
 * - $page['header']: Items for the header region.
 * - $page['featured']: Items for the featured region.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['triptych_first']: Items for the first triptych.
 * - $page['triptych_middle']: Items for the middle triptych.
 * - $page['triptych_last']: Items for the last triptych.
 * - $page['footer_firstcolumn']: Items for the first footer column.
 * - $page['footer_secondcolumn']: Items for the second footer column.
 * - $page['footer_thirdcolumn']: Items for the third footer column.
 * - $page['footer_fourthcolumn']: Items for the fourth footer column.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see bartik_process_page()
 * @see html.tpl.php
 */
global $base_url;
$small_text        = isset($node->field_small_text['und'][0]['value']) ? $node->field_small_text['und'][0]['value'] : '';
$solution_cat_img  = file_create_url($node->field_category_solution_image['und'][0]['uri']);
$solution_cat_ico  = file_create_url($node->field_category_solution_icon['und'][0]['uri']);
$landing_sector_id = isset($node->field_landing_sector['und'][0]['nid']) ? $node->field_landing_sector['und'][0]['nid'] : 0;
$landing_sector    = node_load($landing_sector_id);
$sector_id         = isset($landing_sector->field_sector['und'][0]['nid']) ? $landing_sector->field_sector['und'][0]['nid'] : 0;
$related_products  = dan_thuraya_get_product_by_sector($sector_id);
$solutions_nid = array();
if(is_array($node->field_solution_list[LANGUAGE_NONE]) && count($node->field_solution_list[LANGUAGE_NONE])){
  foreach($node->field_solution_list[LANGUAGE_NONE] as $item){
    $solutions_nid[] = $item['nid'];
  }
}
$solutions = node_load_multiple($solutions_nid);
?>

<!-- Block Header -->
<section class="block-4 campaign-block sector-campaign-block sector-campaign-2 block-scroll-1">
  <div class="screen-block carousel-campaign carousel-campaign-1">
    <div class="content">
      <figure class="main-img"><img src="<?php print $solution_cat_img; ?>" alt="<?php print $node->title; ?>"/>
      </figure>
      <div class="container">
        <div class="inner">
          <div class="block-3 text-white">
            <div class="inner">
              <div class="img-group">
                <figure class="sector-img">
                  <img src="<?php print $solution_cat_ico; ?>" alt="<?php print $node->title; ?>"/>
                </figure>
              </div>
              <h2 class="text-white title-1"><?php print $node->title; ?></h2>
              <p class="desc"><?php print $small_text;?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section><!-- End Block Header -->

<!-- Block Description -->
<section data-vertical-middle="true" data-get-height=".description-block-1 .container .desc" data-set-padding=".container .desc" class="description-block description-block-1">
  <div class="container">
    <div class="wrap">
      <div class="inner">
        <div class="desc text-dark-gray-1"><?php print $node->body['und'][0]['value']; ?></div>
      </div>
    </div>
  </div>
</section><!-- End Block Description -->

<!-- Block Solutions -->
<section class="block-6 solution-block sector-solution-2 list-slider bg-light-gray">
  <div class="container">
    <div class="wrap">
      <div class="content">
        <h2 class="title-4"><?php print t('Ready to help'); ?></h2>
        <div data-slider="true" data-type="custom" data-slides-to-show="1" data-slides-to-scroll="1" class="slider solution-slide">
          <?php
            $count  = $count_last = 0;
            $paging = 4;
            foreach ($solutions as $solution) :
              $solution_img = file_create_url($solution->field_solution_image[LANGUAGE_NONE][0]['uri']);
              $count_last++;
              if ($count === 0 || $count%$paging === 0) {
                print '<div class="slide">';
              }
              ?>
                <div class="item">
                  <figure>
                    <img src="<?php print $solution_img; ?>" alt="<?php print $solution->title; ?>"/>
                  </figure>
                  <span class="text-2 text-gray-4"><?php print $solution->title; ?></span>
                </div>
              <?php
              if ($count++ % $paging === $paging - 1 || $count_last === count($solutions)) {
                print '</div>';
              }
            endforeach;
          ?>
        </div>
      </div>
    </div>
  </div>
</section><!-- End Block Solutions -->

<!-- Related Products -->
<section class="block-6 related-block sector-related list-item list-slider">
  <div class="container">
    <div class="wrap">
      <div class="content">
        <h2 class="title-4"><?php print t('Related products'); ?></h2>
        <div data-slider="true" data-type="custom" data-slides-to-show="4" data-slides-to-scroll="4" data-responsive-for="sector-related" class="slider related-slide">
          <?php
            foreach ($related_products as $product) :
              $product_img = file_create_url($product->field_product_image['und'][0]['uri']);
              $sector_ids  = $product->field_associated_solutions['und'];
              $options     = array( 'absolute' => TRUE );
              $product_url = url('node/' . $product->nid, $options);
              ?>
              <div class="item col-sm-3 col-xs-6 slide">  
                <figure class="product-image">
                  <a href="<?php print $product_url; ?>">
                    <img src="<?php print $product_img; ?>" alt="<?php print $product->title ?>"/>
                  </a>
                </figure>
                <a href="<?php print $product_url; ?>" class="text-2"><?php print $product->title ?></a>
                <ul class="list-inline">
                  <?php
                  if (!empty($sector_ids)):
                    foreach ($sector_ids as $sector_id):
                      $sector = node_load($sector_id['nid']);
                      if ($sector->type === 'sector') :
                        ?>
                        <li>
                          <figure>
                            <img src="<?php print image_style_url('23x23', $sector->field_icon_sector_for_catetory['und'][0]['uri']); ?>" alt="<?php print $sector->field_icon_sector_for_catetory['und'][0]['filename']; ?>"/>
                          </figure>
                        </li>
                        <?php
                      endif;
                    endforeach;
                  endif;
                  ?>
                </ul>
                <div class="product-button">
                  <a href="#" class="wi-icon wi-icon-basket"><?php print t('Basket'); ?></a>
                  <a href="#" class="wi-icon wi-icon-address"><?php print t('Address'); ?></a>
                </div>
              </div>
              <?php
            endforeach;
          ?>
        </div>
      </div>
    </div>
  </div>
</section><!-- End Related Products-->

<section class="block-6 breadcrumb-block">
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="<?php print $base_url; ?>"><?php print t('Home'); ?></a></li>
      <li><a href="/sectors"><?php print t('Sectors'); ?></a></li>
      <li><a href="/solutions"><?php print t('Sodlutions'); ?></a></li>
      <li class="active"><span><?php print $node->title; ?></span></li>
    </ol>
  </div>
</section>

<?php print theme('thu_store_location'); ?>