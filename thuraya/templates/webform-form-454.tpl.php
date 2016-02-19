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
<?php
//echo '<pre>'; print_r($form['submitted']);echo '</pre>';
?>
	<ul id="bussPropForm" class="enquiry-form" >
		<li>
		<div class="select_box"> <span id="productspriceplan2" class="select selectbox-bg">Products </span>
		  <label for="edit-submitted-form2-products">Products</label>
		  <?php print drupal_render($form['submitted']['form2_products']);?>
		</div>
		</li>
		<li><?php print drupal_render($form['submitted']['nature_of_enquiry']);?></li>
		<li><?php print drupal_render($form['submitted']['comments']);?></li>
		<li class="textbox-small"><?php print drupal_render($form['submitted']['organization_name']);?></li>
		<li class="postal-small"><?php print drupal_render($form['submitted']['customer_name']);?></li>
		<li><?php print drupal_render($form['submitted']['email']);?></li>
		<li><?php print drupal_render($form['submitted']['mobile']);?></li>
		<li><?php print drupal_render($form['submitted']['thuraya_phone']);?></li>
		<li><?php print drupal_render($form['submitted']['address']);?></li>
		<li class="textbox-small"><?php print drupal_render($form['submitted']['city']);?></li>
		<li class="postal-small"><?php print drupal_render($form['submitted']['postal_code']);?></li>
		<li><div class="select_box">
		<span class="select selectbox-bg" id="countrybox2">Country*</span>
		<label for="edit-submitted-form2-country">Country*</label>
		<?php print drupal_render($form['submitted']['form2_country']);?>
		</div></li>
		<?php print '<li>'.drupal_render($form['captcha']).'</li>'; ?>
		<li><div class="form-btns">
			<ul>
			<li class="r-more">
			<a href="javascript:void(0)" id="back-btn2"><span class="ui-icon fmore"></span><span>Back</span></a>
			</li>
			<?php
			print '<li class="btn-res"><p><input type="reset" value="Reset" onclick="jQuery(\'#countrybox2\').html(\'Country*\');jQuery(\'#productspriceplan2\').html(\'Products\');"></p></li>';
			print '<li class="submit-btn">'.drupal_render_children($form).'</li>';
			?>
			</ul>
			</div>
		</li>
	</ul>