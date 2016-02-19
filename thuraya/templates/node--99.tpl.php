<?php
/**
 * @file
 * Zen theme's implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   - view-mode-[mode]: The view mode, e.g. 'full', 'teaser'...
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 *   The following applies only to viewers who are registered users:
 *   - node-by-viewer: Node is authored by the user currently viewing the page.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
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
//echo "<pre>"; print_r($node->field_page_image); exit;
$pageName = drupal_lookup_path('alias',"node/".$node->nid);
$browDetails = getBrowser();
//print_r($browDetails); exit;
?>
<div class="careers generic">
  <div class="colums">
	<div class="col1">
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
		 <div class="left-menu"><?php print render(block_get_blocks_by_region('about_leftmenu')); ?></div>
	  </div>
	</div>
	<div class="col2">
	  <div class="in-container">
		<h1><?php print $title; ?></h1>
		<?php if($node->field_short_description): ?>
		<h2><?php print($node->field_short_description[$node->language][0]["safe_value"]);?></h2>
		<?php endif; ?>	
		<div class="content">			
			<?php if($node->body): ?>
			<?php print($node->body[$node->language][0]["safe_value"]);?>
			<?php endif; ?>						
		</div>
		<div class="sn-links">
				<ul class="ul-sn">
				<li class="new-medium">Share it</li>
				<li>					
					<a href="http://www.facebook.com/sharer.php?u=<?php print curPageURL();?>" target="_blank" class="ui-icon facebook"></a>
					<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php print curPageURL();?>&amp;title=<?php print urlencode($node->title);?>&summary=<?php echo getNodeTeaser($node);?>" target="_blank" class="ui-icon in"></a>
					<a href="http://www.twitter.com/home?status=<?php print "Thuraya-".curPageURL();?>" class="ui-icon twiter" target="_blank"></a>
			   </li>
			  </ul>
			</div>
	  </div>
	</div>                
  </div>
</div>
