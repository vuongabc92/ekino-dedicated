<?php
hide($content['comments']);
hide($content['links']);
$first_video = field_collection_item_load($content['field_videos']['#items'][0]['value']);
$tag_line = isset($content['field_tagline']['#items'][0]['value']) ? $content['field_tagline']['#items'][0]['value'] : '';
?>
<div data-video-control class="videos-block">
    <?php print render($title_prefix); ?>
    <?php print render($title_suffix); ?>
    <h2 class="title-box style-1"><?php print $tag_line; //$node->title;  ?></h2>
    <div class="main-video"><img src="<?php print baybybel_common_get_img_youtube($first_video, '910x512') ?>">
        <a href="#" title="<?php print t('play'); ?>" class="btn-play" data-video-id="<?php print isset($first_video->field_youtube_video_url[LANGUAGE_NONE][0]['video_id']) ? $first_video->field_youtube_video_url[LANGUAGE_NONE][0]['video_id'] : ''; ?>"><?php print t('play'); ?></a>
    </div>
    <ul class="thumbnail">
        <?php if (count($content['field_videos']['#items']) > 1): ?>
          <?php
          $flag = false;
          foreach ($content['field_videos']['#items'] as $item):
            $field = field_collection_item_load($item['value']);
            ?>
            <li class="item <?php print ($flag == false) ? 'active' : ''; ?>"><a href="#" title="<?php print $field->field_title[LANGUAGE_NONE][0]['value'] ?>" data-video-id="<?php print isset($field->field_youtube_video_url[LANGUAGE_NONE][0]['video_id']) ? $field->field_youtube_video_url[LANGUAGE_NONE][0]['video_id'] : ''; ?>">
                    <img src="<?php print baybybel_common_get_img_youtube($field, '140x78'); ?>">
                </a>
            </li>
            <?php
            $flag = true;
          endforeach;
          ?>
        <?php endif; ?>
        <?php
        $query = ($content['field_youtube_channel_page_url']['#items'][0]['query']) ? '?' . drupal_http_build_query($content['field_youtube_channel_page_url']['#items'][0]['query']) : '';
        ?>
        <?php if ($content['field_youtube_channel_page_url']['#items'][0]['url']): ?>
          <li class="item cta-seemore"><a target="_blank" href="<?php print $content['field_youtube_channel_page_url']['#items'][0]['url'] . $query; ?>" title="<?php print $content['field_youtube_channel_page_url']['#items'][0]['title']; ?>" class="btn-seemore"><?php print $content['field_youtube_channel_page_url']['#items'][0]['title']; ?></a>
            <?php endif; ?>
        </li>
    </ul>
</div>