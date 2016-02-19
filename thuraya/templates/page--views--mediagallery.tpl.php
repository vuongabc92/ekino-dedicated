<?php
$args = arg();
//print_r($args[1]); exit;
$albumId = $args[1];
$albumName = "";
if(!empty($albumId)){
	$alNode = node_load($albumId);
	$albumName = $alNode->title;
}
?>
<script type="text/javascript">
(function ($) {
    $(document).ready(function(){
		$('#dhtml_menu-756').addClass('active');
	});
})(jQuery); 
</script>
<div class="ui-page">
  <!--  Header Section -->
  <?php  print $mod_header;?>
<!--  /Header Section -->
  <!--  Content Section -->
  <div class="ui-content">
  <div class="media-solutions-bg">
  <div class="ui-page-content">
   <div class="main-container">
	<div class="solutions-details">
		<div class="breadcrumbs">
<?php $breadcrumb=str_replace('href="//"','href="/"',$breadcrumb); ?>
			<?php print $breadcrumb; ?>
		</div>
		<div class="careers mgallery">
		  <div class="colums">
			<div class="col1">
			  <div class="in-container">
				<div><img src="<?php print file_create_url('sites/all/themes/thuraya/images/albums-list-img.png'); ?>" alt="Media Gallery"/></div>
				<div class="left-menu">
				<div class="left-menu"><?php print render($page['presslist_leftmenu']);  ?></div>
				</div>
			  </div>
			</div>
			<div class="col2">
			  <div class="media-gallery in-container">
				<?php if ($albumName): ?>
					<h1><?php print $albumName; ?></h1>
				<?php endif; ?>
				<?php if ($action_links): ?>
					<ul class="action-links"><?php print render($action_links); ?></ul>
				<?php endif; ?>
				<?php 
					$views_page = views_get_page_view();
					$videos_array = $views_page->result[0]->_field_data['nid']['entity']->field_videos['und'];
					$video_desc_array = $views_page->result[0]->_field_data['nid']['entity']->field_video_description['und'];
					//echo "<pre> >>"; print_r($views_page->result[0]); exit;
					//echo "<pre> >>"; print_r($video_desc_array); exit;
					
					if(count($videos_array) > 0):
					$files = file_load_multiple($videos_array);
					$i = 0;
					//print_r($files); exit;
				?>
				<div>
					<span class="hline">Videos</span>
					<div class="video">
					<?php foreach($files as $key => $value): 
						$url = $value->uri;
						$url = str_replace("youtube://v/", "", $url);
						if($i%3 == 0){
							if($i > 0){
								print '</ul>';
								print '<ul>';
							} else {
								print '<ul>';
							}
						}	
						$description = substr($video_desc_array[$i++]['value'], 0, 96);						
					?>
					<li><a class="colorbox-load" title="<?php print $description; ?>" href="http://www.youtube.com/v/<?php print $url; ?>?fs=1&amp;width=640&amp;height=430&amp;hl=en_US1&amp;iframe=true"><img src="http://i2.ytimg.com/vi/<?php print $url; ?>/default.jpg" alt="<?php print $url; ?>" /></a><p class="video-desc"><?php print $description; ?></p></li>
					<?php endforeach;?>
					</div>
				</div>
				<?php endif; ?>
				<div>
				<span class="hline">Photos</span>
				<?php print render($title_suffix); ?>
				<?php print $messages; ?>
				<?php print render($tabs); ?>
				<?php print render($page['help']); ?>
				<?php if ($action_links): ?>
				<ul class="action-links"><?php print render($action_links); ?></ul>
				<?php endif; ?>
				<?php print render($page['content']); ?>
				</div>
			  </div>
			  <div class="sn-links">
				<a class="anchor new-medium" href="javascript:history.go(-1);"><span class="ui-icon prev"></span><span>Back</span></a>
			  </div>
			</div>                
		  </div>
		</div>
	</div>
   </div>
    <!-- /Solutions -->
    </div>
  </div>
  <!--  /Content Section -->
  </div>
  <!-- Footer -->
  <?php  print $mod_footer;?>
<!-- /Footer -->
</div>
