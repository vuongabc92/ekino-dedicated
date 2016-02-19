<?php
/*
 * @file
 * v2-search-article-wrapper.tpl
 *
 */
$count_article = $total > 0 ? format_plural($total, '1 '._hs_resource_get('article','plain', FALSE, FALSE), '@count '. _hs_resource_get('articles','plain', FALSE, FALSE)) : '';
$count_article_content = '<h3 class="title sub-title">'.$count_article.'</h3>';
$resource_name = format_plural($total, 'article', 'articles');
$no_match = '<p class="center-btn">' . _hs_resource_get('no_articles_matched','plain', FALSE, FALSE, FALSE, 'No Articles matched') . '</p>';
$load_more_get_language = _hs_resource_get('load_more','plain', FALSE, FALSE, FALSE, 'Load more');
$load_more = '<a href="javascript:;" title="'.$load_more_get_language.'" class="btn btn-gray center-btn" data-loadmore-trigger="data-loadmore-trigger">'.$load_more_get_language.'</a>';
?>
<div data-loadmore data-url-loadmore="<?php print url('ghmumm/search/article/load-more/' . $key_word); ?>" data-list-wrapper=".list-products" class="articles-block spacing-bottom cross-content">
  <div class="grid-fluid">
    <?php print hs_resource_contextual_link($resource_name, $count_article_content); ?>
    <?php if ($total > 0): ?>
      <div class="list-products list-products-1">        
        <?php print theme('v2_search_article_item', array('nodes' => $nodes)); ?>    
      </div>
      <?php if ($total > $number_item): ?>
        <?php print hs_resource_contextual_link('load_more', $load_more); ?>
      <?php endif; ?>
      <?php
    else:
      print hs_resource_contextual_link('no_articles_matched', $no_match);
    endif;
    ?>
  </div>
</div>
</div>
