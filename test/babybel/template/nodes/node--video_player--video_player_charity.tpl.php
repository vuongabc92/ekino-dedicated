<?php 
hide($content['comments']);
hide($content['links']);
$first_video = field_collection_item_load($content['field_videos']['#items'][0]['value']);
$tag_line = isset($content['field_tagline']['#items'][0]['value']) ? $content['field_tagline']['#items'][0]['value'] : '';
?>
<div data-video-control class="videos-block">
    <?php print render($title_prefix); ?>
    <?php print render($title_suffix); ?>
    <div class="main-video"><img src="<?php print baybybel_common_get_img_youtube($first_video, '910x512') ?>">
        <a href="#" title="<?php print t('play'); ?>" class="btn-play" data-video-id="<?php print isset($first_video->field_youtube_video_url[LANGUAGE_NONE][0]['video_id']) ? $first_video->field_youtube_video_url[LANGUAGE_NONE][0]['video_id'] : ''; ?>"><?php print t('play'); ?></a>
    </div>
</div>