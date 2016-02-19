<section data-extra-links class="block-1 products-block hidden-xs hidden-sm hidden-md">
  <div class="container">
    <h2 class="title-2 text-white"><?php print t('Solutions'); ?></h2>

    <?php
      $col            = 4;
      $count_solution = count($solutions);
      $count          = $count_last = 0;
      $paging         = ($count_solution%$col === 0) ? $count_solution/$col : ((int) ($count_solution/$col) ) + 1;

      if (is_array($solutions) && $count_solution) :
        foreach ($solutions as $solution) :

          if ($count === 0 || (($count%$paging) === 0)) {
            print '<div class="block-2 land-voice-block">
                    <div class="content">
                      <ul class="list-unstyled list-1">';
          }
          $count_last++;
          ?>
          <li>
            <a href="<?php print drupal_get_path_alias('node/' . $solution->nid); ?>">
              <?php print $solution->title; ?>
            </a>
          </li>
          <?php
          if (($count++ % $paging) === $paging - 1 || $count_last === count($solutions)) {
              print '</ul>
                  </div>
                </div>';
          }
        endforeach;
      endif;
    ?>
  </div>
</section>