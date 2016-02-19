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

      <?php //print $attachment_before;	?>


    <div class="map-section">
     <div class="azlist-contaier">
     <div class="azpager">
	 <ul>
	 <?php 
	 $class='';
	 $letters = range('a','z');
	 foreach($letters as $letter){
		 if(arg(1) == $letter){
			 $class='active';
		 }
		 if(arg(1) == '' && $letter == 'a'){
			 $class='active';
		 }
		 print '<li class="'.$class.'"><a href="'.$base_url.'/retailer-partners/'.$letter.'">'.$letter.'</a></li>';
		 $class='';
	 }
	 ?>

	 </ul>
       </div>

  <div class="azlist">
      <?php if(!empty($rows)){print $rows; }else{?>
	  
	  <div class="servicerow"><p> There are currently no Thuraya Retailer Partners in this location. Please <a target="_blank" href="<?php print $base_url.'/contact-us'?>">contact us</a> and we would be pleased to refer to a Retailer Partner located closest to you. If you are interested in becoming a Thuraya Retailer Partner, please contact Thuraya Customer Care at <a href="mailto:customer.care@thuraya.com" target="_top">customer.care@thuraya.com</a>.</p>
	  </div>	  
	  <?php }?>
    </div>
	</div>
   
	<div class="map-nav">
                <ul class="col-1">
                  <li><a href="<?php print $base_url.'/retailer-where-to-buy';?>">Retailers Map <span class="ui-icon arrow">&nbsp;</span></a></li>
		  <?php $sales_url = $base_url.'/modal_forms/nojs/webform/53';?>
                  <li><a class="colorbox-inline" href="?width=610&amp;height=460&amp;inline=true#webformcontent">Sales Enquiry Form <span class="ui-icon arrow">&nbsp;</span></a></li>
                </ul>
                 
				
				</div>
<?php
  $block1 = module_invoke('block', 'block_view', 13);
  $b1_title = block_load('block', '13'); 
  $block2 = module_invoke('block', 'block_view', 14);
  $b2_title = block_load('block', '14'); 
  $block3 = module_invoke('block', 'block_view', 15);
  $b3_title = block_load('block', '15'); 
?>
<div class="content-bt">
   <?php print views_embed_view('retailer_banner','block'); ?>
</div>

 </div>
 <div style="display:none">
	<div id="webformcontent">
		<?php
			$formnode = node_load('53');					
			webform_node_view($formnode,'full');
			print theme_webform_view($formnode->content);
		?>
	</div>
</div>