<?php
/**
 * Regions:
 * - $page['header']: Items for the header region.
 * - $page['navigation']: Items for the navigation region, below the main menu (if any).
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['footer']: Items for the footer region.
 * - $page['bottom']: Items to appear at the bottom of the page below the footer.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see zen_preprocess_page()
 * @see template_process()
 */
//echo "<pre>"; print_r($node); exit;
?>
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
		<?php print render($page['share_icons']);?>
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
          <?php  if ($logo): ?>
      <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" /></a>
    <?php endif; ?>
      </div>
      <div class="main-nav">
        <select class="device-menu" >
        	<option>Home</option>
            <option>About Us</option>
            <option>Solutions</option>
            <option>Products</option>
            <option>Support</option>
        </select>
         <?php print render($page['main_menu']); ?>
      </div>
    </div>
    <!--  /Logo and Main Navigation -->
  </div>
  <!--  /Header Section -->
  <!--  Content Section -->
  <div class="ui-content">
  <div class="media-solutions">
  <div class="ui-page-content">
    <!-- Solutions  -->   
   <div class="main-container">	
    <!-- Solutions  -->   
   <div class="solutions-details">
		<div class="breadcrumbs">
			<?php $breadcrumb=str_replace('href="//"','href="/"',$breadcrumb); ?>
			<?php print $breadcrumb; ?>
		</div>
		<div class="gsm">
			<h1>Covered map</h1>
			<p>Choose your technology below.</p>
			<div class="content1">
				<div class="gsm-map">
					<div class="tab-content">
						<ul>
							<li><span>GSM</span><a href="javascript:void(0)" class="active">&nbsp;</a></li>
							<li class="border"></li>
							<li><span class="left-align">Satellite</span><a href="javascript:void(0)" class="inactive">&nbsp;</a></li>
						</ul>
						<div class="services">
							<p><span class="greenbox"></span>Service Available</p>
							<p><span class="greybox"></span>Service in Process</p>
						</div>
					</div>
				</div>
				<div class="map-sec-column">
					<div class="column1">
						<h2>Thuraya Live Roaming Partners</h2>
						<p>Choose your country below lorem ipsum dolor.</p>
						<div class="select_box"> <span id="region-sel" class="select selectbox-bg">Region/Country</span>
						  <label for="reg-sel">Region/Country</label>
						  <select name="reg-sel" class="styled" id="reg-sel">
							<option value="Region/Country" selected="selected">Region/Country</option>
							<?php
							$countries = get_countries_list();
							//print_r($countries);exit;
							foreach ($countries as $key => $cname){
							?>
							<option value="<?php print $key; ?>"><?php print $cname; ?></option>
							<?php } ?>
						  </select>
						</div>
					</div>
					<div class="column2" id="partners-list">
						<div style="display:none;top:20px;text-align: center;" id="loader">
						<img src='<?php print file_create_url("sites/all/themes/thuraya/images/ajax-loader.gif"); ?>'>
				        </div>
					</div>
				</div>
			 </div>
			 <div class="content2">
				<div class="sat-map">
					<div class="tab-content">
						<ul>
							<li><span>GSM</span><a href="javascript:void(0)" class="inactive inactive1">&nbsp;</a></li>
							<li class="border"></li>
							<li><span class="left-align">Satellite</span><a href="javascript:void(0)" class="active">&nbsp;</a></li>
						</ul>
						<div class="services">
							<p><span class="darkbluebox"></span>Service Available</p>
							<p><span class="bluebox"></span>Service in Process</p>
						</div>
					</div>
				</div>
			 </div>
		</div>            
    </div>
	</div>
   </div>
  </div>
  </div>
  <!--  /Content Section -->
  <!-- Footer -->
  <div class="ui-footer-bar">
    <div class="ui-flinks">
		
      <?php //print render($page['partner_login']);?>         
		<div class="footer-container"><?php print render($page['footer']);?></div>		
    </div>
  </div>
  <?php print render($page['bottom']);  ?>
  <!-- /Footer -->
</div>
