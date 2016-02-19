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
?>
<section class="block-4 campaign-block local-block">
  <div class="content">
    <figure><img alt="<?php print $node->field_segment_banner['und'][0]['filename']; ?>" src="<?php print file_create_url($node->field_segment_banner['und'][0]['uri']); ?>"></figure>
    <div class="container">
      <div class="inner">
        <div class="block-3">
          <h2 class="title-1" style="color: <?php print $node->field_color_for_introduction['und'][0]['rgb']; ?>">
            <?php print $node->field_segment_title['und'][0]['value']; ?>
          </h2>
        </div>
      </div>
    </div>
    </figure>
  </div>
</section>

<section class="block-6 feature-details-block feature-details-block-1 active" style="min-height: 251px;">
  <div class="container clearfix">
    <h2 class="title-4"><?php print t('Benefits & Applications'); ?></h2>
    <div data-extra-links="true" class="accordion">
      <?php
      $segment_features = field_collection_item_load_multiple($node->field_segment_feauture_collectio[LANGUAGE_NONE]);
      if (!empty($segment_features)):
        foreach ($segment_features as $segment_feature):
          $segment_feature_content = $segment_feature->field_content_feature['und'][0]['value'];
          ?>
          <h3 class="title-6 accordion-header<?php (trim($segment_feature_content)!=='' ? print(' cursor') : print('')) ?>"><?php print $segment_feature->field_title_feature['und'][0]['value']; ?>
            <?php if(trim($segment_feature_content)!=='') : ?>
            <span class="accordion-icon">+</span>
            <?php endif; ?>
          </h3>
          <div class="accordion-content text-blue"><?php print $segment_feature_content; ?></div>          
          <?php
        endforeach;
      endif;
      ?>
    </div>
  </div>
</section>

<section data-vertical-middle="true" data-get-height=".banner-1.banner-2 .container" data-set-padding=".content" class="banner-1 banner-2">
  <figure class="adapt-image">
    <img alt="<?php print $node->field_background_segment_blog['und'][0]['filename']; ?>" src="<?php print file_create_url($node->field_background_segment_blog['und'][0]['uri']); ?>">
  </figure>
  <div class="content">
    <div class="container">      
      <div class="wrap">

        <div class="inner">
          <figure class="main-img">
            <img src="<?php print image_style_url('80x80', $node->field_icon_segment_blog['und'][0]['uri']); ?>" alt="<?php print $node->field_icon_segment_blog['und'][0]['filename']; ?>"/>
          </figure>
          <div class="desc">
            <div class="text text-white">
              <p><?php print $node->field_description_for_segment['und'][0]['value']; ?></p>
            </div>
          </div>  
        </div>

      </div>
    </div>
  </div>
</section>

<?php if (!empty($node->field_select_upload)): ?>
  <section class="block-6 works-block bg-light-gray">
    <div class="wrap">
      <div class="content">
        <h2 class="title-4 text-center"><?php print t('How it works'); ?></h2>
        <div class="container">
          <?php if ($node->field_select_upload['und'][0]['value'] === 'image'): ?>
            <figure class="main-img">
              <img alt="<?php print $node->field_segment_how_it_work['und'][0]['filename']; ?>" src="<?php print file_create_url($node->field_segment_how_it_work['und'][0]['uri']); ?>">
            </figure>
          <?php endif; ?>

          <?php if ($node->field_select_upload['und'][0]['value'] === 'video'): ?>
            <div class="video-block">
              <figure class="bg-gray-5"></figure>
              <h2 class="title-4 text-white text-center"><a class="text-gray-1" href="<?php print file_create_url($node->field_segment_how_it_work_video['und'][0]['uri']); ?>"><?php print t('Video'); ?><span class="wi-icon wi-icon-play-1"></span></a>
              </h2>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php
if ((!empty($node->field_select_upload_product)) && ($node->field_select_upload_product['und'][0]['value'] == 'product-manual')):
  $product_manuals = field_collection_item_load_multiple($node->field_product_reference_for_segm['und']);
