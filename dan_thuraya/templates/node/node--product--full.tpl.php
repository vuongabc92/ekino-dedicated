<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $base_url;
$path = path_to_theme();
DEFINE($f_share, 'https://www.facebook.com/sharer/sharer.php?u=');
DEFINE($linkedin_share, 'https://www.linkedin.com/shareArticle?mini=true&url=');
DEFINE($twitter_share, 'https://twitter.com/home?status=');
?>

<div data-anchor-menu class="anchor-menu hidden">
  <div class="container">
    <ul>
      <li class="to-top-menu blue-group"><span class="caret"></span><a href="javascript:;" data-block="scroll-top"><?php print t('Top'); ?></a>
      </li>
      <li><span class="caret"></span><a href="javascript:;" data-block=".feature-details-block"><?php print t('Features'); ?></a>
      </li>
      <li><span class="caret"></span><a href="javascript:;" data-block=".description-block"><?php print t('Description'); ?></a>
      </li>
      <li><span class="caret"></span><a href="javascript:;" data-block=".use-it-block"><?php print('Learn/use it'); ?></a>
      </li>
      <li><span class="caret"></span><a href="javascript:;" data-block=".video-block"><?php print('Video'); ?></a>
      </li>
      <?php
      if ($node->field_associated_solutions['und'][0]['node']->type === 'solution'):
        ?>
        <li><span class="caret"></span><a href="javascript:;" data-block=".solution-block"><?php print('Solutions'); ?></a>
        </li>
      <?php endif; ?>
      <li><span class="caret"></span><a href="javascript:;" data-block=".accessories-block"><?php print('Accessories'); ?></a>
      </li>
      <li><span class="caret"></span><a href="javascript:;" data-block=".review-block"><?php print('Review'); ?></a>
      </li>
<!--      <li><span class="caret"></span><a href="javascript:;" class="text-blue-4"><?php print('Add to basket'); ?></a>
      </li>-->
    </ul>
  </div>
</div>

<section data-fixed-block class="block-5 overview-block clearfix">
  <div class="container">
    <div class="overview-block-header">
      <h1 class="title-1 text-blue-4"><?php print $node->title; ?></h1>
      <p class="desc text-blue-4"><?php print $node->field_short_description['und'][0]['value']; ?></p>
    </div>
    <div data-slider="true" data-type="sync" data-slide-for=".carousel-overview" data-slide-nav=".list-thumbnail ul" data-fixed-img-block class="img-block list-slider">
      <div data-autoplay="false" data-speed="1000" class="slider carousel-overview">
        <?php
        $product_images = $node->field_product_image['und'];
        if (!empty($product_images)):
          foreach ($product_images as $product_image):
            ?>
            <div class="slide">
              <figure class="main-img">
                <img src="<?php print image_style_url('236x604', $product_image['uri']); ?>" alt="<?php print $product_image['filename']; ?>"/>
              </figure>
            </div>
            <?php
          endforeach;
        endif;
        ?>
      </div>
      <div class="list-thumbnail">
        <ul data-force-wait="false" data-variable-width="true" data-slides-to-show="3" class="clearfix">
          <?php
          $count = 0;
          $product_images_thums = $node->field_product_image['und'];
          for ($i = 0; $i < 3; $i++) :
            ?>
            <li class="<?php print ($count++ == 0) ? 'slick-current' : ''  ?>">
              <a href="javscript:;">
                <img src="<?php print image_style_url('63x63', $product_images_thums[$i]['uri']); ?>" alt="<?php print $product_images_thums[$i]['filename']; ?>"/></a>
            </li>
          <?php endfor; ?>
        </ul>
      </div>
    </div>

    <div class="detail-block">
      <ul class="info-list">
        <?php
        $info_products = field_collection_item_load_multiple($node->field_info_product_collection['und']);
        if (!empty($info_products)):
          foreach ($info_products as $info_product):
            ?>
            <li>
              <span class="wi-icon <?php print $info_product->field_icon_info['und'][0]['value']; ?>"></span>
              <div class="description-group">
                <span class="description"><?php print $info_product->field_title_feature_info['und'][0]['value']; ?></span>
                <span class="text-1"><?php print $info_product->field_desction_info['und'][0]['value']; ?></span>
              </div>
            </li>
            <?php
          endforeach;
        endif;
        ?>
      </ul>
      <h2 class="title-5"><?php print t('Available for the following sectors'); ?></h2>
      <ul class="list-inline clearfix">
        <?php
        $sector_ids = $node->field_associated_solutions[LANGUAGE_NONE];
        if (!empty($sector_ids)):
          foreach ($sector_ids as $sector_id):
            $sector = node_load($sector_id["nid"]);
            if ($sector->type === 'sector'):
              ?>
              <li>
                <figure>
                  <img src="<?php print file_create_url(($sector->field_icon_sector_product_detail['und'][0]['uri'])); ?>" alt="<?php print $sector->field_icon_sector_product_detail['und'][0]['filename']; ?>"/>
                </figure>
              </li>
              <?php
            endif;
          endforeach;
        endif;
        ?>
      </ul>
      <h2 class="title-5"><?php print t('Share it'); ?></h2>
      <ul class="list-inline clearfix social-list">
        <li>
          <figure>
            <a href="#" target="_blank"><img src="<?php print $base_url . '/' . $path . '/images/icon-around-black-fb.png'; ?>" alt="img-1"/></a>
          </figure>
        </li>
        <li>
          <figure>
            <a href="#" target="_blank"><img src="<?php print $base_url . '/' . $path . '/images/icon-around-black-linked-in.png'; ?>" alt="img-2"/></a>
          </figure>
        </li>
        <li>
          <figure>
            <a href="#" target="_blank"><img src="<?php print $base_url . '/' . $path . '/images/icon-around-black-twitter.png'; ?>" alt="img-3"/></a>
          </figure>
        </li>
      </ul>
      <div class="link-group">
        <!--<a href="#" class="link-1 text-blue"><?php // print t('Have it now');         ?><span class="wi-icon wi-icon-arrow-blue"></span></a>-->
        <a target="_blank" href="http://thuraya.com/where-to-buy" class="link-1 text-blue"><?php print t('Where to buy'); ?><span class="wi-icon wi-icon-arrow-blue"></span></a>
      </div>
    </div>
  </div>
