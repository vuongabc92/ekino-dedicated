<?php
unset($form['search_block_form']['#size']);
unset($form['search_block_form']['#maxlength']);
unset($form['search_block_form']['#attributes']['title']);
hide($form['actions']);
?>
<button class="wi-icon wi-icon-search" type="submit"></button>
<label class="search-label" for="search-input"><?php print t('What are you looking for?'); ?></label>
<?php print render($form['search_block_form']); ?>
<?php print drupal_render_children($form); ?>

