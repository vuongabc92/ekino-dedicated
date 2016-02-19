<?php
hide($content['comments']);
hide($content['links']);
?>
<div>
    <?php print render($title_prefix); ?>
    <?php print render($title_suffix); ?>

    <?php 
	$fid = $node->field_picture['und'][0]['fid'];
	$content = $node->field_content['und'][0]['value'];
	
	$file_path = file_load($fid);
	?>
	<?php if($file_path) { ?>
		<img src="<?php print file_create_url($file_path->uri); ?>" alt="<?php print $node->title; ?>" class="img-banner">
	<?php } ?>
	<?php if($content) { ?>
		<div class="text-description custom-editor"><?php print $content; ?></div>
	<?php } ?>
</div>

