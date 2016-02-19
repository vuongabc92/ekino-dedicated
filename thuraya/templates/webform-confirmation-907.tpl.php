<?php

/**
 * @file
 * Customize confirmation screen after successful submission.
 *
 * This file may be renamed "webform-confirmation-[nid].tpl.php" to target a
 * specific webform e-mail on your site. Or you can leave it
 * "webform-confirmation.tpl.php" to affect all webform confirmations on your
 * site.
 *
 * Available variables:
 * - $node: The node object for this webform.
 * - $confirmation_message: The confirmation message input by the webform author.
 * - $sid: The unique submission ID of this submission.
 */
?>
<div class="careers generic">
  <div class="colums">
	<div class="col1">
	  <div class="in-container">
		 <div class="left-menu"><?php print render(block_get_blocks_by_region('wheretobuy_menu')); ?></div>
	  </div>
	</div>
	<div class="col2">
	  <div class="in-container webform-confirmation">
		<h1>Confirmation</h1>
		<div class="content">		
			<?php if ($confirmation_message): ?>
				<?php print $confirmation_message ?>
			<?php else: ?>
				<p><?php print t('Thank you, your submission has been received.'); ?></p>
			<?php endif; ?>
			<div class="links">
			  <a href="<?php print url('become-a-partner') ?>"><?php print t('Go back to the form') ?></a>
			</div>
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
