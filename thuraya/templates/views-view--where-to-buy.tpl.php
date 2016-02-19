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
 global $base_url;
 
?>

<h1>Where to Buy</h1>
<?php //drupal_add_js(drupal_get_path('module', 'sectors') . '/newt.js'); ?>
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
      <?php print $exposed; ?>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>

  <?php
  if ($rows): ?>
  <?php print wheretobuy_scroller();?>
    <div class="map-section">
      <?php print $rows; ?>      
      <div id="wrb_no_results" style="display:none;">
<p> There are currently no Thuraya Service Partners in this location. Please <a target="_blank" href="<?php print $base_url.'/contact-us'?>">contact us</a> and we would be pleased to refer you to a Service Partner located closest to you. If you are interested in becoming a Thuraya Service Partner, please  	  	 
	  <a target="_blank" href="<?php print $base_url.'/become-a-partner'?>">contact us.</a></p>
</div>

	   <?php if ($footer): ?>
<div class="map-nav">
		  <?php $sales_url = $base_url.'/modal_forms/nojs/webform/53';?>

                <ul class="col-1">
                  <li><a href="<?php print $base_url.'/service-partners';?>">A-Z Listing <span class="ui-icon arrow">&nbsp;</span></a></li>
                  <li><a class="colorbox-inline" href="?width=610&amp;height=460&amp;inline=true#webformcontent">Sales Enquiry Form <span class="ui-icon arrow">&nbsp;</span></a></li>
				 
				  <li><a href="<?php print $base_url.'/pricing-plans'; ?>">Pricing<span class="ui-icon arrow">&nbsp;</span></a></li>
				  <li><a href="<?php print $base_url.'/become-a-partner'; ?>">Become a Partner<span class="ui-icon arrow">&nbsp;</span></a></li>
                </ul>
               
				<ul class="col-2">
	                  <li>Share it</li>
					  <li>
					  <a href="http://www.facebook.com/sharer.php?u=<?php print curPageURL();?>" target="_blank" class="ui-icon facebook"></a>
	 <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php print curPageURL();?>&amp;title=Thuraya" target="_blank" class="ui-icon in"></a>
	 <a href="http://www.twitter.com/home?status=<?php print "Thuraya-".curPageURL();?>" class="ui-icon twiter" target="_blank"></a> 
				</li>
				</ul>
             </div>
  <?php endif; ?>

<?php
  $block1 = module_invoke('block', 'block_view', 13);
  $b1_title = block_load('block', '13'); 
  $block2 = module_invoke('block', 'block_view', 14);
  $b2_title = block_load('block', '14'); 
  $block3 = module_invoke('block', 'block_view', 15);
  $b3_title = block_load('block', '15'); 
?>
<div class="content-bt">
              <ul>
                <li>
                  <div class="padding-rt">
                    <h2><span class="ui-icon gold"></span>
					<?php
					if(isset($b1_title->title)){ print $b1_title->title;}
					else {print 'Thuraya Gold Partners';}
					?>
					</h2>
                    <p>
					<?php print $block1['content'];?>
					</p>
                  </div>
                </li>
                <li>
                  <div class="padding-rt">
                    <h2><span class="ui-icon silver"></span>
					<?php
					if(isset($b2_title->title)){ print $b2_title->title;}
					else {print 'Thuraya Silver Partners';}
					?>
					</h2>
                    <p>			
					<?php print $block2['content'];?></p>
                  </div>
                </li>
                <li>
                  <div class="padding-rt">
                    <h2><span class="ui-icon bronze"></span>
					<?php
					if(isset($b3_title->title)){ print $b3_title->title;}
					else {print 'Thuraya Bronze Partners';}
					?>
					</h2>
                    <p><?php print $block3['content'];?></p>
                  </div>
                </li>
              </ul>
            </div>

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
<div style="display:none">
	<div id="webformcontent">
		<?php
			$formnode = node_load('53');					
			webform_node_view($formnode,'full');
			print theme_webform_view($formnode->content);
		?>
	</div>
</div>