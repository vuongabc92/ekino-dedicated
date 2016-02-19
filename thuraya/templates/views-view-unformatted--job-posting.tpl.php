<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<ul>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php 
$i=1;
foreach ($rows as $id => $row): ?>
<?php if($i=='1'){ ?><div class="firstjobposting"><?php }?>
	<?php print $row; ?>
	
<?php
 if($i=='1'){ echo '</div>'; }
 $i++;
endforeach; ?>
</ul>