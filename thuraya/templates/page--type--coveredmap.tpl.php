<div class="ui-page">
  <!--  Header Section -->
  <?php  print $mod_header;?>
  <!--  /Header Section -->
  <!--  Content Section -->
  <div class="ui-content">
  <div>
  <div class="ui-page-content">
    <!-- Solutions  -->   
   <div class="main-container">	
  
    <!-- Solutions  -->   
   
   <?php print render($page['highlighted']); ?>
	<?php $breadcrumb=str_replace('href="//"','href="/"',$breadcrumb); ?>
      <div class="breadcrumbs"><?php print $breadcrumb; ?></div>
      
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
  <!--  /Content Section -->
  <!-- Footer -->
<?php  print $mod_footer;?>
  <!-- /Footer -->
</div>
