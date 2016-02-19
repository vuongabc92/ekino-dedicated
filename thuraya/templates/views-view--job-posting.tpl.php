<div class="in-container">
  <h1>Careers</h1>
<?php $block2 = module_invoke('block', 'block_view', 12);?>

  <?php print $block2[content];?>
  

  <?php if ($exposed): ?>
    <div class="date-filters">
      <?php print $exposed; ?>
    </div>
  <?php endif; ?>


  <?php if ($rows): ?>
    <div class="careers-list">
      <?php print $rows; ?>
    </div>
  <?php elseif ($empty): ?>
  No Record found.
  <?php endif; ?>

  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

  <?php if ($attachment_after): ?>
    <div class="attachment attachment-after">
      <?php print $attachment_after; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <?php print $more; ?>
  <?php endif; ?>

  
</div><?php /* class view */ ?>