</section>

<section data-end-position class="block-6 feature-details-block">
  <div class="container clearfix">
    <h2 class="title-4"><?php print t('Features details'); ?></h2>
    <div class="row">
      <div class="col-sm-6">
        <div class="accordion" data-extra-links="true">
          <?php
          $info_features = $node->field_feature_collection['und'];
          if (!empty($info_features)):
            foreach ($info_features as $info_feature):
              $info = field_collection_item_load($info_feature['value']);
              $content = $info->field_content_feature['und'][0]['value'];
              ?>
              <h3 class="title-6 accordion-header<?php (trim($content)!=='' ? print(' cursor') : print('')) ?>"><?php print $info->field_title_feature['und'][0]['value']; ?>
                <?php if(trim($content)!=='') : ?>
                <span class="accordion-icon"><?php print t('+'); ?></span>
                <?php endif; ?>
              </h3>
              <div class="accordion-content text-blue"><?php print $content; ?></div>
              <?php
            endforeach;
          endif;
          ?>
        </div>
      </div>
      <div class="product-img-block col-sm-4 col-sm-offset-1"></div>
      <div data-fixed-text-block class="wrap">
        <a href="<?php print file_create_url($node->field_compare_model['und'][0]['uri']); ?>" class="link-1 text-blue">
          <?php print t('Compare product'); ?>
          <span class="icon-moon-arrow-right2"></span>
        </a>
      </div>
    </div>
  </div>
</section>

<section class="description-block description-block-2 bg-black">
  <figure>
    <img src="<?php print file_create_url($node->field_background_desc['und'][0]['uri']); ?>" alt="<?php print $node->field_background_desc['und'][0]['filename'] ?>"/>
  </figure>
  <div class="container">
    <div class="desc text-white">
      <?php print $node->body['und'][0]['value']; ?>
    </div>
  </div>
</section>

