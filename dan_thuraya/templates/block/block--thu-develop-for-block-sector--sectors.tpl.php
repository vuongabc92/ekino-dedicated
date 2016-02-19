<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$sectors = get_node_by_type('sector');
?>

<section data-vertical-middle="true" data-get-height=".started-block-2 .container" data-set-padding=".container" data-set-height="true" class="block-6 started-block started-block-2 bg-gray-6 active">
  <div class="container">
    <div class="wrap">
      <div class="content">
        <a href="become-a-partner" class="title-4 text-center text-dark-gray-1">
          <?php print t('Become a partner'); ?>
        </a>
        <div class="list-item list-item-1">
          <?php
          if (!empty($sectors)):
            foreach ($sectors as $sector):
              $sector_title = $sector->title;
              $sector_title = eregi_replace('Comms', '', $sector_title);
              ?>
              <a href="<?php print url(drupal_get_path_alias('node/'.$sector->nid)); ?>" class="item gray" title="<?php print $sector_title; ?>">
                <figure>
                  <img src="<?php print image_style_url('82x82', $sector->field_icon_sector['und'][0]['uri']); ?>" alt="<?php print $sector->field_icon_sector['und'][0]['filename']; ?>" class="img-current"/>
                  <img src="<?php print image_style_url('82x82', $sector->field_icon_sector_hover['und'][0]['uri']); ?>" alt="<?php print $sector->field_icon_sector_hover['und'][0]['filename']; ?>" class="img-hover"/>
                </figure>
                <span class="text-2"><?php print $sector_title; ?></span>
              </a>
              <?php
            endforeach;
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>
</section>
