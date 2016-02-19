<?php

/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */
?>
<div class="<?php print $classes; ?>">
  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
    <?php print $title; ?>
  <?php endif; ?>
  <?php print render($title_suffix); ?>
  <?php if ($header): ?>
    <div class="view-header">
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

  <?php if ($rows): ?>
    <div class="view-content">
    <?php 
	  //print $rows; 
	$terms = taxonomy_get_tree(2);
	foreach($terms as $term) {
		$prodIds = get_products_by_category($term->tid, 'faq');
		if(count($prodIds) > 0){
			$catClass = strtolower(str_replace(' ', '',$term->name));
	?>
		<div class="list_block">
		<h2><span class="ui-icon <?php print $catClass; ?>"></span><?php print $term->name; ?></h2>
	<?php
		for($i=0;$i<count($prodIds); $i++){
			$pnode = node_load($prodIds[$i]->entity_id);
			if($pnode->status == 1){
				if($i % 5 == 0 && $i != 0)
					print '</ul><ul>';
				if($i==0)
					print '<ul>';?>
				<li>
					<div><span>
					<span class="product_1"><a href="faqs/<?php print $pnode->nid; ?>"><img src="<?php print image_style_url('thumbnail', $pnode->field_product_image[$pnode->language][0]['uri']) ?>"></a></span>
					<span class="prod_title"><a href="faqs/<?php print $pnode->nid; ?>"><?php print $pnode->title; ?></a></span>
					</span></div>
				</li>
				<?php
				}//end of status if
			}//end of for loop
			print '</div>';
		}//end of products in a category --if
	}//end of category for loop
	?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>

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

</div>
<?php /* class view */ ?>