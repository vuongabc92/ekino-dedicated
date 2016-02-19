<?php

/**
 * @file
 * Default simple view template to display a rows in a grid.
 *
 * - $rows contains a nested array of rows. Each row contains an array of
 *   columns.
 *
 * @ingroup views_templates
 */
 $i = 0;
?>
<?php foreach ($rows as $row_number => $columns): ?>
  <div class="list_block">
  <?php if (!empty($title) && $i==0) : 
$class = strtolower(str_replace(' ', '',$title));
?>
  <h2><span class="ui-icon <?php print $class; ?>"></span><?php print $title; ?></h2>
<?php endif; ?>
	<ul>
	<?php foreach ($columns as $column_number => $item): ?>
	  <li><?php print $item; ?></li>
	<?php endforeach; ?>
	<?php $i++; ?>
	</ul>
  </div>
<?php endforeach; ?>