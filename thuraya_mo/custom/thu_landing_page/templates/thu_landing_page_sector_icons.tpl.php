<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
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