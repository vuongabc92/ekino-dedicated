<?php //echo "<pre>"; print_r($node->field_brand_video); exit; ?>
<div class="brand generic">
  <div class="colums">
	<div class="col1">
	  <div class="in-container">
		<?php 
		$isVideo = count($node->field_brand_video[$node->language]);
		if(count($isVideo) > 0): ?>
		<div><?php print($node->field_brand_video[$node->language][0]["value"]);?></div>
		<?php endif; ?>
	  </div>
	</div>
	<div class="col2">
	  <div class="in-container">
		<h1><?php print $title; ?></h1>
		<?php if($node->field_short_description): ?>
		<h2><?php print($node->field_short_description[$node->language][0]["safe_value"]);?></h2>
		<?php endif; ?>	
		<div class="content">						
			<?php if($node->body): ?>
			<?php print($node->body[$node->language][0]["safe_value"]);?>
			<?php endif; ?>						
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
