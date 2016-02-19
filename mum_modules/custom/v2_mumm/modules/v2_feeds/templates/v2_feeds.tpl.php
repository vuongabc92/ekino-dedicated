<?php
$breadcrumbs = $items['share']['breadcrumb_results'];
$share = $items['share'];
$breadcrumb_result = v2_breadcrumb_load_breadcrumb($breadcrumbs);
$resource_name = format_plural($items['total'], 'article', 'articles');
$count_article = $items['total'] > 0 ? format_plural($items['total'], '1 '._hs_resource_get('article','plain', FALSE, FALSE), '@count '. _hs_resource_get('articles','plain', FALSE, FALSE)) : '';
$count_article_content = '<p class="filter-title"><span data-num-result="" class="product-number">'.$count_article.'</span></p>';
$filter_get_languague = _hs_resource_get('Filter','plain', FALSE, FALSE);
$filter = '<a href="javascript:;" title="'.$filter_get_languague.'" class="filter-btn close">'.$filter_get_languague.'</a>';
$load_more = '<a href="javascript:;" title="'._hs_resource_get('load_more','plain', FALSE, FALSE, FALSE, 'Load more').'" class="btn btn-gray hidden-xs" data-loadmore-trigger="data-loadmore-trigger">'._hs_resource_get('load_more','plain', FALSE, FALSE, FALSE,'Load more').'</a>';
?>
<div data-filters="" class="filter-article">
    <div class="filter-news">
        <div class="page-navigation">
            <div class="grid-fluid">
                    <?php if (!empty($share) && !empty($share['title'])): ?>
                       <h1 class="title title-medium"><?php print $share['title']; ?></h1>
                    <?php endif; ?>
                <div class="inner">
                      <?php print hs_resource_contextual_link('Filter', $filter, 'filter-btn close'); ?>
                      <?php if (count($breadcrumbs)):?>
                        <?php print $breadcrumb_result; ?>
                      <?php else: ?>
                        <ul itemscope="" itemtype="http://schema.org/BreadcrumbList" class="breadcrumb">
                          <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem" class="item item last-item">
                              <span itemprop="name"><?php print drupal_get_title();?></span>
                            <meta itemprop="position" content="1">
                          </li>
                        </ul>
                      <?php endif;?>
                      <?php if($items['total'] > 0): ?>
                         <?php print hs_resource_contextual_link($resource_name, $count_article_content, 'filter-title'); ?>
                      <?php endif; ?>
                </div>
                <div data-content-filters="" class="filter-content">
                    <div class="radio-btn">
                        <input type="radio" name="social-type" id="type-1" value="<?php print _hs_resource_get('All','plain', FALSE, FALSE); ?>" checked="checked" class="hidden" data-url-filters="<?php print url('feeds-social/filter/all'); ?>">
                        <label for="type-1"><?php print _hs_resource_get('All'); ?></label>
                    </div>
                    <?php
                    $social_types = v2_feeds_get_category_social();
                    $i = 2;
                    ?>
                    <?php foreach ($social_types as $key => $social_type): ?>
                      <div class="radio-btn">
                          <input type="radio" name="social-type" id="type-<?php print $i; ?>" value="<?php print $key; ?>" class="hidden" data-url-filters="<?php print url('feeds-social/filter/' . $key); ?>">
                          <label for="type-<?php print $i++; ?>"><?php print $key; ?></label>
                      </div>
                      <?php $i++; ?>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
    <div data-loadmore="" data-autoload-mobile="true" data-url-loadmore="<?php print url('feeds-social/loadmore/all'); ?>" data-list-wrapper=".articles-list" class="cross-block wall-of-victory">
        <div data-result-filters="" class="articles-list">
            <?php foreach ($items['list_item'] as $item):
                  $path_no_image = v2_mumm_custom_get_path('images').'no-image.jpg';
                  $image_url = !empty($item['#media_url']) ? $item['#media_url'] : $path_no_image;
            ?>
              <div class="article">
                  <div class="item visual">
                      <div class="image-wrap">
                        <img src="<?php print $image_url; ?>" alt="<?php print $item['username']; ?>" class="article-image grayscale" data-interchange="[&quot;<?php print $image_url; ?>&quot;,&quot;<?php print $image_url; ?>&quot;,&quot;<?php print $image_url; ?>&quot;]">
                      </div>
                  </div>
                  <div data-block="" class="item detail">
                      <div class="content">
                          <div class="social-box">
                              <a href="<?php print $item['#url']; ?>" title="<?php print $item['#feed_type']; ?>" class="icon icon-<?php print $item['#feed_type']; ?>-nobg" target="_blank">
                                  <?php print $item['#feed_type']; ?>
                              </a>
                          </div>
                          <span class="date">
                              <?php print format_date($item['#published'], 'custom', 'j M'); ?>
                          </span>
                          <p>
                              <?php print $item['#message']; ?>
                          </p>
                          <span class="prefix"><?php print $item['#username']; ?></span>
                      </div>
                  </div>
              </div>
            <?php endforeach; ?>

        </div>
        <?php if ($items['total'] > 10): ?>
          <?php print hs_resource_contextual_link('load_more', $load_more); ?>
        <?php endif; ?>
    </div>
</div>


