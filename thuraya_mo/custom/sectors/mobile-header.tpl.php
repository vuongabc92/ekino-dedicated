<?php $mob = getMobile();
if($mob!=1){
?>
 <div class="ui-header"  >
    <div class="header-bar  ui-hbg">
      <!-- header-bar -->
      <div class="ui-bar-nav ">
        <div class="h-block-a">
          <!-- h-block-a-->
        <?php print render($mobile['page']['top_menu']); ?>
        </div>
        <!-- /h-block-a -->
        <div class="h-block-b">
          <!-- h-block-b-->
          <div class="b-sn-block sn">
           
		<?php print share_icons();?>
          </div>
          <div class="b-serach-block">
            
		     <?php print render($mobile['page']['search_form']); ?>
             </div>
        </div>
        <!-- /h-block-b-->
      </div>
    </div>
    <!-- /header-bar -->
    <!--  Logo and Main Navigation -->
    <div class="ui-header-nav">
      <div class="c-logo"> 
          <?php  if ($mobile['logo']): ?>
      <a href="<?php print $mobile['front_page']; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo"><img src="<?php print $mobile['logo']; ?>" alt="<?php print t('Home'); ?>" /></a>
    <?php endif; ?>
      </div>
      <div class="main-nav">
                		 <?php print drop_down_menus();?>

                 <?php print render($mobile['page']['main_menu']); ?>

      </div>
    </div>
    <!--  /Logo and Main Navigation -->
  </div>
  
 
 <?php } else {
global $base_url, $user;
$theme_url = $base_url . '/sites/all/themes/thuraya/';
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
    <link type="text/css" href="<?php print $theme_url; ?>/css/mobile-style.css" rel="stylesheet"  />    
    <?php drupal_add_js(drupal_get_path('module', 'sectors') . '/mobile.js'); ?>

</head>

 <!--  tui-header-->
 <div class="main-dv">
 	<div class="tui-page">

    <div class="tui-header">
	    <div id="btn_mainMenu" class="tui-menu-btn"><a href="#"></a></div>
        <div class="tui-logo">
<?php if ($mobile['logo']): ?>
                <a href="<?php print $mobile['front_page']; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
                    <img src="<?php print $theme_url; ?>/images/logo.png" alt="<?php print t('Home'); ?>" /></a>
<?php endif; ?>
        </div>

        
  
 </div>
    <!--  /tui-header-->
   <div class="tui-content">
            
   <?php } ?>