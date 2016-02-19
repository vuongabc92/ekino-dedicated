<div class="ui-page">
  <!--  Header Section -->
  <?php  print $mod_header;?>

  <!--  /Header Section -->
  <!--  Content Section -->
  <div class="ui-content">
  <div class="press-list-bg">
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
      <?php //print render($page['content']); ?> 
      <!-- node content started  --> 
      <div class="careers generic">
		  <div class="colums">
			<div class="col2" style="width:100%;">
			  <div class="in-container">
				<h1><?php print $title; ?></h1>
				<?php if($node->field_short_description): ?>
				<h2><?php print($node->field_short_description[$node->language][0]["safe_value"]);?></h2>
				<?php endif; ?>	
				<div class="content">									
					<?php if($node->body): ?>
					<?php print($node->body[$node->language][0]["safe_value"]);?>
					<?php endif; ?>	
					<div class="genericNodeImage">
					<?php if($node->field_page_image):?>					
					<?php $imgPath = $node->field_page_image[$node->language][0]["uri"];
						  $alt     = $node->field_page_image[$node->language][0]["alt"]; 
						  $width   = $node->field_page_image[$node->language][0]["width"];
						  $height  = $node->field_page_image[$node->language][0]["height"];?>			
						<img src="<?php print image_style_url('generic_page_images', $imgPath); ?>"  value="<?php print $alt;?>" width="<?php print $width; ?>" height="<?php print $height; ?>" >
					<?php endif;?>	
					</div>
				</div>
				<div class="sn-links">
						<ul class="ul-sn">
						<li class="new-medium">Share it</li>
						<li> 
							<a href="http://www.facebook.com/sharer.php?u=<?php print curPageURL();?>" target="_blank" class="ui-icon facebook"></a>
							<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php print curPageURL();?>&amp;title=<?php print urlencode($node->title);?>&summary=<?php echo getNodeTeaser($node);?>" target="_blank" class="ui-icon in"></a>
							<a href="http://www.twitter.com/home?status=<?php print "Thuraya-".curPageURL();?>" class="ui-icon twiter" target="_blank"></a>
						</li>
					  </ul>
				</div>
			  </div>
			</div>                
		  </div>		  	
	 </div>
      <!-- node content ended --> 
                       
   </div>
  </div>
  </div>
  </div>
  <!--  /Content Section -->
  <!-- Footer -->
  <?php  print $mod_footer;?>
<!-- /Footer -->
</div>
