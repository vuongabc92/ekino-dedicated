<?php
/*
 * @file node--module_banner.tpl.php.
 *
 */
?>
<?php
$field_traction = field_get_items('node', $node, 'field_traction');
$field_photo_gallery = field_get_items('node', $node, 'field_photo_gallery');
$entity_type = 'field_collection_item';
$bundle_name = 'field_photo_gallery';
$info = field_info_instances($entity_type, $bundle_name);
$crop_style_list = $info['field_gallery_picture']['widget']['settings']['manualcrop_styles_list'];
global $base_url, $language;
$alilas_current = $base_url . request_uri();
$value_traction = $field_traction ? nl2br($field_traction[0]['value']) : '';
$description_share = $field_traction[0]['value'];
$nid_current = get_node_id_current();

$node_alias = drupal_lookup_path('alias', 'node/' .$node->nid);
$social_share = variable_get('social_networks_sharing_' .$language->language);

?>
<div data-photo-gallery class="photo-gallery spacing-bottom">
    <h2 class="title"><?php print $node->title; ?></h2>
    <div class="desc">
        <p>
            <?php print $value_traction; ?>
        </p>
    </div>
    <?php
    if (!empty($field_photo_gallery)):
      ?>
      <ul class="gallery">
          <?php
          $key_photo = 0;
          $key_empty = 0;
          foreach ($field_photo_gallery as $key => $item):
            $slide = field_collection_item_load($item['value']);
            if ($slide && !empty($slide->field_gallery_picture[LANGUAGE_NONE][0]['uri'])):
              $key_photo ++;
            else:
              $key_empty ++;
            endif;
          endforeach;
          $j = 1;
          foreach ($field_photo_gallery as $key => $item):
            $slide = field_collection_item_load($item['value']);
            $count = count($field_photo_gallery);
            if ($slide && !empty($slide->field_gallery_picture[LANGUAGE_NONE][0]['uri'])):
              $slide_image_src = $slide->field_gallery_picture[LANGUAGE_NONE][0]['uri'];
              $slide_image_alt = !empty($slide->field_gallery_picture[LANGUAGE_NONE][0]['alt']) ? $slide->field_gallery_picture[LANGUAGE_NONE][0]['alt'] : strip_tags($node->title);
              if ($crop_style_list) :
                $interchange = v2_mumm_interchange_images($slide_image_src, $crop_style_list, 'module_photo_gallery');
              else :
                $crop_style_list = array('335x452', '335x452', '335x452');
                $interchange = v2_mumm_interchange_images($slide_image_src, $crop_style_list, 'module_photo_gallery');
              endif;

              $class = '';
              $text_number = '';
              if ($key_photo > 4 && $j == 4):
                $class = 'class="last"';
                $number = $count - $key_empty - 4;
                $text_number = '<span class="number-photo">+' . $number . '</span></a>';
              endif;
              if ($j < 5):
                ?>
                <li <?php print $class; ?>>
                    <a href="javascript:;" title="Gallery"
                      data-tracking data-track-action="open" data-track-category="gallery-<?php print $node_alias; ?>" data-track-label="" data-track-type="event">
                      <img src="<?php print $interchange['data_thumb']; ?>" alt="<?php print $slide_image_alt; ?>" class="grayscale effect" data-interchange='<?php print $interchange['style_list']; ?>'/>
                      <?php print $text_number; ?>
                    </a>
                </li>
                <?php
              endif;
              ?>
              <?php
              $j++;
            endif;
          endforeach;
          ?>
      </ul>
      <div data-gallery-popup class="slider gallery-slider">
          <div class="inner popup-content">
              <div data-gallery-slider class="list-gallery">
                  <?php
                  $i = 1;
                  foreach ($field_photo_gallery as $key => $item):
                    $slide = field_collection_item_load($item['value']);
                    $fid = $slide->field_gallery_picture['und'][0]['fid'];
                    $link_share_twitter = url($base_url.'/'.'gallery-photo'.'/'.$fid.'/'.$node->nid.'/'.$nid_current);
                    $count = count($field_photo_gallery);
                    if ($slide && isset($slide->field_gallery_picture[LANGUAGE_NONE][0]['uri'])):
                      $uri = $slide->field_gallery_picture[LANGUAGE_NONE][0]['uri'];
                      $url_image = file_create_url($uri);
                      $alt_image = !empty($slide->field_gallery_picture[LANGUAGE_NONE][0]['alt']) ? $slide->field_gallery_picture[LANGUAGE_NONE][0]['alt'] : strip_tags($node->title);
                      ?>
                      <div>
                          <img src="<?php print $url_image; ?>" alt="<?php print $alt_image; ?>"/>
                          <div class="content">
                              <?php
                              if ($slide && isset($slide->field_copyright[LANGUAGE_NONE][0]['value'])):
                                $copy = $slide->field_copyright[LANGUAGE_NONE][0]['value'];
                                ?>
                                <span><?php print $copy; ?></span>
                              <?php endif; ?>
                              <ul class="social">
                                  <?php if(!is_int($social_share['facebook']) && isset($social_share['facebook'])): ?>
                                  <li>
                                    <a href="javascript:;" title="<?php print t('Facebook'); ?>" class="icon icon-fb-light"
                                      data-share="data-share" data-share-content="{&quot;urlPage&quot;: &quot;<?php print $alilas_current; ?>&quot;, &quot;urlImg&quot;: &quot;<?php print $url_image; ?>&quot;, &quot;caption&quot;: &quot;<?php print $node->title; ?>&quot;, &quot;description&quot;: &quot;<?php print $description_share; ?>&quot;}"
                                      data-tracking data-track-action="share" data-track-category="gallery-<?php print $node_alias; ?>" data-track-label="facebook-<?php print $alt_image; ?>" data-track-type="event">
                                      <?php print t('Facebook'); ?>
                                    </a>
                                  </li>
                                  <?php endif; ?>
                                  <?php if(!is_int($social_share['twitter']) && isset($social_share['twitter'])): ?>
                                  <li class="last">
                                    <a href="https://twitter.com/intent/tweet?text=<?php print $link_share_twitter; ?>"
                                      data-share-twitter title="<?php print t('Twitter'); ?>" data-share-twitter class="icon icon-tw-light"
                                      data-tracking data-track-action="share" data-track-category="gallery-<?php print $node_alias; ?>" data-track-label="twitter-<?php print $alt_image; ?>" data-track-type="event">
                                      <?php print t('Twitter'); ?>
                                    </a>
                                  </li>
                                  <?php endif; ?>
                              </ul>
                          </div>
                      </div>
                      <?php
                    endif;
                    $i ++;
                  endforeach;
                  ?>
              </div>
              <span data-count-item class="pagination">1 / <?php print $key_photo; ?></span>
          </div>
      </div>
      <?php
    endif;
    ?>
</div>