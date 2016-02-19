<div data-type="open" id="product">
    <?php print babybel_contextual_render('background_header_products_page'); ?>
    <div class="block-2 <?php print (!$background_footer_products) ? 'padding-bottom-1' : ''; ?>">
        <div class="container">

            <?php print babybel_contextual_render('product_info_products'); ?>
            <?php
            $products = babybel_common_get_products();
            $tips = babybel_products_get_tips();
            if ((empty($products)) && (empty($tips))) {
              drupal_goto('<front>');
            }
            if ($products) {
              ?>
              <div class="product-presentation">
                  <ul data-tab-content data-slider data-mode="carousel" data-autoplay="false" data-clone-dots="true" data-only-mobile="true" class="list-product tab-links clearfix">
                      <?php
                      $tab_id = 1;
                      foreach ($products as $product) {
                        echo '<li class="item" data-tab-id="' . $tab_id . '">';
                        $view_product = node_view($product, 'product_products');
                        print drupal_render($view_product);
                        ?>
                        <div data-id="<?php print $tab_id; ?>" class="tabs-content even-<?php print $tab_id; ?>">
                            <?php
                            $view_product_detail = node_view($product, 'product_detail_products');
                            print drupal_render($view_product_detail);
                            ?>
                            <!-- .right-panel -->
                        </div>
                        <!-- .tabs-content -->
                        <?php
                        echo '</li>';
                        $tab_id++;
                      }
                      ?>
                  </ul>
                  <!-- .list-product -->
              </div>
              <!-- .product-presentation -->
              <?php
            }
            ?>


            <?php
            if ($tips) {
              ?>
              <div class="advices-block">
                  <ul class="tab-links advices-list clearfix" data-slider data-mode="carousel" data-autoplay="false" data-only-mobile="true" data-clone-dots="true" data-arrows="false" data-item-per-line="2" data-set-arrows="false" data-tab-content="">
                      <?php
                      $data_id_tip = 1;
                      foreach ($tips as $tip) {
                        echo '<li data-tab-id="' . $data_id_tip . '" class="item">';
                        $view_tip = node_view($tip, 'tip_products');
                        print drupal_render($view_tip);
                        ?>
                        <div data-id="<?php print $data_id_tip; ?>" class="tabs-content">
                            <?php
                            $view_tip_detail = node_view($tip, 'tip_detail_products');
                            print drupal_render($view_tip_detail);
                            ?>
                        </div>
                        <!-- .tabs-content -->
                        <?php
                        echo '</li>';
                        $data_id_tip++;
                      }
                      ?>
                  </ul>
                  <!-- .tab-links -->
              </div>
              <!-- .advices-block -->
            <?php } ?>

            <?php print babybel_contextual_render('product_push_block'); ?>
        </div>
        <!-- .container -->
    </div>
    <!-- .block-2 -->
    <?php if ($background_footer_products): ?>
      <div class="background-block">
          <?php print babybel_contextual_render('background_footer_products_page'); ?>
      </div>
      <!-- .background-block -->
    <?php endif; ?>
</div>
<!-- #product -->