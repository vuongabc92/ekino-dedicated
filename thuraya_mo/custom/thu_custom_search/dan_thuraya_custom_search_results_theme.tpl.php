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
  $key = str_replace('OR', '', trim(arg(1)));
  ?>
  <h1>
  <?php print t('' . $total . ' Search results found for<span> "' . $key . '"</span>'); ?>
  </h1>
  <ol class="search-results <?php print $module; ?>-results">      
      <?php foreach($search_results as $search_result): ?>
      <li class="search-result">
          <?php
              $url = url(drupal_get_path_alias('node/'.$search_result->nid));
              if($search_result->type == 'module_developer_slider'):
                  $url = url('/landing-developer');
          ?>
          <?php endif; ?>
          <div class="search-snippet-info">
              <h3 class="title">
                  <a href="<?php print $url; ?>"><?php print $search_result->title; ?></a>
              </h3>
          </div>
          <div class="searchmore">             
              <a href="<?php print $url; ?>">
                  <span><?php print t('Read more'); ?></span>
                  <span class="ui-icon arrow"></span>
              </a>
          </div>
      </li>
      <?php endforeach; ?>      
  </ol>
    <?php print $pager; ?>
<?php else : ?>
  <b><?php print t('Your search for "' . trim($key) . '" yielded no results'); ?></b>
<?php endif; ?>
