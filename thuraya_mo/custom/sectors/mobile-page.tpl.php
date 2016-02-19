<?php
global $base_url, $user;
$theme_url = $base_url . '/sites/all/themes/thuraya/';
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
    <link type="text/css" href="<?php print $theme_url; ?>/css/mobile-style.css" rel="stylesheet"  />    
    <?php drupal_add_js(drupal_get_path('module', 'sectors') .'/mobile.js'); ?>
<style> html,body { -webkit-text-size-adjust:none;}</style>
</head>
<?php
$full_menu_items = menu_tree_all_data('main-menu');
$parent_menus = common_menu_mobile($full_menu_items,0);
//echo '<pre>'; print_r($links2); echo '</pre>';

?>
<div class="main-dv">
<div class="tui-page">
    <!--  tui-header-->
    <div class="tui-header">
        <div class="tui-logo">
<?php if ($mobile['logo']): ?>
                <a href="<?php print $mobile['front_page']; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
                    <img src="<?php print $theme_url; ?>/images/logo.png" alt="<?php print t('Home'); ?>" /></a>
<?php endif; ?>
        </div>

        <div id="btn_mainMenu" class="tui-menu-btn"><a href="javascript:void(0)"></a></div>
    </div>
    <!--  /tui-header-->
    <!-- content -->
    <div class="tui-content">
        <div class="tui-home-menu">
            <ul class="media">
                <li class="relief"><a href="/relief-comms">Relief<span>COMMS</span> <span class="tui-icon icon-rel"></span></a></li>
                <li class="energy"><a href="/energy-comms">ENERGY<span>COMMS</span> <span class="tui-icon icon-ene"></span></a></li>
                <li class="media"><a href="/media-comms">Media<span>COMMS</span> <span class="tui-icon icon-med"></span></a></li>
                <li class="aviation"><a href="/leisure-comms">Leisure<span>COMMS</span> <span class="tui-icon icon-avi"></span></a></li>
                <li class="marine"><a href="/marine-comms">Marine<span>COMMS</span> <span class="tui-icon icon-mar"></span></a></li>
				 <li class="enterprise"><a href="/enterprise-comms">Enterprise<span>COMMS</span> <span class="tui-icon icon-enterprise"></span></a></li>
                <li class="defense"><a href="/government-comms">Government<span>COMMS</span> <span class="tui-icon icon-def"></span></a></li>               
            </ul>

<?php
$menus = menu_navigation_links('menu-mobile-menu');
print theme('links__menu_mobile_menu', array('links' => $menu, 'attributes' => array(
                'class' => array('tui-home-menu2'),
                )));
?>
<ul class="tui-home-menu2">
<?php foreach($menus as $menu){
$cls = strtolower($menu['title']);
 ?>
        <li><a href="/<?php print $menu['href'];?>"><?php print $menu['title'];?>
		<span class="tui-icon i-<?php print $cls;?>"></span></a></li>
     	<?php }?>
      </ul>
        </div>
        <div class="tui-footer">
            <!--  t-ui-search -->
            <div class="t-ui-search">
            <?php print render($mobile['page']['search_form']); ?>

            </div>
            <!--  /t-ui-search -->
           
            <!--  tui-sn -->
            <div class="tui-sn"> 
                <a href="/blog/rss.xml" target="_blank"><span class="tui-icon i-rss"></span></a> 
                <a href="https://www.linkedin.com/company/thuraya" target="_blank"><span class="tui-icon i-in"></span></a> 
                <a href="http://www.youtube.com/user/ThurayaTelecom" target="_blank"><span class="tui-icon i-youtube"></span></a>
                <a href="https://www.facebook.com/ThurayaTelecommunications" target="_blank"><span class="tui-icon i-fb"></span></a> 
                <a href="https://twitter.com/ThurayaTelecom" target="_blank"><span class="tui-icon i-tweet"></span></a> 
            </div>
            <!--  /tui-sn -->
            <!-- tui-t-nav -->
            <div class="tui-t-nav">
<?php
print mobile_footer();
?>

            </div>
            <!-- /tui-t-nav -->
            <ul class="tui-copy-right">
            	<li><a href="/terms-of-use">Terms of Use</a>
                <a href="/privacy-policy">Privacy Policy</a></li>
                <li>Copyright © <?php print date('Y'); ?> Thuraya Telecommunications Company. All rights reserved.</li>
            </ul>
        </div>
    </div>
    <!-- /content -->
</div>
</div>
<!-- Main Menu  -->
<div class="tui-home-menu tui-main-menu" id="main_menu">

<ul id="main_items" style="position: relative; left: 0px;">
    <?php 
    $i=0;
	      // $img1 = $theme_url."images/arrow-r.png";

    foreach($parent_menus as $parent_menu){
        if($i==0){
            $class = 'active';
            $span = '';
        } else {
            $class = 'sub';
            $span = '</a>';
        }?>
    <?php  if($parent_menu['title'] == 'Home'){?>
    <li class="<?php print $class;?> menu_<?php echo $i ?>"><a href="<?php echo $base_url;?>"><?php print $parent_menu['title'].''.$span;?></a></li>
    <?php }else{?>
     <li class="<?php print $class;?> menu_<?php echo $i ?>"><a href="javascript:void(0)"><?php print $parent_menu['title'].''.$span;?></a></li>
    <?php }?>
        <?php $i++;
    }
    ?>
  </ul>
    <div class="tui-home-menu tui-sub" >
        <?php
				       $img2 = $theme_url."images/arrow-blue-mob.png";
		foreach($parent_menus as $parent_menu){
            if($parent_menu['title'] != 'Home'){?>
        <ul>
            <li><a href="javascript:void(0)"><span class="menu-tit"><img src="<?php print $img2;?>"/></span>
                    <span class="menu-tit-txt"><?php print $parent_menu['title'];?></span></a> </li>
            <li>
                <?php 
                $submenus = sectors_submenu_tree_all_data($parent_menu['href']);
                foreach($submenus as $submenu){?>
                <?php print $submenu;?>
                <?php } ?>
            </li>
        </ul>
        <?php } }?>
         </div>
</div>