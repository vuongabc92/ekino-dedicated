<?php
$breadcrumbs = $share['breadcrumb_results'];
$breadcrumb_result = v2_breadcrumb_load_breadcrumb($breadcrumbs);
$nodes = $build['nodes'];
$total_items = $build['total'];
$resource_name = format_plural($total_items, 'article', 'articles');
$count_article = $total_items > 0  ? format_plural($total_items, '1 '._hs_resource_get('article','plain', FALSE, FALSE), '@count '. _hs_resource_get('articles','plain', FALSE, FALSE)): '';
$content_count = '<p class="filter-title"><span data-num-result="" class="product-number">'.$count_article.'</span></p>';
$filter_get_languague = _hs_resource_get('Filter','plain', FALSE, FALSE);
$filter =  '<a href="javascript:;" title="'.$filter_get_languague.'" class="filter-btn close">'.$filter_get_languague.'</a>';
$load_more_get_language = _hs_resource_get('load_more','plain', FALSE, FALSE, FALSE, 'Load more');
$load_more = '<a href="javascript:;" title="'.$load_more_get_language.'" class="btn btn-gray btn-sm slim-text center-btn" data-loadmore-trigger="data-loadmore-trigger">'.$load_more_get_language.'</a>';
$current_path = current_path();
?>
<div data-filters="" class="filter-news" data-destination="<?php print $current_path;?>">
  <div class="page-navigation">
    <div class="grid-fluid">
      <?php
      //Modular page
      if (!empty($share) && !empty($share['title'])):
        ?>
        <h1 class="title title-medium"><?php print $share['title']; ?></h1>
        <?php
      endif;
      ?>
      <div class="inner">
        <?php print hs_resource_contextual_link('Filter', $filter, 'filter-btn close'); ?>
        <?php if (count($breadcrumbs)): ?>
          <?php print $breadcrumb_result; ?>
        <?php endif; ?>
        <?php if($total_items > 0): ?>
          <?php print hs_resource_contextual_link($resource_name, $content_count, 'filter-title'); ?>
        <?php endif;?>
      </div>
      <div data-content-filters="" class="filter-content">
        <div class="radio-btn">
          <input type="radio" name="product-type" id="type-1" value="<?php print _hs_resource_get('All','plain', FALSE, FALSE); ?>" checked="checked" class="hidden" data-url-filters="<?php print url('news-load-ajax'); ?>">
          <label for="type-1"><?php print _hs_resource_get('All'); ?></label>
        </div>
        <?php $i = 2; ?>
        <?php foreach ($taxonomy as $term): ?>
          <div class="radio-btn">
            <input type="radio" name="product-type" id="type-<?php print $i; ?>" value="<?php print drupal_lookup_path('alias', 'taxonomy/term/' . $term->tid); ?>" class="hidden" data-url-filters="<?php print url('news-load-ajax-category/' . $term->tid); ?>">
            <label for="type-<?php print $i; ?>"
              data-tracking data-track-action="click" data-track-category="news-list" data-track-label="<?php print strtolower(drupal_lookup_path('alias', 'taxonomy/term/' . $term->tid)); ?>" data-track-type="event">
              <?php print $term->name; ?>
            </label>
          </div>
          <?php $i++; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <div data-loadmore="" data-destination="<?php print $current_path; ?>" data-url-loadmore="<?php print url('news-load-ajax'); ?>" data-list-wrapper=".list-products" class="articles-block spacing-bottom cross-content">
    <div class="grid-fluid">
      <div data-result-filters="" class="list-products list-products-1">
        <?php foreach ($nodes as $node): ?>
          <?php print drupal_render(node_view($node, 'teaser')); ?>
        <?php endforeach; ?>
      </div>
      <?php if ($build['max_page'] > 1): ?>
         <?php print hs_resource_contextual_link('load_more', $load_more); ?>
      <?php endif; ?>
    </div>
  </div>
</div>