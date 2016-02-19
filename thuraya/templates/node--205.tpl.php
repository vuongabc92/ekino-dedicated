<?php
/**
 * @file
 * Zen theme's implementation to display a node.
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $pubdate: Formatted date and time for when the node was published wrapped
 *   in a HTML5 time element.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 */
//echo "<pre>"; print_r($node->field_page_image); exit;
$pageName = drupal_lookup_path('alias',"node/".$node->nid);
$browDetails = getBrowser();
//print_r($browDetails); exit;
?>
<div class="careers generic">
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
		<div class="content">						
			<?php if($node->body): ?>
			<?php print($node->body[$node->language][0]["safe_value"]);?>
			<?php endif; ?>
			<div class="contact-us-form">
			<?php
				$formnode = node_load('907');					
				webform_node_view($formnode,'full');
				print theme_webform_view($formnode->content);
			?>                	
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
