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
      <li class="to-top-menu blue-group">
        <span class="caret"></span>
        <a href="javascript:;" data-block="scroll-top"><?php print t('Top'); ?></a>
      </li>
      <li>
        <span class="caret"></span>
        <a href="javascript:;" data-block=".feature-details-block"><?php print t('Features'); ?></a>
      </li>
      <li>
        <span class="caret"></span>
        <a href="javascript:;" data-block=".video-block"><?php print t('Video'); ?></a>
      </li>
      <?php if(!empty($node->field_reviews)): ?>
      <li>
        <span class="caret"></span>
        <a href="javascript:;" data-block=".review-block"><?php print t('Review'); ?></a>
      </li>
      <?php endif; ?>
      <!--      <li>
              <span class="caret"></span>
              <a href="javascript:;" class="text-blue-4"><?php print t('Add to basket'); ?></a>
            </li>-->
    </ul>
  </div>
</div>

<section data-fixed-block class="block-5 overview-block overview-block-1 clearfix">
  <div class="container">
    <div class="overview-block-header">
      <h1 class="title-1 text-blue-4"><?php print $node->title; ?></h1>
      <p class="desc text-blue-4"><?php print $node->field_short_description['und'][0]['value']; ?></p>
    </div>
    <div class="img-block">
      <figure class="main-img">
        <img src="<?php print image_style_url('432x256', $node->field_product_image['und'][0]['uri']); ?>" alt="<?php print $node->field_product_image['und'][0]['filename']; ?>"/>
      </figure>
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
                <span class="description"><?php print $info_product->field_title_info['und'][0]['value']; ?></span>
                <span class="text-1"><?php print $info_product->field_desction_info['und'][0]['value']; ?></span>
              </div>
            </li>
            <?php
          endforeach;
        endif;
        ?>
      </ul>
      <h2 class="title-5"><?php print t('Available for the following sectors'); ?></h2>
      <div class="list-item-1 list-inline list-item-2 clearfix">
        <?php
        $segments = $node->field_associated_solutions['und'];
        if (!empty($segments)):
          foreach ($segments as $segment):
            ?>
            <div class="item blue">
              <figure>
                <img src="<?php print image_style_url('40x40', $segment['node']->field_icon_segment_for_get_start['und'][0]['uri']); ?>" alt="<?php print $segment['node']->field_icon_segment_for_get_start['und'][0]['filename']; ?>" class="img-current"/>
              </figure>
            </div>
            <?php
          endforeach;
        endif;
        ?>
      </div>      
      <h2 class="title-5"><?php print t('Share it'); ?></h2>
      <ul class="list-inline clearfix social-list">
        <li>
          <figure><img src="<?php print $base_url . '/' . $path . '/images/icon-around-black-fb.png'; ?>" alt="img-1"/>
          </figure>
        </li>
        <li>
          <figure><img src="<?php print $base_url . '/' . $path . '/images/icon-around-black-linked-in.png'; ?>" alt="img-2"/>
          </figure>
        </li>
        <li>
          <figure><img src="<?php print $base_url . '/' . $path . '/images/icon-around-black-twitter.png'; ?>" alt="img-3"/>
          </figure>
        </li>
      </ul>
      <div class="link-group">
        <!--        <a href="#" class="link-1 text-blue">
        <?php // print t('Add to basket'); ?>
                  <span class="icon-moon-arrow-right2"></span>
                </a>-->
        <a target="_blank" href="http://thuraya.com/where-to-buy" class="link-1 text-blue">          
          <?php print t('Where to buy'); ?>
          <span class="icon-moon-arrow-right2"></span>
        </a>
      </div>
    </div>
  </div>
</section>

<section class="block-6 feature-details-block feature-details-block-2 bg-light-gray">
  <div class="container clearfix">
    <div class="row">
      <div class="col-sm-7">
        <h2 class="title-4"><?php print t('Features'); ?></h2>
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
    </div>
    <ul class="list-4 list-download col-sm-offset-8 col-md-offset-8">
      <li>
        <a href="<?php print file_create_url($node->field_compare_model['und'][0]['uri']); ?>" class="item-download text-blue" target="_blank">
          <span class="text"><?php print $node->field_compare_model_title['und'][0]['value']; ?></span>
          <span class="wi-icon wi-icon-download-2"></span>
        </a>
      </li>
    </ul>
  </div>
</section>

