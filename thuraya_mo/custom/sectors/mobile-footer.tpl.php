<?php $mob = getMobile();

if($mob!=1){?>
  <div class="ui-footer-bar">
    <div class="ui-flinks">		
		<div class="footer-container"><?php print render($mobile['page']['footer']);?></div>		
    </div>
  </div>
  <?php print render($mobile['page']['bottom']);  
 } else{
	 $full_menu_items = menu_tree_all_data('main-menu');
$parent_menus = common_menu_mobile($full_menu_items,0);
global $base_url, $user;
$theme_url = $base_url . '/sites/all/themes/thuraya/';

?>
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
        

</div><!--  end of /tui-content -->
</div><!--  /tui-page -->
  </div><!--  /main-dv-->


		<!-- Main Menu  -->
<div class="tui-home-menu tui-main-menu" id="main_menu">

<ul id="main_items" style="position: relative; left: 0px; margin-left:0px;">
    <?php 
    $i=0;
       //$img1 = $theme_url."images/arrow-r.png";

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
            <li><a href="javascript:void(0)"><span class="menu-tit">
			<img src="<?php print $img2;?>"/></span>
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
<?php }?>