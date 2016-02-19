<div class="ui-page">
  <!--  Header Section -->
 <?php  print $mod_header;?>
 <!--  /Header Section -->
  <!--  Content Section -->
  <div class="ui-content">
     <div class="wtbaz">
  <div class="ui-page-content">
    <!-- Solutions  -->   
   <div class="main-container">	
  
    <!-- Solutions  -->   
         <div class="wheretobuy atozmc">
	<?php $breadcrumb=str_replace('href="//"','href="/"',$breadcrumb); ?>  
      <div class="breadcrumbs"><?php print $breadcrumb; ?></div>
    
      <div class="content">
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
  <!--  /Content Section -->
  <!-- Footer -->
<?php  print $mod_footer;?>
  <!-- /Footer -->
</div>
