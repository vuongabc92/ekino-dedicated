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
				 <div class="left-menu"><?php print render($page['about_leftmenu']);  ?></div>
			  </div>
			</div>
			<div class="col2">
			  <div class="media-gallery in-container">
				<?php if ($title): ?>
					<h1><?php print $title; ?></h1>
				<?php endif; ?>
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
