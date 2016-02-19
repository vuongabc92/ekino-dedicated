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
//krumo($rows);
?>

<?php foreach ($rows as $row_number => $columns): ?>
  <div class="wrap">
    <div class="content">
      <div class="row">
        <?php foreach ($columns as $column_number => $item): ?>
          <?php print $item; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
<?php endforeach; ?>