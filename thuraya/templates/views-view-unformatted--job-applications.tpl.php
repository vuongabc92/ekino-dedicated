<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<div class="personal-info">
<ul class="title-desc">
                        	<li>Job</li>
                            <li>Expiry Date</li>
                            <li>Applied Date</li>
                            <li>Status</li>
                            <li class="last-content">&nbsp;</li>
</ul>                        
<div class="my-app">
<?php foreach ($rows as $id => $row): ?>
<?php if($id ==0 || $id%2 == 0){?>
<ul class="content-desc">
	<?php print $row; ?>
</ul>
<?php } else{?>
<ul class="content-desc closed">
	<?php print $row; ?>
</ul>
<?php }?><?php endforeach; ?>
</ul></div>
</div>