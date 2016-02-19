<?php
global $base_url;
/**
 * @file
 * This template handles the layout of the views exposed filter form.
 *
 * Variables available:
 * - $widgets: An array of exposed form widgets. Each widget contains:
 * - $widget->label: The visible label to print. May be optional.
 * - $widget->operator: The operator for the widget. May be optional.
 * - $widget->widget: The widget itself.
 * - $sort_by: The select box to sort the view using an exposed form.
 * - $sort_order: The select box with the ASC, DESC options to define order. May be optional.
 * - $items_per_page: The select box with the available items per page. May be optional.
 * - $offset: A textfield to define the offset of the view. May be optional.
 * - $reset_button: A button to reset the exposed filter applied. May be optional.
 * - $button: The submit button for the form.
 *
 * @ingroup views_templates
 */

?>
<h1>A - Z Listing</h1>
<div class="service-link"><a href="<?php print $base_url; ?>/partners">Service Partners</a></div>
<div class="retailers-link service-selected"><a href="<?php print $base_url; ?>/retailer-partners">Retailers</a></div>
    <div id="search-area">

    <div class="col-1">
        <ul>

    <?php
	$i=1;
	foreach ($widgets as $id => $widget): ?>
      
       <li>
			<?php
			if($i==1){$lab = 'Region/Country';$id_val = 'regionbox';}
			if($i==2){$lab = 'Products';$id_val = 'productsbox';}
			if($i!='3'){?>
		   <div class="select_box">
		   <span id="<?php print $id_val;?>" class="select selectbox-bg"><?php print $lab;?></span>
		   		  <label><?php print $lab;?></label>
			</div>
		  <?php  } ?>
          <?php print $widget->widget; ?>
		  
   </li>
        
    <?php
	$i++;
	endforeach; ?>
            </ul>
            </div>

    <div class="col-2">
        <?php print $button; ?>
    <?php if (!empty($reset_button)): ?>
    
        <?php print $reset_button; ?>
    
    <?php endif; ?>
  
</div>
    </div>
