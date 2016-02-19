<?php
/*
 * @file
 * v2-search-product-champagne-wrapper.tpl
 *
 */
global $language;

$count_article = $total > 0 ? format_plural($total, '1 '._hs_resource_get('Product','plain', FALSE, FALSE), '@count '. _hs_resource_get('Products','plain', FALSE, FALSE)): '';
$count_article_content = '<h3 class="title sub-title">'.$count_article.'</h3>';
$resource_name = format_plural($total, 'Product', 'Products');
$no_match = '<p class="center-btn">' . _hs_resource_get('no_products_matched','plain', FALSE, FALSE, FALSE, 'No products matched') . '</p>';
$load_more_get_language = _hs_resource_get('load_more','plain', FALSE, FALSE, FALSE, 'Load more');
$load_more = '<a href="javascript:;" title="'.$load_more_get_language.'" class="btn btn-gray center-btn" data-loadmore-trigger="data-loadmore-trigger">'.$load_more_get_language.'</a>';
?>
<div data-loadmore data-url-loadmore="<?php print url('ghmumm/search/product_champagne/load-more/' . $key_word); ?>" data-list-wrapper=".list-products" class="product-block">
  <div class="grid-fluid">
    <div class="heading-block">
      <?php
      if($language->language == 'jp-jp'):
      ?>
        <h1 class="title title-large">
          <span class="quote"><?php print $key_word; ?></span><?php print _hs_resource_get('for') . _hs_resource_get('Results'); ?>
        </h1>
      <?php
      else:
      ?>
        <h1 class="title title-large">
          <?php print print _hs_resource_get('Results'); ?>
        </h1>
        <h2 class="product-title">
          <?php print _hs_resource_get('for') . ' ' . $key_word; ?>
        </h2>
      <?php endif; ?>

      <?php print hs_resource_contextual_link($resource_name, $count_article_content); ?>

    </div>
    <?php if ($total > 0): ?>
      <div data-eqheight-products data-list-elements=".kind|.title" class="list-products list-products-2">
        <?php print theme('v2_search_product_champagne_item', array('nodes' => $nodes)); ?>
      </div>
      <?php if ($total > $number_item): ?>
        <?php print hs_resource_contextual_link('load_more', $load_more); ?>
      <?php
      endif;
    else:
      print hs_resource_contextual_link('no_products_matched', $no_match);
    endif;
    ?>
  </div>
</div>
