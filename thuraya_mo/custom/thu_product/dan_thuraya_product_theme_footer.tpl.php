
<?php
if (!empty($categories)):
  foreach ($categories as $value):
    $name_category = $value['name'];
    $products = taxonomy_select_nodes($value['id'], FALSE);
    ?>
    <div class="block-2 land-voice-block">
      <!--<h3 href="<?php // print '/products/'.$value['id']  ?>" class="title-3"><?php // print $name_category ?></h3>-->
      <a class="title-3" href="<?php print '/products/' . $value['id'] ?>"><?php print $name_category ?></a>
      <div class="content"> 
        <ul class="list-2">
          <?php
          foreach ($products as $product):
            $node = node_load($product);
            ?>
            <li>
              <a href="<?php print url(drupal_get_path_alias('node/' . $node->nid)); ?>"><?php print $node->title ?></a>
              <!--<a target="_blank" href="<?php //print 'http://thuraya.com/'. drupal_get_path_alias('node/'.$node->nid); ?>"><?php //print $node->title; ?></a>-->
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
    <?php
  endforeach;
endif;
?>