<div class="ui-page">
  <!--  Header Section -->
 <?php  print $mod_header;?>
 <!--  /Header Section -->
  <!--  Content Section -->
  <div class="ui-content">
  <div class="ui-page-content">
    <!-- Solutions  -->
   <div class="main-container">
	
	<div class="solutions-1">
		<div class="breadcrumbs">
			<?php $breadcrumb=str_replace('href="//"','href="/"',$breadcrumb); ?>
			<?php print $breadcrumb; ?>
		</div>
			<div class="content">	
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
    <!-- /Solutions -->
    </div>
  </div>
  <!--  /Content Section -->
  <!-- Footer -->
 <?php  print $mod_footer;?>
 <!-- /Footer -->
</div>
</body>
</html>
