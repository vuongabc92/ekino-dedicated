<?php
/**
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $pubdate: Formatted date and time for when the node was published wrapped
 *   in a HTML5 time element.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content. Currently broken; see http://drupal.org/node/823380
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see zen_preprocess_node()
 * @see template_process()
 */
//echo "<pre>"; print_r($node); exit;
?>
<div class="careers generic">
  <div class="colums">
	<div class="col1">
	<?php if($node->field_short_description): ?>
	<h2><?php print($node->field_short_description[$node->language][0]["safe_value"]);?></h2>
	<?php endif; ?>
	  <div class="in-container">
		<?php 
			$noOfImages = count($node->field_page_image[$node->language]);
			if($noOfImages > 0):
			
			if($browDetails['version'] == "8.0" && $browDetails['name'] == "Internet Explorer"):
		?>
		<div><img src="<?php print image_style_url('generic_page_images', $node->field_page_image[$node->language][0]['uri']); ?>" alt="<?php print $node->field_page_image[$node->language][0]['alt']; ?>"/></div>
		<?php else: ?>
		<div class="circleBg">
		<div class="circle-img" ><img src="<?php print image_style_url('generic_page_images', $node->field_page_image[$node->language][0]['uri']); ?>" alt="<?php print $node->field_page_image[$node->language][0]['alt']; ?>"/></div>
		</div>
		<?php endif; ?>
		<?php endif; ?>
		<div class="left-menu" style="margin-top:40px;"><?php print render(block_get_blocks_by_region('about_leftmenu')); ?></div>
	  </div>
	</div>
	<div class="col2">
		<div class="content">
		<h1><?php print $title; ?></h1>
			<?php if($node->body): ?>
			<?php print($node->body[$node->language][0]["safe_value"]);?>
			<?php endif; ?>
		</div>
	  <div class="gsm">
		<div class="content1">
			<div class="gsm-map">
				<div class="tab-content">
					<h4>Choose your network</h4>
					<ul>
						<li><span class="left-align">Satellite</span><a href="javascript:void(0)" class="inactive inactive1">&nbsp;</a></li>
						<li class="border"></li>
						<li><span>GSM&nbsp;Roaming</span><a href="javascript:void(0)" class="active">&nbsp;</a></li>
					</ul>
					<div class="services">
						<p><span class="greenbox"></span>Roaming Services Available</p>
						<p><span class="greybox"></span>Roaming Services In Process</p>
					</div>
				</div>
			</div>
			<p style="font-family: Arial, Helvetica; font-size: 10px; color: #000;">This map represents Thuraya expectations of coverage. For further information, please contact Thuraya Customer Care at <a href="mailto:customer.care@thuraya.com">customer.care@thuraya.com</a></p>
			<div class="map-sec-column">
				<div class="column1">
					<h2>Thuraya Live Roaming Partners</h2>
					<p>Choose from the list below to view a list of roaming partners in your country.</p>
					<div class="select_box"> <span id="region-sel" class="select selectbox-bg">Region/Country</span>
					  <label for="reg-sel">Region/Country</label>
					  <select name="reg-sel" class="styled" id="reg-sel">
						<option value="Region/Country" selected="selected">Region/Country</option>
						<?php
						//$countries = get_countries_list();
						$roam_countries = get_roaming_partners_countries();
						//print_r($roam_countries);exit;
						foreach ($roam_countries as $key => $cname){
						?>
						<option value="<?php print $key; ?>"><?php print $cname; ?></option>
						<?php } ?>
					  </select>
					</div>
				</div>
				<div class="column2" id="partners-list">
					<div style="display:none;top:20px;text-align: center;" id="loader">
					<img src='<?php print file_create_url("sites/all/themes/thuraya/images/ajax-loader.gif"); ?>'>
					</div>
				</div>
			</div>
		 </div>
		 <div class="content2">
			<div class="sat-map">
				<div class="tab-content">
					<h4>Choose your network</h4>
					<ul>
						<li><span class="left-align">Satellite</span><a href="javascript:void(0)" class="active">&nbsp;</a></li>
						<li class="border"></li>
						<li><span>GSM&nbsp;Roaming</span><a href="javascript:void(0)" class="inactive">&nbsp;</a></li>
					</ul>
					<div class="services">
						<p><span class="darkbluebox"></span>Service Available</p>
						<p><span class="bluebox"></span>Service Possible</p>
					</div>
				</div>
			</div>
			<p style="font-family: Arial, Helvetica; font-size: 10px; color: #000;">This map represents Thuraya expectations of coverage. For further information, please contact Thuraya Customer Care at <a href="mailto:customer.care@thuraya.com">customer.care@thuraya.com</a></p>
		 </div>
		</div>
	</div>                
  </div>
</div>
