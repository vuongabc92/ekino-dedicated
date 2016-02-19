<?php
/**
 * @file
 * Default theme implementation for displaying search results.
 *
 * This template collects each invocation of theme_search_result(). This and
 * the child template are dependent to one another sharing the markup for
 * definition lists.
 *
 * Note that modules may implement their own search type and theme function
 * completely bypassing this template.
 *
 * Available variables:
 * - $search_results: All results as it is rendered through
 *   search-result.tpl.php
 * - $module: The machine-readable name of the module (tab) being searched, such
 *   as "node" or "user".
 *
 *
 * @see template_preprocess_search_results()
 *
 * @ingroup themeable
 */
?>
<?php if ($search_results): ?>
  <?php
  global $pager_page_array, $pager_total, $pager_total_items;
  if ($pager_total_items <> 0) {
    $results_per_page = 10;
    $from = 1 + (($pager_page_array[0]) * $results_per_page);
    if (($pager_page_array[0] + 1) == $pager_total[0]) {
      // we are on the last page
      $to = $pager_total_items[0];
    } else {
      $to = 1 + (($pager_page_array[0]) * $results_per_page) + $results_per_page - 1;
    }
  }
  $keyword = str_replace('OR', '', trim(arg(2)));
  ?>
  <h1>
  <?php print t('' . $pager_total_items[0] . ' Search results found for<span> "' . $keyword . '"</span>'); ?>
  </h1>
  <ol class="search-results <?php print $module; ?>-results">
  <?php print $search_results; ?>
  </ol>
    <?php print $pager; ?>
<?php else : ?>
  <b><?php print t('Your search for "' . trim(arg(2)) . '" yielded no results'); ?></b>
<?php endif; ?>
