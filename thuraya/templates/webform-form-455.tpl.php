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
	<ul id="complaintForm" class="enquiry-form" >
		<li>
		<div class="select_box"> <span id="productspriceplan3" class="select selectbox-bg">Products and Price Plan </span>
		  <label for="edit-submitted-products-price-plan">Products and Price Plan</label>
		  <?php print drupal_render($form['submitted']['products__price_plan']);?>
		</div>
		</li>
		<li><?php print drupal_render($form['submitted']['nature_of_complaint']);?></li>
		<li><?php print drupal_render($form['submitted']['comments']);?></li>
		<li><?php print drupal_render($form['submitted']['thuraya_number_msisdn']);?></li>
		<li><?php print drupal_render($form['submitted']['sim_number']);?></li>
		<li><?php print drupal_render($form['submitted']['equipment_imei']);?></li>
		<li><?php print drupal_render($form['submitted']['approximate_location_gps_coordinates']);?></li>
		<li class="textbox-small"><?php print drupal_render($form['submitted']['organization_name']);?></li>
		<li class="postal-small"><?php print drupal_render($form['submitted']['customer_name']);?></li>
		<li><?php print drupal_render($form['submitted']['email']);?></li>
		<li><?php print drupal_render($form['submitted']['mobile']);?></li>
		<li><?php print drupal_render($form['submitted']['thuraya_phone']);?></li>
		<li><?php print drupal_render($form['submitted']['address']);?></li>
		<li class="textbox-small"><?php print drupal_render($form['submitted']['city']);?></li>
		<li class="postal-small"><?php print drupal_render($form['submitted']['postal_code']);?></li>
		<li><div class="select_box">
		<span class="select selectbox-bg" id="countrybox3">Country*</span>
		<label for="edit-submitted-form3-country">Country*</label>
		<?php print drupal_render($form['submitted']['form3_country']);?>
		</div></li>
		<?php print '<li>'.drupal_render($form['captcha']).'</li>'; ?>
		<li><div class="form-btns">
			<ul>
			<li class="r-more">
			<a href="javascript:void(0)" id="back-btn3"><span class="ui-icon fmore"></span><span>Back</span></a>
			</li>
			<?php
			print '<li class="btn-res"><p><input type="reset" value="Reset" onclick="jQuery(\'#countrybox3\').html(\'Country*\');jQuery(\'#productspriceplan3\').html(\'Products and Price Plan\');"></p></li>';
			print '<li class="submit-btn">'.drupal_render_children($form).'</li>';
			?>
			</ul>
			</div>
		</li>
	</ul>