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
    <?php 
					$views_page = views_get_page_view();
					$album_array = $views_page->result;
					//echo "<pre>";print_r($album_array); exit;
				?>
				<div>
					<span class="hline"></span>
				<?php if(count($album_array) > 0): ?>
				<div class="photo">
				<?php
					for($i=0;$i<count($album_array);$i++){
						//echo ">>".$album_array[$i]->node_title."--".$album_array[$i]->nid;
						$album_node = node_load($album_array[$i]->nid);
						$images_array = $album_node->field_gallery_image;
						if(count($images_array) > 0){
							$images_array = $images_array['und'][0];
						}
						//echo "<pre>";print_r($images_array); exit;
						
						if($i%3 == 0){
							if($i > 0){
								print '</ul>';
								print '<ul>';
							} else {
								print '<ul>';
							}
						}						
					?>
					<li><a title="<?php print $album_array[$i]->node_title; ?>" href="/gallery-images/<?php print $album_array[$i]->nid; ?>"><img src="<?php print image_style_url('gallery', $images_array['uri']); ?>" alt="<?php print $album_array[$i]->node_title; ?>" /></a><p class="video-desc"><a title="<?php print $album_array[$i]->node_title; ?>" href="/gallery-images/<?php print $album_array[$i]->nid; ?>"><?php print $album_array[$i]->node_title; ?></a></p></li>
					<?php } ?>
				</div>
				</div>
				<?php else: ?>
				No Albums 				
				<?php endif; ?>
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

</div><?php /* class view */ ?>