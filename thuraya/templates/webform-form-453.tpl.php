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
	<ul id="prodServInqForm" class="enquiry-form" >
		<li>
		<div class="select_box"> <span id="productspriceplan" class="select selectbox-bg">Products </span>
		  <label for="priceplan">Products</label>
		  <?php print drupal_render($form['submitted']['products']);?>
		</div>
		</li>
		<li><?php print drupal_render($form['submitted']['nature_of_enquiry']);?></li>
		<li><?php print drupal_render($form['submitted']['comments']);?></li>
		<li class="textbox-small"><?php print drupal_render($form['submitted']['name']);?></li>
		<li class="postal-small"><?php print drupal_render($form['submitted']['email']);?></li>
		<li><?php print drupal_render($form['submitted']['mobile']);?></li>
		<li><?php print drupal_render($form['submitted']['thuraya_phone']);?></li>
		<li class="textbox-small"><?php print drupal_render($form['submitted']['city']);?></li>
		<li class="postal-small"><?php print drupal_render($form['submitted']['postal_code']);?></li>
		<li><div class="select_box">
		<span class="select selectbox-bg" id="countrybox">Country*</span>
		<label for="edit-submitted-country">Country*</label>
		<?php print drupal_render($form['submitted']['country']);?>
		</div></li>
		<?php print '<li>'.drupal_render($form['captcha']).'</li>'; ?>
		<li><div class="form-btns">
			<ul>
			<li class="r-more">
			<a href="javascript:void(0)" id="back-btn"><span class="ui-icon fmore"></span><span>Back</span></a>
			</li>
			<?php
			print '<li class="btn-res"><p><input type="reset" value="Reset" onclick="jQuery(\'#countrybox\').html(\'Country*\');jQuery(\'#productspriceplan\').html(\'Products\');"></p></li>';
			print '<li class="submit-btn">'.drupal_render_children($form).'</li>';
			?>
			</ul>
			</div>
		</li>
	</ul>