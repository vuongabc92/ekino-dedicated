<?php
  global $pager_page_array, $pager_total, $pager_total_items;
  
  if ($pager_total_items <> 0){
  $results_per_page=10;
  $from = 1+(($pager_page_array[0])*$results_per_page);
  if ( ($pager_page_array[0]+1) == $pager_total[0]){
    // we are on the last page
    $to =   $pager_total_items[0];
  }
  else {
    $to = 1+(($pager_page_array[0])*$results_per_page)+$results_per_page-1;
  }

  }
  /*$output = t('%number', array('%number' =>
  format_plural($pager_total_items[0], '1 Search result', '@count Search results')));*/

  $ter = str_replace('OR','',trim(arg(2)));
  ?>

<?php
$variable_developer = variable_get('thu_develop_description');
$variable_m2m = variable_get('thu_m2m_description');
$variable_landing_page = variable_get('thu_landing_page_description');

$url_landing_developer = url('/landing-developer');
$url_m2m = url('/products/215');
$url_landing_page = url('/landing-page');

$des_dev = substr($variable_developer['value'], 0, 200);
$des_m2m = substr($variable_m2m['value'], 0, 200);
$des_landing_page = substr($variable_landing_page['value'], 0, 200);

$value_return_dev = strstr($variable_developer['value'], $ter, false);
$value_return_m2m = strstr($variable_m2m['value'], $ter, false);
$value_return_landing_page = strstr($variable_landing_page['value'], $ter, false);
if(($value_return_dev) || ($value_return_m2m) || $value_return_landing_page) {
    $total_item = $pager_total_items[0] + 1;
}

?>
<h1>
  <?php print t(''.$total_item.' Search results found for<span> "'.$ter.'"</span>'); ?>
</h1>

<?php if($results): ?>
<ol class="search-results <?php print $module; ?>-results">
    <?php if(isset($variable_developer) && ($value_return_dev)): ?>    
    <li class="search-result">
        <div class="search-snippet-info">
              <h3 class="title">
                  <a href="<?php print $url_landing_developer; ?>"><?php print $ter; ?></a>
              </h3>
              <p class="search-snippet"><?php print $des_dev; ?></p>
          </div>
          <div class="searchmore">             
              <a href="<?php print $url_landing_developer; ?>">
                  <span><?php print t('Read more'); ?></span>
                  <span class="ui-icon arrow"></span>
              </a>
          </div>
    </li>
    <?php endif; ?>
    <?php if(isset($variable_m2m) && ($value_return_m2m)): ?>
    <li class="search-result">
        <div class="search-snippet-info">
              <h3 class="title">
                  <a href="<?php print $url_m2m; ?>"><?php print $ter; ?></a>
              </h3>
              <p class="search-snippet"><?php print $des_m2m; ?></p>
          </div>
          <div class="searchmore">             
              <a href="<?php print $url_m2m; ?>">
                  <span><?php print t('Read more'); ?></span>
                  <span class="ui-icon arrow"></span>
              </a>
          </div>
    </li>
    <?php endif; ?>
    <?php if(isset($variable_landing_page) && ($value_return_landing_page)): ?>
    <li class="search-result">
        <div class="search-snippet-info">
              <h3 class="title">
                  <a href="<?php print $url_landing_page; ?>"><?php print $ter; ?></a>
              </h3>
              <p class="search-snippet"><?php print $des_landing_page; ?></p>
          </div>
          <div class="searchmore">             
              <a href="<?php print $url_landing_page; ?>">
                  <span><?php print t('Read more'); ?></span>
                  <span class="ui-icon arrow"></span>
              </a>
          </div>
    </li>
    <?php endif; ?>    
    
    <?php foreach($results as $result):?>
      <li class="search-result">          
          <?php
              $url = url(drupal_get_path_alias('node/'.$result['node']->nid));
              if($result['node']->type == 'module_developer_slider' || $result['node']->type == 'module_develop_blog'):
                  $url = $url_landing_developer;
              elseif ($result['node']->type == 'landing_slider'):
                  $url = $url_landing_page;
              elseif ($result['node']->type == 'module_sector_slider'):
                  $url = url('/');
              elseif ($result['node']->type == 'module_segment_slider'):
                  $url = $url_m2m;
          ?>
          <?php endif; ?>
          <div class="search-snippet-info">
              <h3 class="title">
                  <a href="<?php print $url; ?>"><?php print $result['node']->title; ?></a>
              </h3>
              <p class="search-snippet"><?php print $result['snippet']; ?></p>
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
  <b><?php print t('Your search for "' . trim(arg(2)) . '" yielded no results'); ?></b>
<?php endif; ?>