<section name="use-it-block" class="block-6 use-it-block">
  <div data-slider="true" data-type="custom" data-autoplay="false" data-custom-dots="use-it" data-set-same-height="true" data-element-set-height=".slide" data-fade="true" data-swipe="false" data-speed="2000" class="list-slider">
    <div class="slider carousel-learn-it">
      <div class="slide">

        <div class="container">
          <div class="row main-inner">
            <div class="col-sm-6 col-xs-12 block-7 learn-block-1">
              <div class="block-3">
                <div class="inner">
                  <h2 class="title-4"><?php print t('Learn it'); ?></h2>
                  <ul class="list-4 list-download list-unstyled">
                    <?php
                    $learn_it_colls = $node->field_learn_it_collection['und'];
                    if (!empty($learn_it_colls)):
                      foreach ($learn_it_colls as $learn_it_coll):
                        $info_lear_it = field_collection_item_load($learn_it_coll['value']);
                        ?>
                        <li>
                          <a href="<?php print file_create_url($info_lear_it->field_file_download_learn_it['und'][0]['uri']); ?>">
                            <span class="text"><?php print $info_lear_it->field_title_file_learn_it['und'][0]['value']; ?></span>
                            <span class="flag">
                              <img src="<?php print file_create_url($info_lear_it->field_image_country['und'][0]['uri']); ?>" alt="<?php print $info_lear_it->field_image_country['und'][0]['filename']; ?>"/></span>
                            <span class="wi-icon wi-icon-download"></span>
                          </a>
                        </li>
                        <?php
                      endforeach;
                    endif;
                    ?>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xs-12 block-7 learn-block-2 hidden-xs">
              <div class="block-3">
                <div class="inner">
                  <div class="content">
                    <figure>
                      <img src="<?php print file_create_url($node->field_image_learn_it['und'][0]['uri']); ?>" alt="<?php print $node->field_image_learn_it['und'][0]['filename']; ?>"/>
                    </figure>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="slider carousel-use-it">
      <div class="slide">
        <div class="col-sm-6 col-xs-12 block-7 use-block-1 bg-blue-4">
          <div class="block-3">
            <div class="inner">
              <div class="wrap">
                <div class="content">
                  <div class="inner">
                    <h2 class="title-4 text-white"><?php print t('Use it'); ?></h2>
                    <ul class="list-4 list-download list-unstyled">
                      <?php
                      $info_use_its = $node->field_use_it_collection['und'];
                      if (!empty($info_use_its)):
                        foreach ($info_use_its as $info_use_it):
                          $use_it = field_collection_item_load($info_use_it['value']);
                          ?>
                          <li>
                            <a href="<?php print file_create_url($use_it->field_file_download_use_it['und'][0]['uri']); ?>">
                              <span class="text"><?php print $use_it->field_title_file_use_it['und'][0]['value'] ?></span>
                              <span class="wi-icon wi-icon-download-1"></span></a>
                          </li>
                          <?php
                        endforeach;
                      endif;
                      ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-xs-12 block-7 use-block-2 bg-blue-5">
          <div class="block-3">
            <div class="inner">
              <div class="accordion" data-extra-links="true">
                <?php
                $use_it_descriptions = $node->field_use_it_desc_collection['und'];
                if (!empty($use_it_descriptions)):
                  foreach ($use_it_descriptions as $use_it_desctiption):
                    $carousel_lear_it = field_collection_item_load($use_it_desctiption['value']);
                    ?>
                    <h3 class="title-6 accordion-header"><?php print $carousel_lear_it->field_title_use_it['und'][0]['value']; ?>
                      <span class="accordion-icon"><?php print t('+'); ?></span>
                    </h3>
                    <div class="accordion-content">
                      <?php print $carousel_lear_it->field_description_use_it['und'][0]['value']; ?>
                    </div>
                    <?php
                  endforeach;
                endif;
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section data-video-embed="true" class="block video-block">
  <figure>
    <a href="<?php print $node->field_youtube_video_url['und'][0]['value']; ?>">
      <img src="<?php print file_create_url($node->field_image_for_youtube['und'][0]['uri']); ?>" alt="<?php print $node->field_image_youtube['und'][0]['filename']; ?>"/>
    </a>
  </figure>
  <h2 class="title-4 text-white">
    <a class="link-3" href="<?php print $node->field_youtube_video_url['und'][0]['value']; ?>"><?php print t('Watch the video'); ?><span class="wi-icon wi-icon-play"></span></a>
  </h2>
</section>

<?php
//if ($node->field_associated_solutions['und'][1]['node']->type === 'solution'):
?>
<section class="list-slider">
  <div class="block-6 solution-block">
    <div class="container">
      <h2 class="title-4"><?php print t('Solutions'); ?></h2>
      <div data-slider="true" data-type="custom" data-slides-to-show="4" data-slides-to-scroll="4" data-responsive-for="solution" class="slider solution-slide">
        <?php
        $sector_ids = $node->field_associated_solutions[LANGUAGE_NONE];
        if (!empty($sector_ids)):
          foreach ($sector_ids as $sector_id):
            $sector = node_load($sector_id["nid"]);
            if ($sector->type === 'solution'):
              ?>
              <div class="slide item">
                <figure><img src="<?php print image_style_url('223x120', $sector->field_solution_image['und'][0]['uri']); ?>" alt="<?php print $sector->field_solution_image['und'][0]['filename']; ?>"/>
                </figure><span class="text-2 text-gray-4"><?php print $sector->title; ?></span>
              </div>
              <?php
            endif;
          endforeach;
        endif;
        ?>
      </div>
    </div>
  </div>
