<?php
/**
 * @file
 * webform-confirmation.tpl.php.
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

<div class="sorry-block">
  <h1 class="title"><?php print _hs_resource_get('form_confirmation_page_title', 'plain', FALSE, TRUE); ?></h1>
  <div class="sub-title">
            <?php if ($confirmation_message): ?>
                <?php print $confirmation_message; ?>
            <?php else: ?>
                <?php print t('Thank you, your submission has been received.'); ?>
            <?php endif; ?>
</div>
  <a href="<?php print url('<front>'); ?>" title="<?php print _hs_resource_get('webform_submit_confirmation', 'plain', FALSE, FALSE); ?>" class="btn red-btn slim-text center-btn">
    <?php print _hs_resource_get('webform_submit_confirmation', 'plain', FALSE, FALSE); ?>
  </a>
</div>
