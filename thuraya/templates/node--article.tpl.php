<?php
//echo "<pre>"; print_r($node); exit;
echo '&nbsp;';
$args = arg();
//print_r($args[1]); exit;
$month = ""; $year = "";
if(isset($args)) {
	if(count($args) == 2) {
		$yearMon = $args[1];
		$year = substr($yearMon, 0, 4);
		$month = substr($yearMon, 4, 2);
	}
}

$browDetails = getBrowser();
?>
<script type="text/javascript">
(function ($) {
    $(document).ready(function(){
		$('#dhtml_menu-759').addClass('active');
	});
})(jQuery); 
</script>
<div class="press-list">
  <div class="colums artical">
	<div class="col1">
	  <div class="in-container">
		<?php 
			$noOfImages = count($node->field_image[$node->language]);
			if($noOfImages > 0):
			if($browDetails['version'] == "8.0" && $browDetails['name'] == "Internet Explorer"):
		?>
		<div><img src="<?php print file_create_url($node->field_image[$node->language][0]['uri']) ?>" alt="Press"/></div>
		<?php else: ?>
		<div class="circleBg">
		<div class="circle-img" ><img src="<?php print file_create_url($node->field_image[$node->language][0]['uri']) ?>" alt="Press"/></div>
		</div>
		<?php endif; ?>
		<?php endif; ?>
		<?php print render(block_get_blocks_by_region('presslist_leftmenu')); ?>
	  </div>
	</div>
	<div class="col2">
	  <div class="in-container">
		<?php if ($title): ?>
			<h1><?php print $title; ?></h1>
		<?php endif; ?>
		<?php if ($node->field_short_description): ?>
		<h2><?php print $node->field_short_description[$node->language][0]['safe_value']; ?></h2>
		<?php endif; ?>
		<!--  Prese news -->
		<?php if($node->body): ?>
		<?php print($node->body[$node->language][0]["safe_value"]);?>
		<?php endif; ?>
		<!--  Prese news -->
		<?php 
			$downloadFiles = count($node->field_downloads);
			if($downloadFiles > 0):
		?>
		<div class="pd-footer">
		  <ul>
			<?php for($i=0; $i<$downloadFiles;$i++) {
				$fileDesc = "Download ".($i+1); ?>
			<li><a target="_blank" href="<?php print file_create_url($node->field_downloads[$node->language][$i]['uri']); ?>" class="anchor"><span><?php print $fileDesc; ?></span><span class="ui-icon download"></span></a></li>
			<?php } ?>
		  </ul>
		</div>
		<?php endif; ?>
		<!-- SN -->		
		<div class="sn-links"><a href="javascript:history.go(-1);" class="anchor new-medium" ><span class="ui-icon prev"></span><span>Back</span></a>
		  <ul class="ul-sn">
			<li class="new-medium">Share it</li>			
			<li>					
				<a href="http://www.facebook.com/sharer.php?u=<?php print curPageURL();?>" target="_blank" class="ui-icon facebook"></a>
				<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php print curPageURL();?>&amp;title=<?php print urlencode($node->title);?>&summary=<?php echo getNodeTeaser($node);?>&source=" target="_blank" class="ui-icon in"></a>
				<a href="http://www.twitter.com/home?status=<?php print "Thuraya-".curPageURL();?>" class="ui-icon twiter" target="_blank"></a>
			</li>
		  </ul>
		</div>
		<!-- /SN -->
	  </div>
	</div>
	<div class="col3">
	  <div class="in-container" id="home-tag">
		<!--  Right Navigation -->
		<div class="tag-cloud press">
		  <h4 class="new-bold">Tag Cloud</h4>
		  <ul class="cloud">
		  <li class="cloudli">
			<?php echo views_embed_view('tag_cloud', $display_id = 'block_tagcloud'); ?>
		  </li> 
		  </ul>
		</div>
		<div class="media-contact press">
		<?php print render(block_get_blocks_by_region('media_contact')); ?>
		  <a class="anchor new-medium colorbox-inline" href="?width=610&amp;height=460&amp;inline=true#webformcontent"><span>Contact</span><span class="ui-icon next"></span></a></div>
		<!-- / Right Navigation -->
	  </div>
	</div>
  </div>
</div>
<div style="display:none">
	<div id="webformcontent">
		<?php
			$formnode = node_load('837');					
			webform_node_view($formnode,'full');
			print theme_webform_view($formnode->content);
		?>
	</div>
</div>