<?php
global $base_url;
render($page['content']['metatags']);
$mob = getMobile();

if ($mob != 1) {
    drupal_add_js($base_url . '/' . path_to_theme() . '/js/jquery-1.8.2.min.js');
    drupal_add_js($base_url . '/' . path_to_theme() . '/js/jquery.easing.min.js');
    drupal_add_js($base_url . '/' . path_to_theme() . '/js/home.js');
    drupal_add_js($base_url . '/' . 'sites/all/libraries/colorbox/jquery.colorbox.js');
    ?>

    <script type="text/javascript">
        jQuery(document).ready(function(){
            var sheight = jQuery('#sheight').text();
            var swidth = jQuery('#swidth').text();
            if(jQuery.trim( jQuery('#splash').html() ).length > 0) {
                setTimeout(function() {
                    jQuery.fn.colorbox({width: swidth, height:sheight, inline:true, href:"#splash"});
                }, 1500);
            }		
        });
    </script>
    <div class="ui-page">
        <!--  Header Section -->
        <div class="ui-header"  >
            <div class="header-bar  ui-hbg">
                <!-- header-bar -->
                <div class="ui-bar-nav ">
                    <div class="h-block-a">
                        <!-- h-block-a-->
                        <?php print render($page['top_menu']); ?>
                    </div>
                    <!-- /h-block-a -->
                    <div class="h-block-b">
                        <!-- h-block-b-->
                        <div class="b-sn-block sn">          
                            <?php print share_icons(); ?>
                        </div>
                        <div class="b-serach-block">           
                            <?php print render($page['search_form']); ?>
                        </div> 
                    </div>
                    <!-- /h-block-b-->
                </div>
            </div>
            <!-- /header-bar -->
            <!--  Logo and Main Navigation -->
            <div class="ui-header-nav">
                <div class="c-logo"> 
                    <?php if ($logo): ?>
                        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" /></a>
                    <?php endif; ?>
                </div>
                <div class="main-nav">       
                    <?php print drop_down_menus(); ?>
                    <?php print render($page['main_menu']); ?>
                </div>
            </div>
            <!--  /Logo and Main Navigation -->
        </div>
        <!--  /Header Section -->
        <!--  Content Section -->
        <div class="ui-content">  
            <!--  iPad Portriat -->
            <div id="ipad-cont" style="width:100%; margin:auto; position:relative; overflow:hidden;">
                <div class="ip-lines" style="display:block;">
                    <div class="ip-main-container">
                        <a href="<?php print $base_url . '/energy-comms'; ?>" class="ip-icon eng"><span>EnergyComms</span></a>
                        <a href="<?php print $base_url . '/media-comms'; ?>" class="ip-icon iMedia"><span>MediaComms</span></a>
                        <a href="<?php print $base_url . '/defense-comms'; ?>" class="ip-icon iDefence"><span>DefenseComms</span></a>
                        <a href="<?php print $base_url . '/enterprise-comms'; ?>" class="ip-icon iEnt"><span>EnterpriseComms</span></a>
                        <a href="<?php print $base_url . '/marine-comms'; ?>" class="ip-icon iMarine"><span>MarineComms</span></a>
                        <a href="<?php print $base_url . '/leisure-comms'; ?>" class="ip-icon iAviation"><span>LeisureComms</span></a>
                        <a href="<?php print $base_url . '/relief-comms'; ?>" class="ip-icon iRelief"><span>ReliefComms</span></a>
                    </div>
                    <div class="ip-mian-navigation">
                        <ul>
                            <a href="<?php print $base_url . '/network-coverage'; ?>"><li class="net ip-icon"></li></a>
                            <a href="<?php print $base_url . '/products-list'; ?>"><li class="prod ip-icon"></li></a>
                            <a href="<?php print $base_url . '/where-to-buy'; ?>"><li class="wbt ip-icon"></li></a>
                            <a href="javascript:void()"><li class="mc ip-icon"></li></a>
                        </ul>
                    </div>
                </div>
            </div>
            <!--  iPad Portriat -->
            <div class="" id="animation_container" style="width:100%; margin:auto; min-width:1000px;  position:relative; overflow:hidden;">
                <div class="anim-cont" id="home_sreen">
                    <div class="lines" >

                    </div>

                </div>		      		 
            </div>

            <div class="bottom-container">
                <div class="img-holder">
                    <?php print get_campaign_pages(); ?>
                </div>
            </div>
        </div>
        <!--  /Content Section -->
        <!-- Footer -->
        <div class="ui-footer-bar">
            <div class="ui-flinks">

                <?php //print render($page['partner_login']); ?>         
                <div class="footer-container"><?php print render($page['footer']); ?></div>		
            </div>
        </div>
        <?php print render($page['bottom']); ?>
        <!-- /Footer -->
    </div>
    <div style="display:none">
        <div id="splash">
            <?php print get_brand_data(); ?>
        </div>
    </div>
<?php } else {
print $mobile_content;

	}