<?php

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
 $browDetails = getBrowser();
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
				window.location = '<?php print $base_url; ?>'+'/press-list/'+$("#year").val()+$("#month").val();
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
                    <?php if($browDetails['version'] == "8.0" && $browDetails['name'] == "Internet Explorer"): ?>
                    <div><img src="<?php print file_create_url('sites/all/themes/thuraya/images/press-list1.png'); ?>" alt="Press"/></div>
				<?php else: ?>
					<div class="circleBg">
						<div class="circle-img" ><img src="<?php print file_create_url('sites/all/themes/thuraya/images/press-list1.png'); ?>" alt="Press"/></div>
					</div>
				<?php endif; ?>
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
                            <label for="year">Month</label>
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
