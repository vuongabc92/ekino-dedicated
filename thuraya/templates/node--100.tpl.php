<?php
//echo "<pre>"; print_r($node->field_page_image); exit;
drupal_add_js(drupal_get_path('theme', 'thuraya') . '/js/jquery.carouFredSel.js');
drupal_add_js(drupal_get_path('theme', 'thuraya') . '/js/milestone.js');
$browDetails = getBrowser();
?>
<div class="careers milestone">
  <div class="colums">
	<div class="col1">
	  <div class="in-container">
		<?php 
			$noOfImages = count($node->field_page_image[$node->language]);
			if($noOfImages > 0):
			if($browDetails['version'] == "8.0" && $browDetails['name'] == "Internet Explorer"):
		?>
		<div><img src="<?php print image_style_url('generic_page_images', $node->field_page_image[$node->language][0]['uri']); ?>" alt="<?php print $node->field_page_image[$node->language][0]['alt']; ?>"/></div>
		<?php else: ?>
		<div class="circleBg">
			<div class="circle-img" ><img src="<?php print image_style_url('generic_page_images', $node->field_page_image[$node->language][0]['uri']); ?>" alt="<?php print $node->field_page_image[$node->language][0]['alt']; ?>"/></div>
		</div>
		<?php endif; ?>
		<?php endif; ?>
		<div class="left-menu"><?php print render(block_get_blocks_by_region('about_leftmenu')); ?></div>
	  </div>
	</div>
	<div class="col2">
		<div class="in-container">
		<h1><?php print $title; ?></h1>
		<?php if($node->field_short_description): ?>
		<h2><?php print($node->field_short_description[$node->language][0]["safe_value"]);?></h2>
		<?php endif; ?>
	  <div class="slider-container">                    
		<div class="pager-section">
		  <div class="clblock">
            <div class="carousel-slide">
			<ul id="mpager">
			<?php for($i=1997;$i < date('Y'); $i++) { 
				$active = "";
				if($i==1997)
					$active = "class='active'";
			?>
			  <li <?php print $active; ?>><?php print $i; ?></li>
			<?php } ?>
			</ul>
			<div class="clearfix"></div>
			<a id="prev2" class="ui-icon prev" href="#">&lt;</a>
            <a id="next2" class="ui-icon next" href="#">&gt;</a>
		  </div>
		  </div>
		</div>
	  </div>
	  <div id="year-content"></div>
		<div class="sn-links">
		  <ul class="ul-sn">
			<li class="new-medium">Share it</li>
			<li> <a href="#" class="ui-icon facebook">&nbsp;</a> <a href="#" class="ui-icon inn">&nbsp;</a> <a href="#" class="ui-icon twit">&nbsp;</a> </li>
		  </ul>
		</div>
		</div>
	</div>              
  </div>
</div>
