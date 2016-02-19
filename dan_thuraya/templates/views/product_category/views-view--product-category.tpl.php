<?php
/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */
global $base_url;
$term_taxonomy = taxonomy_term_load($view->args[0]);
$node_term_products = $term_taxonomy->field_node_term_products['und'];

$template_m2m = $term_taxonomy->field_select_template['und'][0]['value'];

$nodes = get_node_by_type('module_segment_slider');
$node = array_shift($nodes);

//foreach ($nodes as $node) {
//  $auto_play = $node->field_slider_auto_play['und'][0]['value'];
//  $segment_sliders = field_collection_item_load_multiple($node->field_segment_slider_collection[LANGUAGE_NONE]);
//}

$node_segment_blogs = get_node_by_type('module_segment_blog');
$node_segments = get_node_by_type('segment');
?>

<?php if ($template_m2m == 1): ?> 

  <?php
  // render block segment-slider
  print render(node_view($node, $view_mode = 'teaser', $langcode = NULL));
  ?>

  <section data-vertical-middle="true" data-get-height=".description-block-1 .container .desc" data-set-padding=".container .desc" class="description-block description-block-1 editor-1 bg-light-gray">    
    <div class="container">
      <div class="wrap">
        <div class="inner">
          <div class="desc text-dark-gray-1">
            <p>
              <?php
              $descriptions = variable_get('thu_m2m_description');
              print $descriptions['value'];
              ?>
            </p>
          </div>
        </div>
      </div>
  </section>

  <section data-src="<?php print variable_get('thu_m2m_remote_link'); ?>" class="block video-block m2m-video" data-video-embed="true">
    <figure class="bg-gray-5"></figure>
    <h2 class="title-4 text-white text-center">
      <a class="text-gray-1" href="#"><?php print variable_get('thu_m2m_remote_access_description'); ?><span class="wi-icon wi-icon-play-1"></span></a>
    </h2>
  </section>

  <section data-vertical-middle="true" data-get-height=".list-started-block .row" data-set-padding=".row" data-click-add-attr data-target="a" class="block-7 list-started-block">
    <div class="wrap">
      <div class="content">
        <div class="row">
          <?php foreach ($node_segment_blogs as $node_segment_blog): ?>
            <div class="col-sm-6 col-md-4 custom-padding">
              <a class="item item-2" href="<?php print url(drupal_get_path_alias('node/' . $node_segment_blog->nid)); ?>">
                <figure class="bg-image">
                  <img alt="<?php print $node_segment_blog->field_background_segment_blog['und'][0]['filename']; ?>" src="<?php print image_style_url('431x320', $node_segment_blog->field_background_segment_blog['und'][0]['uri']); ?>">
                </figure>
                <div class="inner">
                  <figure class="round-image">
                    <img alt="<?php print $node_segment_blog->field_icon_segment_blog['und'][0]['filename']; ?>" src="<?php print image_style_url('82x82', $node_segment_blog->field_icon_segment_blog['und'][0]['uri']); ?>">
                  </figure>
                  <div class="information-block">
                    <p class="desc text-white"><?php print $node_segment_blog->field_description_segment['und'][0]['value']; ?></p>
                    <span class="link-1"><?php print t('Know more'); ?><i class="wi-icon wi-icon-arrow"></i></span>
                  </div>
                </div>
              </a>
              <div class="bg-hover"></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <section class="block-6 works-block bg-light-gray">
    <div class="wrap">
      <div class="content">
        <h2 class="title-4 text-center"><?php print t('How it works'); ?></h2>
        <div class="container">
          <?php if (!empty($term_taxonomy->field_image_how_it_work['und'][0]['uri'])): ?>
            <figure class="main-img"><img src="<?php print file_create_url($term_taxonomy->field_image_how_it_work['und'][0]['uri']); ?>" alt="<?php print $term_taxonomy->field_image_how_it_work['und'][0]['filename']; ?>"/>
            </figure>
          <?php endif; ?>
          <div class="video-block hidden">
            <figure class="bg-gray-5"></figure>
            <h2 class="title-4 text-white text-center">
              <a href="#" class="text-gray-1">
                <?php print t('Video'); ?>
                <span class="wi-icon wi-icon-play-1"></span>
              </a>
            </h2>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section data-vertical-middle="true" data-get-height=".started-block .container" data-set-padding=".container" data-set-height="true" class="block-6 started-block bg-gray-3">
    <div class="container">
      <div class="wrap">
        <div class="content">
          <a href="/become-a-partner" class="title-4 text-center text-dark-gray-1"><?php print t('get started'); ?></a>
          <p class="desc text-center text-dark-gray-1"><?php print t('Let us help to make the most of your business'); ?></p>
          <div class="list-item list-item-1">
            <?php
            if (!empty($node_segments)):
              foreach ($node_segments as $node_segment):
                ?>
                <a class="item blue" title="<?php print $node_segment->title; ?>" href="<?php print url($node_segment->field_link_segment['und'][0]['url']); ?>">
                  <figure>
                    <img src="<?php print image_style_url('82x82', $node_segment->field_icon_segment_for_get_start['und'][0]['uri']); ?>" alt="<?php print $node_segment->title; ?>" class="img-current"/>
                    <img src="<?php print image_style_url('82x82', $node_segment->field_icon_segment_hover_get_sta['und'][0]['uri']); ?>" alt="<?php $node_segment->title; ?>" class="img-hover"/>
                  </figure>        
                  <span class="text-2"><?php print $node_segment->title; ?></span>
                </a>
                <?php
              endforeach;
            endif;
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="block-6 breadcrumb-block hidden-lg">
    <div class="container">
      <ol class="breadcrumb">        
        <li><a href="<?php print url($base_url); ?>"><?php print t('Home'); ?></a>
        </li>
        <li><a href="/products-list"><?php print t('Products'); ?></a>
        </li>
        <li class="active"><span><?php print $term_taxonomy->name; ?></span></li>
      </ol>
    </div>
  </section>

  <?php
  // render theme store location m2m
  print theme('thu_store_location_m2m');
  ?>

