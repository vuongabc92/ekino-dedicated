<?php
$breadcrumb = $share['breadcrumb_results'];
$breadcrumb_result = v2_breadcrumb_load_breadcrumb($breadcrumb);
$filter_get_languague = _hs_resource_get('Filter','plain', FALSE, FALSE);
$filter = '<a href="javascript:;" title="'.$filter_get_languague.'" class="filter-btn close">'.$filter_get_languague.'</a>';
$count_product = '<p class="filter-title"><span data-num-result="" class="product-number">'.$count_product.'</span></p>';
$current_path = current_path();
?>
<div data-filters class="filter-block" data-destination="<?php print $current_path; ?>">
    <?php
    //Modular page
    if (!empty($share) && !empty($share['title'])):
      ?>
      <h1 class="title title-medium"><?php print $share['title']; ?></h1>
      <?php
    endif;
    ?>
    <div class="page-navigation">
        <div class="grid-fluid">
            <div class="inner">
                <?php print hs_resource_contextual_link('Filter', $filter, 'filter-btn close'); ?>
                <?php if (count($breadcrumb)): ?>
                  <?php print $breadcrumb_result; ?>
                <?php endif; ?>
                <?php if($count_product_number > 0): ?>
                  <?php print hs_resource_contextual_link($resource_name, $count_product, 'filter-title'); ?>
                <?php endif; ?>
            </div>
            <div data-content-filters class="filter-content">
                <div class="radio-btn">
                    <input type="radio" name="product-type" id="type-1" value="<?php print _hs_resource_get('All','plain', FALSE, FALSE); ?>" checked="checked" class="hidden" data-url-filters="<?php print url('filter-collections/all'); ?>"/>
                    <label for="type-1"><?php print _hs_resource_get('All'); ?></label>
                </div>
                <?php $i = 2; ?>
                <?php foreach ($results as $result): ?>
                  <?php if ($result['entity'] == 'taxonomy'): ?>
                    <div class="radio-btn">
                        <input type="radio" name="product-type" id="type-<?php print $i; ?>" value="<?php print drupal_lookup_path('alias', 'taxonomy/term/' . $result['taxonomy']->tid); ?>" class="hidden" data-url-filters="<?php print url('filter-collections/' . $result['taxonomy']->tid); ?>"/>
                        <label for="type-<?php print $i; ?>"
                          data-tracking data-track-action="click" data-track-category="products-list" data-track-label="<?php print strtolower(drupal_lookup_path('alias', 'taxonomy/term/' . $result['taxonomy']->tid)); ?>" data-track-type="event">
                          <?php print $result['taxonomy']->name; ?></label>
                        <?php $i++; ?>
                    </div>
                  <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div data-eqheight="" data-result-filters="" class="filter-result">
        <div class="filter-collection">
            <div class="grid-fluid">
                <?php foreach ($results as $result): ?>
                  <?php if ($result['entity'] == 'taxonomy'): ?>
                    <?php print drupal_render(taxonomy_term_view($result['taxonomy'], 'full')); ?>
                  <?php endif; ?>
                  <?php if ($result['entity'] == 'node'): ?>
                    <?php print drupal_render(node_view($result['node'], 'teaser')); ?>
                  <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>