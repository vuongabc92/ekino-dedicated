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
<div class="cont-form">
	<h1>Please fill out the following form and we will contact you promptly.</h1>
	<ul id="contactus_form">
		<?php
			print '<li>'.drupal_render($form['submitted']['name']).'</li>';
			print '<li>'.drupal_render($form['submitted']['company']).'</li>';
			print '<li>'.drupal_render($form['submitted']['email']).'</li>';
			print '<li>'.drupal_render($form['submitted']['contact_number']).'</li>';
		?>
		<li><div class="select_box">
		<span class="select selectbox-bg" id="productInterest">Products of Interest</span>
		<label for="country">Products of Interest</label>
		<?php print drupal_render($form['submitted']['product_of_interest']);?>
		</div></li>
		<?
			print '<li>'.drupal_render($form['submitted']['city']).'</li>';
			print '<li>'.drupal_render($form['submitted']['address']).'</li>';
			print '<li>'.drupal_render($form['submitted']['postal_code']).'</li>';
		?>
		<li><div class="select_box">
		<span class="select selectbox-bg" id="countrybox">Country</span>
		<label for="country">Country</label>
		<?php print drupal_render($form['submitted']['country']);?>
		</div></li>
		<?php
			print '<li>'.drupal_render($form['submitted']['comments']).'</li>';
		?>
		<div class="form-btns">
			<ul>
			<li class="r-more">
			<a href="javascript:void(0)"><span class="ui-icon more"></span><span>Back</span></a>
			</li>
			<?php
			// Print out the main part of the form.
			// Feel free to break this up and move the pieces within the array.
			//print drupal_render($form['submitted']);

			// Always print out the entire $form. This renders the remaining pieces of the
			// form that haven't yet been rendered above.
			print '<li>'.drupal_render($form['submitted']['reset']).'</li>';
			print '<li>'.drupal_render_children($form).'</li>';
			?>
			<!-- <li class="btn-res"><input id="btn-reset" class="btn-reset" type="submit" value="Reset" name="op"></li>
			<li class="btn-sub"><input id="btn-submit" class="btn-submit" type="submit" value="Submit" name="op"></li> -->
			</ul>
		</div>
	</ul>
</div>