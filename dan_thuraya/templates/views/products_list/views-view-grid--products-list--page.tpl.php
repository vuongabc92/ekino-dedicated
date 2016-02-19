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
<section class="block-6 list-item result-block">
  <div class="container">
    <?php foreach ($rows as $row_number => $columns): ?>
      <?php if (!empty($title) && $i == 0) : ?>
        <?php
        $term = array_keys(taxonomy_get_term_by_name($title, 'product_type'));
        ?>
        <div class="title-7">
          <figure>
            <img src="images/icon-land-1.png" alt="" class="img-responsive"/>
          </figure>
          <a href="<?php print 'products/' . $term[0]; ?>"><span class="header-title"><?php print $title; ?></span></a>
        </div>
      <?php endif; ?>
      <div class="wrap">
        <div class="content">
          <div class="row <?php print ($i == 0) ? 'first' : ''  ?>">
            <?php foreach ($columns as $column_number => $item): ?>
              <?php print $item; ?>
            <?php endforeach; ?>
            <?php $i++; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>