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