<?php
$breadcrumbs = $share['breadcrumb_results'];
$breadcrumb_result = v2_breadcrumb_load_breadcrumb($breadcrumbs);
$total_rituals = $champagne_rituals['total'];
$count_rituals = $total_rituals > 0 ? format_plural($total_rituals, '1 '._hs_resource_get('Tips','plain', FALSE, FALSE), '@count '._hs_resource_get('Tips','plain', FALSE, FALSE)) : '';
$load_more_get_language = _hs_resource_get('load_more','plain', FALSE, FALSE, FALSE, 'Load more');
$load_more = '<a href="javascript:;" title="'.$load_more_get_language.'" class="btn btn-gray btn-sm slim-text center-btn" data-loadmore-trigger="data-loadmore-trigger">'.$load_more_get_language.'</a>';
$count_content = '<p class="filter-title"><span class="product-number" data-num-result="">'.$count_rituals.'</span></p>';
$current_path = current_path();
?>
<div class="page-navigation" data-destination="<?php print $current_path; ?>">
    <div class="grid-fluid">
        <?php
        //Modular page
        if (!empty($share) && !empty($share['title'])):
          ?>
          <h1 class="title title-medium"><?php print $share['title']; ?></h1>
        <?php endif; ?>
        <div class="inner">
            <?php if (count($breadcrumbs)): ?>
              <?php print $breadcrumb_result; ?>
            <?php endif; ?>
            <?php if($total_rituals > 0): ?>
              <?php print hs_resource_contextual_link('Tips', $count_content, 'filter-title'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<div data-loadmore data-destination="<?php print $current_path; ?>" data-url-loadmore="<?php print url('load-more-champagne-tips'); ?>" data-list-wrapper=".list-products" class="articles-block spacing-bottom">
    <div class="grid-fluid">
        <div class="list-products list-products-1">
            <?php
            $nodes = $champagne_rituals['nodes'];
            if ($nodes) :
              ?>
              <?php
              foreach ($nodes as $node) :
                $node_details = node_load($node->nid);
                $node_view = node_view($node_details, '');
                $node_view['#theme'] = 'node__champagne_ritual_item';
                $rendered_node = drupal_render($node_view);
                echo $rendered_node;
              endforeach;
              ?>
              <?php
            endif;
            ?>
        </div>
        <?php if ($champagne_rituals['total'] > V2_LIST_TIP_LIMIT) : ?>
          <?php print hs_resource_contextual_link('load_more', $load_more); ?>
        <?php endif; ?>
    </div>
</div>
