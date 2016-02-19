<?php
/**
 * @file
 * Thuraya Sector Landing Page List All
 */
?>

<section data-active-block="true" class="sector-carousel">

  <!-- Sector Navigation -->
  <div data-fixed-scroll class="block-9 social-media-block social-media-block-1 bg-white active hidden-sm hidden-md fixed-1">
    <div class="container">
      <ul data-slider data-type="custom" data-autoplay="false" data-slides-to-show="7" data-responsive-for="block-scroll" data-dots="false" class="social-list grey">
        <?php
        if ( is_array($landing_sectors) && count($landing_sectors) ) :
          $i = 0;
          foreach ($landing_sectors as $sector) :
            $i++;
            $nav_icon       = file_create_url($sector->field_sector_navigation_icon['und'][0]['uri']);
            $nav_icon_hover = file_create_url($sector->field_sector_nav_icon_hover['und'][0]['uri']);
            $nav_icon_alt   = (isset($sector->field_landing_sector_title['und'][0]['value'])) ? str_replace(array('{{', '}}'), '', $sector->field_landing_sector_title['und'][0]['value']) : '';
          ?>
          <li>
            <button type="button" id="btn-<?php print $i;?>" name="btn-<?php print $i;?>" data-click-to-scroll="[data-block-scroll-<?php print $i;?>]">
              <figure class="sector-img img-current">
                <img src="<?php print $nav_icon; ?>" alt="<?php print $nav_icon_alt ?>"/>
              </figure>
              <figure class="sector-img img-hover">
                <img src="<?php print $nav_icon_hover; ?>" alt="<?php print $nav_icon_alt ?>"/>
              </figure>
            </button>
          </li>
          <?php
          endforeach;
        endif;
        ?>
      </ul>
    </div>
  </div><!-- End Sector Navigation -->

  <!-- Sector Block -->
  <?php
  if ( is_array($landing_sectors) && count($landing_sectors) ) :
    $j            = 0;
    $paging_count = 0;
    $paging_row   = 2;
    $st = 1;
    foreach ($landing_sectors as $sector) :
      $sector_img          = file_create_url($sector->field_landing_image['und'][0]['uri']);
      $sector_icon         = file_create_url($sector->field_landing_sector_image['und'][0]['uri']);
      $sector_sol_cat_icon = file_create_url($sector->field_sector_solution_cat_icon['und'][0]['uri']);
      $sector_sol_cat_icon_hover = file_create_url($sector->field_sector_solution_category_i['und'][0]['uri']);
      $sector_color        = (isset($sector->field_sector_icon_border_color['und'][0]['rgb'])) ? $sector->field_sector_icon_border_color['und'][0]['rgb'] : '';
      $sector_text_color   = (isset($sector->field_landing_block_text_color['und'][0]['rgb'])) ? $sector->field_landing_block_text_color['und'][0]['rgb'] : '';
      $sector_alt          = (isset($sector->field_landing_sector_title['und'][0]['value'])) ? str_replace(array('{{', '}}'), '', $sector->field_landing_sector_title['und'][0]['value']) : '';
      $sector_bold_name    = (isset($sector->field_landing_sector_title['und'][0]['value'])) ? str_replace(array('{{', '}}'), array('<strong>', '</strong>'), $sector->field_landing_sector_title['und'][0]['value']) : '';
      $sector_short_desc   = (isset($sector->field_landing_short_description['und'][0]['value'])) ? $sector->field_landing_short_description['und'][0]['value'] : '';
      $sector_solution_cat = thu_landing_page_get_solution_cat_by_landing_sector($sector->nid);
      
    
      if ($j === 0 || (($j%$paging_row) === 0)) {
          if($st <= count($landing_sectors)){
            print '<div class="row">';
          }
      }
      $j++;

    ?>
  
    <?php if($st <= count($landing_sectors)): ?>
		<?php if(count($landing_sectors) % 2 === 1 && $st === count($landing_sectors)): ?>
			<div class="col-lg-12 carrousel-campaign-block-1">
		<?php else: ?>
			<div class="col-sm-6 col-lg-12 carrousel-campaign-block-1">
		<?php endif; ?>
    <?php endif; ?>        
      <div data-block-scroll-<?php print $j; ?> data-block data-not-set-min-height="true" class="block-4 campaign-block sector-campaign-block sector-campaign-1">
        <div class="screen-block carousel-campaign carousel-campaign-1">
          <div class="content">
            <figure class="main-img">
              <img src="<?php print $sector_img; ?>" alt="<?php print $sector_alt; ?>"/>
            </figure>
            <div class="container">
              <div class="inner">
                <div class="block-3" style="color:<?php print $sector_text_color; ?>">
                  <div class="inner">
                    <div class="img-group">
                      <figure class="sector-img" style="">
                        <img src="<?php print $sector_icon; ?>" alt="<?php print $sector_alt; ?>"/>
                      </figure>
                    </div>
                    <h2 class="title-1"><?php print $sector_bold_name; ?></h2>
                    <p class="desc"><?php print $sector_short_desc; ?></p>
                    <a href="<?php print drupal_get_path_alias('node/' . $sector->vid); ?>" style="color:<?php print $sector_text_color; ?>" class="link-1"><?php print t('Know more'); ?><span class="icon-moon-arrow-right2"></span></a>
                    <button type="button" style="background-color:<?php print $sector_color; ?>" class="btn-add" data-click-add-attr="showPopup" data-hover="true" data-target="[data-click-popup]" data-rm-class-name="hidden-popup">
                      <?php print t('Use it for'); ?><i class="wi-icon wi-icon-add"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div data-click-popup class="popup popup-1 <?php print ($i = count($landing_sectors)) ? 'popup-2':''; ?> bg-blue-popup" style="background-color:<?php print $sector_color; ?>; opacity: 0.8;">
              <button type="button" class="btn-close wi-icon wi-icon-close-1 hidden-lg hidden-md hidden-sm"></button>
              <div class="inner">
                <h2 class="title-2 text-white text-uppercase"><?php print t('Solutions for you'); ?></h2>
                
                <ul data-slider="true" data-type="custom" data-slides-to-show="1" data-slides-to-scroll="1" data-autoplay="false" data-responsive-for="sector-related" class="list-item">
                  <?php
                        if (is_array($sector_solution_cat) && count($sector_solution_cat)) {
                            $num_solutions = count($sector_solution_cat);
                            
                            $num_li = ceil($num_solutions / 3); //ex: 3

                            $showed = array();
                            $convert = array();
                            
                            $ii = 0;

                            foreach ( $sector_solution_cat as $item){
                                $convert[] = $item;
                            }
                            
                            for( $li = 0; $li < $num_li ; $li++){
                                
                                print '<li>';
                                                                    
                                    for( $ii; $ii < count($convert) ; $ii++){
                                            
                                        ?>
                                        <a href="<?php print drupal_get_path_alias('node/' . $convert[$ii]->nid); ?>" class="item item-2">
                                        <figure class="item-img item-img-current"><img src="<?php print $sector_sol_cat_icon; ?>" alt="<?php print $convert[$ii]->title; ?>">
                                        </figure>
                                        <figure class="item-img item-img-hover"><img src="<?php print $sector_sol_cat_icon_hover; ?>" alt="<?php print $convert[$ii]->title; ?>">
                                        </figure>
                                        <span class="text-2"><?php print $convert[$ii]->title; ?></span></a>
                                        <?php
                                            $showed[] = $key;
                                        if(++$ii%3 == 0){
                                            break;
                                        } else {
                                             $ii--;
                                        }                                        
                                    }                                
                                print '</li>';
                            }
                        }
                    ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php if($st <= count($landing_sectors)): ?>
    </div>
    <?php endif; ?>
    <?php
    
    if (($paging_count++ % $paging_row) === $paging_row - 1 || $j === count($landing_sectors)) {
        if($st <= count($landing_sectors)){
            print '</div>'; 
        }
    }
    //$j++;
    $st++;
    endforeach;
  endif;
  ?>
  </div>
</section>