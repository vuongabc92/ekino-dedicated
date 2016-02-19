<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<?php 
$counter = 0;
$tot_rows = count($rows);
foreach ($rows as $id => $row): $counter++;?>
     <?php if ($counter == 1) :?> <div class="servicerow"> <?php endif; ?>
    <div class="list-container" id="<?php print $id;?>">
	<?php print $row; ?>
	</div>
	<?php
	if($counter == $tot_rows && $tot_rows < 4):
	print '</div>';
	endif;
	if ($counter == 3) : $counter = 0?> 
        </div> 
    <?php endif; ?>
  <?php endforeach; ?>