</section>
<?php // endif; ?>

<section class="accessories-block bg-gray-2">
  <div class="container">
    <h2 class="title-4"><?php print t('Accessories'); ?></h2>
    <?php
    $accessories = $node->field_accessories_collection['und'];
    if (!empty($accessories)):
      foreach ($accessories as $accessory):
        $info_accessory = field_collection_item_load($accessory['value']);
        ?>
        <div class="item item-1">
          <figure><img src="<?php print file_create_url($info_accessory->field_icon_accessories['und'][0]['uri']); ?>" alt="<?php print $info_accessory->field_icon_accessories['und'][0]['filename']; ?>"/>
          </figure>
          <h3 class="title-5"><?php print $info_accessory->field_title_accessories['und'][0]['value']; ?></h3>
          <p class="desc"><?php print $info_accessory->field_description_accessories['und'][0]['value']; ?></p>
        </div>
        <?php
      endforeach;
    endif;
    ?>
  </div>
</section>

<section class="block-6 related-block list-item list-slider">
  <div class="container">
    <h2 class="title-4"><?php print t('Related products'); ?></h2>
    <div data-slider="true" data-type="custom" data-slides-to-show="4" data-slides-to-scroll="4" data-responsive-for="related" class="slider related-slide">
      <?php
      $product_references = get_product_related_type_list($node->field_product_type[LANGUAGE_NONE][0]['tid'], $node->nid);
      if (!empty($product_references)):
        foreach ($product_references as $product_reference):
          $info_product_reference = node_load($product_reference->entity_id);
          $image = field_get_items('node', $info_product_reference, 'field_product_image');
          $sector_ids = $info_product_reference->field_associated_solutions[LANGUAGE_NONE];
          ?>
          <div class="item col-sm-3 col-xs-6 slide">
            <figure class="product-image">
              <a href="<?php print drupal_get_path_alias($info_product_reference->nid); ?>">
                <img src="<?php
                if (!empty($image)) {
                  print image_style_url('220x243', $image[0]['uri']);
                }
                ?>" alt="<?php print $image[0]['filename']; ?>"/>
              </a>
            </figure>
            <a href="<?php print drupal_get_path_alias($info_product_reference->nid); ?>" class="text-2"><?php print $info_product_reference->title; ?></a>
            <ul class="list-inline">
              <?php
              if (!empty($sector_ids)):
                foreach ($sector_ids as $sector_id):
                  $sector = node_load($sector_id["nid"]);
                  if ($sector->type === 'sector'):
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
            <div class="product-button"><a href="#" class="wi-icon wi-icon-basket hidden"><?php print t('Basket'); ?></a><a href="#" class="wi-icon wi-icon-address"><?php print t('Address'); ?></a>
            </div>
          </div>
          <?php
        endforeach;
      endif;
      ?>
    </div>
  </div>
</section>
<section class="review-block bg-blue-4">
  <div class="container">
    <div class="wrap">
      <div class="content">
        <h2 class="title-4 text-white"><?php print t('Reviews'); ?></h2>
        <div class="desc text-white">
          <?php
          $reviews = $node->field_reviews['und'];
          if (!empty($reviews)):
            foreach ($reviews as $review):
              $info_review = field_collection_item_load($review['value']);
              ?>
              <div class="review-item">
                <p><?php print $info_review->field_description_reviews['und'][0]['value']; ?></p>
                <p class="author"><?php print $info_review->field_author_reviews['und'][0]['value']; ?></p>
              </div>
              <?php
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
      <li><a href="<?php print $base_url; ?>"><?php print t('Home'); ?></a>
      </li>
      <li><a href="/products-list"><?php print t('Products'); ?></a>
      </li>
      <li><a href="<?php print 'products/' . $node->field_product_type['und'][0]['tid']; ?>"><?php print $node->field_product_type['und'][0]['taxonomy_term']->name; ?></a>
      </li>
      <li class="active"><span><?php print $node->title; ?></span></li>
    </ol>
  </div>
</section>

<?php print theme('thu_store_location'); ?>

<script type="text/javascript">
  var menu_product = jQuery(".main-menu ul li > a.products");
  menu_product.addClass("active-trail active");
  menu_product.parent().addClass("active");
</script>