?>
  <section data-vertical-middle="true" class="block-4 carousel carousel-master carousel-master-1 hidden-xs active">
    <div data-slider data-type="custom" data-autoplay="true" class="slider">
      <?php
      foreach ($product_manuals as $product_manual) :
      ?>
      <div data-bg-color="#58aee0" class="slide">
        <div class="container">
          <div class="block-3">
            <div class="inner">
              <h2 class="title-1 text-white"><?php print $product_manual->field_title_for_product['und'][0]['value']; ?></h2>
              <p class="desc text-white"><?php print $product_manual->field_description_for_product['und'][0]['value']; ?></p>
              <a href="<?php print url(drupal_get_path_alias($product_manual->field_link['und'][0]['url'])); ?>" class="link-1"><?php print $product_manual->field_link['und'][0]['title']; ?><span class="wi-icon wi-icon-arrow"></span></a>
            </div>
            <figure>
              <a href="<?php print url(drupal_get_path_alias($product_manual->field_link['und'][0]['url'])); ?>">
                <img src="<?php print file_create_url($product_manual->field_image_for_product['und'][0]['uri']); ?>" alt="<?php print $product_manual->field_image_for_product['und'][0]['filename']; ?>"/>
              </a>
            </figure>
          </div>
        </div>
      </div>
      <?php
      endforeach;
      ?>
    </div>
  </section>
<?php
endif;
?>

<?php
if ((!empty($node->field_product_m2m_preference)) && ($node->field_select_upload_product['und'][0]['value'] == 'product-reference')):
  $product_m2ms = $node->field_product_m2m_preference['und'];
?>
  <section data-vertical-middle="true" class="block-4 carousel carousel-master carousel-master-1 hidden-xs active">
      <div data-slider data-type="custom" data-autoplay="true" class="slider">
      <?php
      foreach ($product_m2ms as $product_m2m):
      ?>      
        <div data-bg-color="#58aee0" class="slide">
          <div class="container">
            <div class="block-3">
              <div class="inner">
                <h2 class="title-1 text-white"><?php print $product_m2m['node']->title; ?></h2>
                <p class="desc text-white"><?php print $product_m2m['node']->field_short_description['und'][0]['value']; ?></p>
                <a href="<?php print url(drupal_get_path_alias('node/' . $product_m2m['node']->nid)); ?>" class="link-1"><?php print t('Know more'); ?><span class="wi-icon wi-icon-arrow"></span></a>
              </div>
              <figure>
                <a href="<?php print url(drupal_get_path_alias('node/' . $product_m2m['node']->nid)); ?>">
                  <img src="<?php print file_create_url($product_m2m['node']->field_product_image['und'][0]['uri']); ?>" alt="<?php print $product_m2m['node']->field_product_image['und'][0]['filename']; ?>"/>
                </a>
              </figure>
            </div>
          </div>
        </div>
        <?php
        endforeach;
        ?>
      </div>
    </section>
<?php 
endif;
?>

<?php
$node_segments = get_node_by_type('segment');
?>
<section data-vertical-middle="true" data-get-height=".started-block-1 .container" data-set-padding=".container" class="block-6 started-block started-block-1 bg-gray-3">
  <div class="container">
    <div class="wrap">
      <div class="content">
        <a href="/become-a-partner" class="desc text-dark-gray-1"><?php print t('Become a Thuraya M2M Partner'); ?></a>
        <div class="list-item list-item-1">
          <?php
          if (!empty($node_segments)):
            foreach ($node_segments as $node_segment):
              if ($node_segment->title != $node->title):
                $segment_title = $node_segment->title;
                $segment_title = eregi_replace('<strong>', '', $segment_title);
                $segment_title = eregi_replace('</strong>', '', $segment_title);
                ?>
                <a href="<?php print url($node_segment->field_link_segment['und'][0]['url']); ?>" title="<?php print $segment_title; ?>" class="item blue">
                  <figure>
                    <img src="<?php print image_style_url('82x82', $node_segment->field_icon_segment_for_get_start['und'][0]['uri']); ?>" alt="<?php print $node_segment->title; ?>" class="img-current"/>
                    <img src="<?php print image_style_url('82x82', $node_segment->field_icon_segment_hover_get_sta['und'][0]['uri']); ?>" alt="<?php $node_segment->title; ?>" class="img-hover"/>
                  </figure>
                  <span class="text-2"><?php print $node_segment->title; ?></span>
                </a>
                <?php
              endif;
            endforeach;
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="block-6 breadcrumb-block">
  <div class="container">
    <ol class="breadcrumb">      
      <li><a href="<?php print url($base_url); ?>"><?php print t('Home'); ?></a>
      </li>
      <li><a href="/products-list"><?php print t('Products'); ?></a>
      </li>
      <li class="active"><span><?php print $node->title; ?></span>
      </li>
    </ol>
  </div>
</section>

<?php
//render theme store location m2m
print theme('thu_store_location_m2m');
?>
