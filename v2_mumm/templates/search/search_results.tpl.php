<?php
/**
 * @file
 * Default theme implementation for displaying search results.
 *
 * This template collects each invocation of theme_search_result(). This and
 * the child template are dependent to one another sharing the markup for
 * definition lists.
 *
 * Note that modules may implement their own search type and theme function
 * completely bypassing this template.
 *
 * Available variables:
 * - $search_results: All results as it is rendered through
 *   search-result.tpl.php
 * - $module: The machine-readable name of the module (tab) being searched, such
 *   as "node" or "user".
 *
 *
 * @see template_preprocess_search_results()
 *
 * @ingroup themeable
 */
?>
<div class="search-results">
  <div data-loadmore data-url-loadmore="assets/datas/list-products.json" data-list-wrapper=".list-products" class="product-block">
    <div class="grid-fluid">
      <div class="heading-block">
        <h1 class="title title-large"><?php print t('Results'); ?></h1>
        <h2 class="title sub-title">3 <?php print t('products'); ?></h2>
      </div>
      <div data-eqheight-products data-list-elements=".kind|.title" class="list-products list-products-2">
        <?php
        foreach ($search_champagne as $key => $item) :
          $node = $item['node'];
          $node_view = node_view($node, '');

          $node_view['#theme'] = 'node__champagne_ritual';
          $rendered_node = drupal_render($node_view);
          echo $rendered_node;
        endforeach;
        ?>
     </div><a href="#" title="Load more" class="btn btn-gray center-btn" data-loadmore-trigger="data-loadmore-trigger">Load more</a>
    </div>
  </div>
  <div data-loadmore data-url-loadmore="assets/datas/list-products.json" data-list-wrapper=".list-products" class="articles-block spacing-bottom">
    <div class="grid-fluid">
      <h3 class="title sub-title">6 <?php print t('articles'); ?></h3>
      <div class="list-products list-products-1">
        <div class="product-item">
          <div class="visual"><a href="#" title="Tip n°01" class="image-wrap"><img src="assets/images/upload/cross-content-1.jpg" alt="alt" class="product-image"/></a>
            <div class="roll-over">
              <div class="inner">
                <div class="content"><a href="#" title="Read more" class="btn btn-white">Read more</a>
                </div>
              </div>
            </div>
          </div>
          <h3 class="kind"><a href="#" title="Tip n°01" class="link-title">Tip n°01</a>
          </h3>
          <h2 class="title"><a href="#" title="How to choose the perfect aperitif?" class="link-title">How to choose the perfect aperitif?</a>
          </h2>
        </div>
        <div class="product-item">
          <div class="visual"><a href="#" title="Tip n°02" class="image-wrap"><img src="assets/images/upload/cross-content-2.jpg" alt="alt" class="product-image"/></a>
            <div class="roll-over">
              <div class="inner">
                <div class="content"><a href="#" title="Read more" class="btn btn-white"> Read more</a>
                </div>
              </div>
            </div>
          </div>
          <h3 class="kind"><a href="#" title="Tip n°02" class="link-title">Tip n°02</a>
          </h3>
          <h2 class="title"><a href="#" title="How to sabre a bottle of champagne?" class="link-title">How to sabre a bottle of champagne?</a>
          </h2>
        </div>
        <div class="product-item">
          <div class="visual"><a href="#" title="Tip n°03" class="image-wrap"><img src="assets/images/upload/cross-content-3.jpg" alt="alt" class="product-image"/></a>
            <div class="roll-over">
              <div class="inner">
                <div class="content"><a href="#" title="Read more" class="btn btn-white">Read more</a>
                </div>
              </div>
            </div>
          </div>
          <h3 class="kind"><a href="#" title="Tip n°03" class="link-title">Tip n°03</a>
          </h3>
          <h2 class="title"><a href="#" title="What starters can be served with champagne?" class="link-title">What starters can be served with champagne?</a>
          </h2>
        </div>
        <div class="product-item">
          <div class="visual"><a href="#" title="Tip n°04" class="image-wrap"><img src="assets/images/upload/cross-content-4.jpg" alt="alt" class="product-image"/></a>
            <div class="roll-over">
              <div class="inner">
                <div class="content"><a href="#" title="Read more" class="btn btn-white">Read more</a>
                </div>
              </div>
            </div>
          </div>
          <h3 class="kind"><a href="#" title="Tip n°04" class="link-title">Tip n°04</a>
          </h3>
          <h2 class="title"><a href="#" title="How to accompany with champagne the whole meal?" class="link-title">How to accompany with champagne the whole meal?</a>
          </h2>
        </div>
        <div class="product-item">
          <div class="visual"><a href="#" title="Tip n°04" class="image-wrap"><img src="assets/images/upload/cross-content-5.jpg" alt="alt" class="product-image"/></a>
            <div class="roll-over">
              <div class="inner">
                <div class="content"><a href="#" title="Read more" class="btn btn-white">Read more</a>
                </div>
              </div>
            </div>
          </div>
          <h3 class="kind"><a href="#" title="Tip n°05" class="link-title">Tip n°05</a>
          </h3>
          <h2 class="title"><a href="#" title="How to cook with champagne?" class="link-title">How to cook with champagne?</a>
          </h2>
        </div>
        <div class="product-item">
          <div class="visual"><a href="#" title="Tip n°06" class="image-wrap"><img src="assets/images/upload/cross-content-6.jpg" alt="alt" class="product-image"/></a>
            <div class="roll-over">
              <div class="inner">
                <div class="content"><a href="#" title="Read more" class="btn btn-white">Read more</a>
                </div>
              </div>
            </div>
          </div>
          <h3 class="kind"><a href="#" title="Tip n°06" class="link-title">Tip n°06</a>
          </h3>
          <h2 class="title"><a href="#" title="Which are the most classic cocktails with champagne?" class="link-title">Which are the most classic cocktails with champagne?</a>
          </h2>
        </div>
      </div><a href="#" title="Load more" class="btn btn-gray center-btn" data-loadmore-trigger="data-loadmore-trigger">Load more</a>
    </div>
  </div>
</div>
