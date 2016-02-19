<?php
/**
 * @file
 * Zen theme's implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $secondary_menu_heading: The title of the menu used by the secondary links.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
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
 $args = arg();
 //print_r($args[1]); exit;
 $month = ""; $year = "";
 if(isset($args)) {
	if(count($args) == 2) {
		$yearMon = $args[1];
		$year = substr($yearMon, 0, 4);
		$month = substr($yearMon, 4, 2);
	}
 }
 //echo "mon=".$month." year=".$year; //exit;
 global $base_url;
?>
<script type="text/javascript">
(function ($) {
    $(document).ready(function(){
		$("#year_txt").html($("#year").find("option:selected").text());
		$("#month_txt").html($("#month").find("option:selected").text());
		$("#year").change(function(){									
			text = $(this).find("option:selected").text();
			$("#year_txt").html(text);
		});
		$("#month").change(function(){									
			text = $(this).find("option:selected").text();
			$("#month_txt").html(text);
		});
		$("#Search").click(function(){
			if($("#month").val()==0 && $("#year").val()==0){
				alert("Please select month and year");
				return;
			}
			if($("#month").val()==0){
				alert("Please select month");
				return;
			}
			if($("#year").val()==0){
				alert("Please select year");
				return;
			}
			if($("#year").val()!=0 && $("#month").val()!=0){
				window.location = '<?php print $base_url; ?>'+'/blog/'+$("#year").val()+$("#month").val();
			}
		});
    });
})(jQuery); 
</script>
<div class="ui-page">
  <!--  Header Section -->
 <?php  print $mod_header;?>
 <!--  /Header Section -->
  <!--  Content Section -->
  <div class="ui-content">
  <div class="press-list-bg">
  <div class="ui-page-content">
   <div class="main-container">
	<!--  Product Listing -->
	<div class="solutions-details">
		<div class="breadcrumbs">
			<?php $breadcrumb=str_replace('href="//"','href="/"',$breadcrumb); ?>
			<?php print $breadcrumb; ?>
		</div>
		<div class="press-list">
              <div class="colums">
                <div class="col1">
                  <div class="in-container">
                    <div><img src="<?php print file_create_url('sites/all/themes/thuraya/images/press-list-img.png'); ?>" alt="Press"/></div>
                     <div class="left-menu"><?php print render($page['about_leftmenu']);  ?></div>
                  </div>
                </div>
                <div class="col2">
                  <div class="in-container">
                    <?php if ($title): ?>
						<h1><?php print $title; ?></h1>
					<?php endif; ?>
                    <!--  Prese news -->
						<?php print render($title_suffix); ?>
						<?php print $messages; ?>
						<?php print render($tabs); ?>
						<?php print render($page['help']); ?>
						<?php if ($action_links): ?>
						<ul class="action-links"><?php print render($action_links); ?></ul>
						<?php endif; ?>
						<?php print render($page['content']); ?>
                    <!--  Prese news -->
                  </div>
                </div>
                <div class="col3">
                  <div class="in-container">
                    <!--  Right Navigation -->
                    <div class="date-filters press">
                      <h4 class="new-bold">Date Filters</h4>
                      <ul>
                        <li>
                          <div class="select_box"> <span id="month_txt" class="select selectbox-bg">Month</span>
                            <label for="month">Month</label>
                            <select name="month" class="styled" id="month">
                              <option value="0">Month</option>
							  <?php 
							  $monthsArr = array("01"=>"Jan", "02"=>"Feb", "03"=>"Mar", "04"=>"Apr", "05"=>"May", "06"=>"Jun", "07"=>"Jul", "08"=>"Aug", "09"=>"Sep", "10"=>"Oct", "11"=>"Nov", "12"=>"Dec");
							  foreach($monthsArr as $key => $value) { 
								if($month == $key){
							  ?>
                              <option value="<?php print $key; ?>" selected="selected"><?php print $value; ?></option>
							  <?php } else { ?>
							  <option value="<?php print $key; ?>" ><?php print $value; ?></option>
							  <?php } ?>
							  <?php } ?>
                            </select>
                          </div>
                        </li>
                        <li>
                          <div class="select_box"> <span id="year_txt" class="select selectbox-bg">Year</span>
                            <label for="year">Year</label>
                            <select name="year" class="styled" id="year">
                              <option value="0">Year</option>
                              <?php for($i=date('Y')-5; $i<=date('Y'); $i++) { ?>
							  <?php if($year == $i){ ?>
							  <option value="<?php print $i; ?>" selected="selected"><?php print $i; ?></option>
							  <?php } else { ?>
							  <option value="<?php print $i; ?>" ><?php print $i; ?></option>
							  <?php } ?>
							  <?php } ?>
                            </select>
                          </div>
                        </li>
                        <li>
                          <input class="search ui-icon" value="Search" id="Search" type="button"  />
                        </li>
                      </ul>
                    </div>
                    <div class="tag-cloud press">
                      <h4 class="new-bold">Tag Cloud</h4>
                      <ul class="cloud">
					  <li class="cloudli">
						<?php echo views_embed_view('tag_cloud', $display_id = 'block_tagcloud'); ?>
					  </li>
                      </ul>
                    </div>
                    <div class="media-contact press">
					<?php print render($page['media_contact']);?>
					<a class="anchor new-medium colorbox-inline" href="?width=610&amp;height=460&amp;inline=true#webformcontent"><span>Contact</span><span class="ui-icon next"></span></a>
                  </div>
                </div>
              </div>
            </div>
	</div>
	</div>
   </div>
    <!-- /Solutions -->
    </div>
	</div>
  </div>
  <!--  /Content Section -->
  <!-- Footer -->
 <?php  print $mod_footer;?>
 <!-- /Footer -->
</div>
<div style="display:none">
	<div id="webformcontent">
		<?php
			$formnode = node_load('837');					
			webform_node_view($formnode,'full');
			print theme_webform_view($formnode->content);
		?>
	</div>
</div>
