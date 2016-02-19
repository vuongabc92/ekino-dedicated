<?php
hide($content['comments']);
hide($content['links']);
?>
<div>
<?php print render($title_prefix); ?>
<?php print render($title_suffix); ?>
<?php 

	if($node->title) {
		print "<h2 class='title-1'>" . $node->title . "</h2>";
	}
	if($content['field_content']['#items'][0]['value']) {
		print "<div class='text-description custom-editor'>" . nl2br($content['field_content']['#items'][0]['value']) . "</div>";
	}
?>
</div>

