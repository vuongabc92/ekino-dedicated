<?php
global $language, $base_root;
$publish_date = isset($node->field_publish_date[LANGUAGE_NONE][0]['value']) ? $node->field_publish_date[LANGUAGE_NONE][0]['value'] : '';
$image_uri = isset($node->field_picture[LANGUAGE_NONE][0]['uri']) ? $node->field_picture[LANGUAGE_NONE][0]['uri'] : '';

$content = isset($node->field_content[LANGUAGE_NONE][0]['value']) ? $node->field_content[LANGUAGE_NONE][0]['value'] : '';
$text_date = babybel_variable_get('babybel_variable_news_text_date_', $language->language, '');
?>
<?php print render($title_prefix); ?>
<?php print render($title_suffix); ?>
<h2 class="title-1"><?php print $node->title; ?></h2>

<div class="news-info">
	<?php if($date) : 
   //Retrieve date format and split date / time
   $date_format =  explode(" - ", locale_get_localized_date_format($language->language)['date_format_short']);
    ?>
		<span class="date"><?php print babybel_contextual_render('text_date_news'). ':';?> <?php print date($date_format[0], strtotime($publish_date)); ?></span>
	<?php endif; ?>
	<?php print babybel_contextual_render('text_share_news'); ?>
    <div class="shariff social-share" data-services="[&quot;facebook&quot;,&quot;googleplus&quot;,&quot;twitter&quot;]"   data-lang="<?php print $language->language;?>" data-orientation="horizontal" data-theme="standard"></div>
</div>
<!-- .news-info -->

<?php
	if($image_uri) :
		print '<div class="thumb">';
		print '<img src="' . image_style_url('1440x801', $image_uri) . '" alt="' . $node->title . '">';
		print '</div>';
  endif;
?>
<!-- .thumb -->

<?php if($content) : ?>
<div class="content custom-editor">
	<?php print $content; ?>
</div>
<!-- .content -->
<?php endif; ?>
