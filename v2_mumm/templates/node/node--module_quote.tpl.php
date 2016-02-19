<?php
/*
 * @file node--module_quote.tpl.php.
 *
 */
$quote = isset($node->field_quote[LANGUAGE_NONE][0]['value']) ? $node->field_quote[LANGUAGE_NONE][0]['value']:'';
$quote_author = isset($node->field_author[LANGUAGE_NONE][0]['value']) ? $node->field_author[LANGUAGE_NONE][0]['value']:'';
$function = isset($node->field_function[LANGUAGE_NONE][0]['value']) ? $node->field_function[LANGUAGE_NONE][0]['value']:'';
?>

<div class="quote-block spacing-bottom">
  <div class="grid-fluid">
    <blockquote>
      <?php if($quote): ?>
        <p><?php print nl2br($quote); ?></p>
      <?php endif; ?>
      <footer>
        <strong><?php print $quote_author; ?>&nbsp;</strong><?php print $function; ?></footer>
    </blockquote>
  </div>
</div>