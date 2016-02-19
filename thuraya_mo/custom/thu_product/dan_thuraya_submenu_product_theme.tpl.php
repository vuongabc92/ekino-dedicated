<div class="mega-menu">
  <div class="container">
    <?php
    if ((isset($categories)) && (count($categories) > 0)):
      foreach ($categories as $value):
        $name_category = $value['name'];
        $products = taxonomy_select_nodes($value['id'], FALSE);
        ?>
        <div class="mega-menu-col">
          <!--<h3 class="mega-menu-header">-->
          <a class="mega-menu-header" href="<?php print '/products/' . $value['id'] ?>">
            <figure>
              <img class="img-responsive" alt="" src="<?php print image_style_url('34x38', $value['icon']); ?>">
            </figure>
            <span class="header-title">
              <?php print $name_category ?>
            </span>
          </a>
          <!--</h3>-->
          <div class="menu-item">
            <h3 class="mega-menu-header hidden-lg">
              <figure>
                <img class="header-icon" alt="" src="<?php print image_style_url('34x38', $value['icon']); ?>">
              </figure>
              <span class="header-title"><?php print $name_category ?></span>
            </h3>
            <ul>
              <?php
              foreach ($products as $product):
                $node = node_load($product);
                ?>
                <li>
                  <a href="<?php print url(drupal_get_path_alias('node/' . $node->nid)); ?>"><?php print $node->title ?></a>
                </li>
                <?php
              endforeach;
              ?>
            </ul>
          </div>
        </div>
        <?php
      endforeach;
    endif;
    ?>
  </div>
</div>