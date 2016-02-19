<?php
$args = arg();
$prodId = "";
if(isset($args)) {
	if(count($args) == 2) {
		$prodId = $args[1];
	}
}
?>
<div class="<?php print $classes; ?>">
  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
    <?php print $title; ?>
  <?php endif; ?>
  <?php print render($title_suffix); ?>
  <?php if ($header): ?>
	<div class="head-top">
		<?php print $header; ?>
	</div>
  <?php endif; ?>

  <?php if ($exposed): ?>
    <div class="view-filters">
      <?php print $exposed; ?>
    </div>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>

    <div class="view-content">
	  <div class="colums">
		<div class="col1">
		  <div class="in-container">
		  <?php if(!empty($prodId)): ?>
			<div class="pro-img">
				<div>
				<?php
					$pageName = drupal_lookup_path('alias',"node/".$prodId);
					$prodnode = node_load($prodId); 
					$noOfImages = count($prodnode->field_product_image[$prodnode->language]); 
					if($noOfImages > 0):
				?>
				<img src="<?php print file_create_url($prodnode->field_product_image[$prodnode->language][0]['uri']) ?>" alt="Upgrades"/>
				<?php endif; ?>
				</div>
				<div class="r-more">
				<a href="/<?php print $pageName; ?>"><span>Product page </span><span class="ui-icon plus"></span></a>
				</div>
			</div>
			<?php endif; ?>
			<div  class="faq-list">
			  <ul>
			  <?php 
				$terms = taxonomy_get_tree(2);
				//print_r($terms);
				$cnt = 0;
				foreach($terms as $term) {
				$prodIds = get_products_by_category($term->tid, 'software_upgrades');
				if(count($prodIds) > 0) {
					$catClass = strtolower(str_replace(' ', '',$term->name));
					$clsName = ""; $iconName = "plus-add"; $lastClass = "";
					for($i=0;$i<count($prodIds); $i++){
						$pid[] = $prodIds[$i]->entity_id;
						if(in_array($prodId, $pid)){
							$clsName = "show_div";
							$iconName = "minus";
						}
						unset($pid);
					}
					$cnt++; //echo $cnt.'-'.count($terms);
					if($cnt == count($terms))
						$lastClass = "last";
				?>
				<li>
				  <h3 class="clear <?php print $lastClass; ?>"><a href="javascript:void(0)"><span class="ui-icon <?php print $catClass;?> icon-l"></span><span class="text"><?php print $term->name; ?></span><span class="ui-icon <?php print $iconName; ?> icon-r"></span></a></h3>							
					<div class="left-menu <?php print $clsName; ?> clear">
					  <ul>
					  <?php
						for($i=0;$i<count($prodIds); $i++){
							$actClass = "";
							$pnode = node_load($prodIds[$i]->entity_id);
							//print_r($pnode); exit;
							if($pnode->status == 1){
							if($prodId == $prodIds[$i]->entity_id)
								$actClass = "class='active'";
						?>
						<li <?php print $actClass; ?>><a href="/product_upgrades/<?php print $pnode->nid; ?>"><?php print $pnode->title;?><span class="ui-icon left-arrow"></span></a></li>
					<?php
						}//end of if
					}//end of for
					  ?>
					  </ul>
					</div>
				</li>						
				<?php
				}
				}
			  ?>
				</ul>
			</div>
		  </div>
		</div>
		<div class="col2 cmsdata">
		<?php if ($rows): ?>
			<?php print $rows; ?>
		<?php elseif ($empty): ?>
		<div class="view-empty">
		  <?php print $empty; ?>
		</div>
	    <?php endif; ?>
		</div>
	</div>
	</div>
  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

  <?php if ($attachment_after): ?>
    <div class="attachment attachment-after">
      <?php print $attachment_after; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <?php print $more; ?>
  <?php endif; ?>

  <?php if ($footer): ?>
    <div class="view-footer">
      <?php print $footer; ?>
    </div>
  <?php endif; ?>

  <?php if ($feed_icon): ?>
    <div class="feed-icon">
      <?php print $feed_icon; ?>
    </div>
  <?php endif; ?>

</div><?php /* class view */ ?>