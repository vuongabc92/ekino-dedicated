<?php
/**
 * @file
 * Customize the display of a complete webform.
 *
 * This file may be renamed "webform-form-[nid].tpl.php" to target a specific
 * webform on your site. Or you can leave it "webform-form.tpl.php" to affect
 * all webforms on your site.
 *
 * Available variables:
 * - $form: The complete form array.
 * - $nid: The node ID of the Webform.
 *
 * The $form array contains two main pieces:
 * - $form['submitted']: The main content of the user-created form.
 * - $form['details']: Internal information stored by Webform.
 */
?>
<script type="text/javascript">
/**function emptyVal(){	
	jQuery(":input").each(function() {	
		var frmValue = jQuery(this).attr('placeholder');		    
			
		});
}**/
</script>
<?php
//print_r($form['details']);
//echo '<pre>'; print_r($form['submitted']);echo '</pre>';
 
$node = node_load($nid);
?>
<div class="sales_enquiry marketing-promos">
<div class="col2">
<h1><?php echo $node->title;?></h1>
<div class="right-push">
<div class="cont-form">
<ul class="sales_enquiry_form">
<?php
print '<li>'.drupal_render($form['submitted']['name']).'</li>';
print '<li>'.drupal_render($form['submitted']['company']).'</li>';
print '<li>'.drupal_render($form['submitted']['email']).'</li>';
print '<li>'.drupal_render($form['submitted']['mobile']).'</li>';
print '<li>'.drupal_render($form['submitted']['city']).'</li>';?>
<li><div class="select_box">
<span class="select selectbox-bg" id="countrybox">Country</span>
<label for="country">Country</label>
<?php print drupal_render($form['submitted']['country']);?>

</div></li>
<?php
print '<li>'.drupal_render($form['submitted']['address']).'</li>';
print '<li>'.drupal_render($form['submitted']['postal_code']).'</li>';
print '<li>'.drupal_render($form['submitted']['would_you_like_to_receive_regular_product_updates_from_thuraya']).'</li>';
print '<li>'.drupal_render($form['submitted']['comments']).'</li>';
print '<li>'.drupal_render($form['captcha']).'</li>';
  // Print out the main part of the form.  // Feel free to break this up and move the pieces within the array.
  //print drupal_render($form['submitted']);

  // Always print out the entire $form. This renders the remaining pieces of the
  // form that haven't yet been rendered above.
  print '<li><div class="form-btns"><ul>';
  print '<li class="btn-res"><input type="reset" value="Reset" onclick="jQuery(\'#countrybox\').html(\'Country\');"></li><li class="submit-btn" onClick="emptyVal();">'.drupal_render_children($form).'</li>';
  print '</ul></div></li>';
?>
</ul>
</div>
</div>
</div>
</div>