<?php endif; ?>

<?php if ($template_m2m != 1): ?>
  <?php if (!empty($node_term_products)) : ?>
    <section class="block-4 carousel category-banner-block active" data-vertical-middle="true">
      <div data-autoplay="true" data-slider data-type="custom" class="slider">
        <?php
        foreach ($node_term_products as $node_term_product):
          $data_products = node_load($node_term_product['nid']);
          ?>
          <div data-bg-color="#958CCF" class="slide bg-purple">
            <div class="container">
              <div class="block-3">
                <div class="inner">
                  <h2 class="title-1 text-white"><?php print $data_products->title; ?></h2>
                  <p class="desc text-white"><?php print $data_products->field_short_description['und'][0]['value']; ?></p>
                  <ul class="list-inline">
                    <?php
                    $sectors_id = $data_products->field_associated_solutions['und'];
                    foreach ($sectors_id as $sector_id):
                      $sectors = node_load($sector_id['nid']);
                      if ($sectors->type == 'sector'):
                        ?>
                        <li>
                          <figure><img src="<?php print image_style_url('37x36', $sectors->field_icon_sector_for_product[LANGUAGE_NONE][0]['uri']); ?>" alt="<?php print $sectors->field_icon_sector_for_product['und'][0]['filename']; ?>"/>
                          </figure>
                        </li>
                        <?php
                      endif;
                    endforeach;
                    ?>
                  </ul><a href="#" class="link-1"><?php print t('Add to basket'); ?><span class="wi-icon wi-icon-arrow"></span></a>
                </div>
                <figure class="image"><a href="<?php print url(drupal_get_path_alias('node/' . $data_products->nid)); ?>"><img src="<?php print file_create_url($data_products->field_product_image['und'][0]['uri']); ?>" alt="<?php print $data_products->title; ?>"/></a></figure>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>

  <section class="block-6 list-item result-block last">
    <div class="container">
      <div class="title-7">
        <figure><img class="img-responsive" alt="" src="<?php print image_style_url('33x32', $term_taxonomy->field_icons['und'][0]['uri']); ?>">
        </figure><span class="header-title"><?php print $term_taxonomy->name; ?></span>
      </div>

      <?php print render($title_prefix); ?>
      <?php if ($title): ?>
        <?php print $title; ?>
      <?php endif; ?>
      <?php print render($title_suffix); ?>

      <?php if ($exposed): ?>
        <div class="view-filters">
          <?php print $exposed; ?>
        </div>
      <?php endif; ?>

      <?php if ($attachment_before): ?>
        <div class="attachment attachment-before">
          <?php print $attachment_before; ?>
        </div>
      <?php endif; ?>

      <?php if ($rows): ?>
        <?php print $rows; ?>

      <?php elseif ($empty): ?>
        <div class="view-empty">
          <?php print $empty; ?>
        </div>
      <?php endif; ?>

      <?php if ($pager): ?>
        <?php print $pager; ?>
      <?php endif; ?>

      <?php if ($attachment_after): ?>
        <div class="attachment attachment-after">
          <?php print $attachment_after; ?>
        </div>
      <?php endif; ?>

      <?php if ($more): ?>
        <?php print $more; ?>
      <?php endif; ?>

      <?php if ($footer): ?>
        <div class="view-footer">
          <?php print $footer; ?>
        </div>
      <?php endif; ?>

      <?php if ($feed_icon): ?>
        <div class="feed-icon">
          <?php print $feed_icon; ?>
          <div>
          <?php endif; ?>
        </div>
        </section><?php /* class view */ ?>

        <section data-vertical-middle="true" data-get-height=".banner-1 .container" data-set-padding=".content" class="banner-1">
          <figure class="adapt-image">
            <img alt="<?php print $term_taxonomy->field_category_banner_bottom['und'][0]['filename']; ?>" src="<?php print file_create_url($term_taxonomy->field_category_banner_bottom['und'][0]['uri']); ?>">
          </figure>
          <div class="content">
            <div class="container">
              <div class="wrap">
                <div class="inner">
                  <div class="desc">
                    <div class="text-center">
                      <img src="<?php print file_create_url($term_taxonomy->field_icon_category_bottom['und'][0]['uri']); ?>" alt="<?php print $term_taxonomy->field_icon_category_bottom['und'][0]['filename']; ?>"/>                  
                      <div class="text text-white">
                        <p>
                          <?php print $term_taxonomy->field_description_category_botto['und'][0]['value']; ?>            
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </section>

        <section class="block-6 breadcrumb-block">
          <div class="container">
            <ol class="breadcrumb">
              <li><a href="<?php print $base_url; ?>"><?php print t('Home'); ?></a>
              </li>
              <li><a href="/products-list"><?php print t('products'); ?></a>
              </li>
              <li class="active"><span><?php print $term_taxonomy->name; ?></span></li>
            </ol>
          </div>
        </section>

        <?php print theme('thu_store_location'); ?>
      <?php endif; ?>

