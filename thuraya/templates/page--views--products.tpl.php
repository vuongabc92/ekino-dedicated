<div class="ui-page">
  <!--  Header Section -->
<?php  print $mod_header;?>
  <!--  /Header Section -->
  <!--  Content Section -->
  <div class="ui-content">
  <div class="ui-page-content">
  <div class="main-container">
    <!--  Product Listing -->	
    <div class="main_content">
      <div class="breadcrumbs">
<?php $breadcrumb=str_replace('href="//"','href="/"',$breadcrumb); ?>
        <?php print $breadcrumb; ?>
      </div>
	  <?php //print get_brand_data(); ?>     
		<?php print render($title_suffix); ?>
		<?php print $messages; ?>
		<?php print render($tabs); ?>
		<?php print render($page['help']); ?>
		<?php if ($action_links): ?>
		<ul class="action-links"><?php print render($action_links); ?></ul>
		<?php endif; ?>
		<?php print render($page['content']); ?>
    </div>
    <!-- / Product Listing -->
    </div>
	</div>
  </div>
  <!--  /Content Section -->
  <!-- Footer -->
  <?php  print $mod_footer;?>
<!-- /Footer -->
</div>
