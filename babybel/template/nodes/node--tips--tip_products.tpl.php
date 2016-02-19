<?php 
	$alt_background = isset($node->field_background_picture[LANGUAGE_NONE][0]['alt']) ?  $node->field_background_picture[LANGUAGE_NONE][0]['alt'] : '';	
	$title_background = isset($node->field_background_picture[LANGUAGE_NONE][0]['title']) ?  $node->field_background_picture[LANGUAGE_NONE][0]['title'] : '';
?>
<?php print render($title_prefix); ?>
<?php print render($title_suffix); ?>

<a class="inner" title="<?php print truncate_utf8($node->title, 100, TRUE, TRUE); ?>" href="#">
    <h3 class="title"><?php print truncate_utf8($node->title, 100, TRUE, TRUE); ?></h3>
    <img title="<?php print $title_background; ?>" alt="<?php print $alt_background; ?>" src="<?php print image_style_url('768x428', $node->field_background_picture[LANGUAGE_NONE][0]['uri']);?>">
</a>