<!--<section data-src="<?php print $node->field_youtube_video_url['und'][0]['value']; ?>" data-video-embed="true" class="block video-block">
  <figure>
    <a href="<?php print $node->field_youtube_video_url['und'][0]['value']; ?>">
      <img src="<?php print file_create_url($node->field_image_for_youtube['und'][0]['uri']); ?>" alt="<?php print $node->field_image_youtube['und'][0]['filename']; ?>"/>
    </a>
  </figure>
  <h2 class="title-4 text-white">
    <a class="link-3" href="<?php print $node->field_youtube_video_url['und'][0]['value']; ?>"><?php print t('Watch the video'); ?><span class="wi-icon wi-icon-play"></span></a>
  </h2>
</section>-->

<?php
$data_js = '';
$youtube_collections = field_collection_item_load_multiple($node->field_youtube_collection['und']);
if (!empty($youtube_collections)) {
  foreach ($youtube_collections as $youtube_collection) {
    $data_js = $youtube_collection->field_link_video_for_youtube['und'][0]['value'];
  }
}
?>
<section <?php if ($node->field_select_upload['und'][0]['value'] == 'video') print 'data-src=' . $data_js; ?> class="block video-block video-block-1">
  <?php
  if ($node->field_select_upload['und'][0]['value'] == 'image'):
    $images = field_collection_item_load_multiple($node->field_image_collection['und']);
    if (!empty($images)):
      foreach ($images as $image):
        ?>
        <figure class="main-img">
          <img src="<?php print file_create_url($image->field_image['und'][0]['uri']); ?>" alt="<?php print $image->field_image['und'][0]['filename']; ?>"/>
        </figure>
        <?php
      endforeach;
    endif;
  endif;
  ?>
  <?php
  if ($node->field_select_upload['und'][0]['value'] == 'video'):
    ?>
    <div data-video-embed="true" class="video-group <?php if ($node->field_select_upload['und'][0]['value'] == 'image') echo 'hidden'; ?>">
      <figure class="bg-gray-5"></figure>
      <h2 class="title-4 text-white text-center">
        <a href="<?php print $data_js; ?>">
          <?php print t('Watch the video'); ?>
          <span class="wi-icon wi-icon-play"></span>
        </a>
      </h2>
    </div>
    <?php
  endif;
  ?>
</section>

<?php
$product_ref_lollections = field_collection_item_load_multiple($node->field_product_reference_collecti['und']);
if (!empty($product_ref_lollections)):
  foreach ($product_ref_lollections as $product_ref_lollection):
    ?>
    <section class="block-4 carousel carousel-master carousel-master-1 carousel-master-3 bg-blue active">
      <div class="container">
        <div class="block-3">
          <div class="inner">
            <div class="desc text-white">                
              <p>
                <?php print t('Ask for a demo :'); ?>
                <a href="mailto: <?php print $product_ref_lollection->field_email_contact['und'][0]['value']; ?>" class=" text-white text-underline"><?php print ' ' . $product_ref_lollection->field_email_contact['und'][0]['value']; ?></a>                
              </p>  
              <a class="text-white" href="<?php print $product_ref_lollection->field_link_for_product['und'][0]['url']; ?>">
                <?php print $product_ref_lollection->field_description['und'][0]['value']; ?>
              </a>
            </div>              
          </div>
          <figure>
            <a target="_blank" href="<?php print $product_ref_lollection->field_link_for_product['und'][0]['url']; ?>">
              <img src="<?php print file_create_url($product_ref_lollection->field_image_for_product['und'][0]['uri']); ?>" alt="<?php print $product_ref_collection->field_image_for_product['und'][0]['filename']; ?>"/>
            </a>
          </figure>
        </div>
      </div>
    </section>
    <?php
  endforeach;
endif;
?>
<?php if(!empty($node->field_reviews)): ?>
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
<?php endif; ?>

<section class="block-6 breadcrumb-block">
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="<?php print $base_url; ?>"><?php print t('Home'); ?></a>
      </li>
      <li><a href="/products-list"><?php print t('Products'); ?></a>
      </li>
      <li><a href="<?php print '/products/' . $node->field_product_type['und'][0]['tid']; ?>"><?php print $node->field_product_type['und'][0]['taxonomy_term']->name; ?></a>
      </li>
      <li class="active"><span><?php print $node->title; ?></span></li>
    </ol>
  </div>
</section>

<?php
// render theme store location m2m
print theme('thu_store_location_m2m');
?>

<script type="text/javascript">
  var menu_product = jQuery(".main-menu ul li > a.products");
  menu_product.addClass("active-trail active");
  menu_product.parent().addClass("active");
</script>