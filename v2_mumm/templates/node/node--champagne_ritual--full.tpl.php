<?php
global $base_url, $language;
$picture_instance = field_info_instance('node', 'field_picture', 'champagne_ritual');
$manualcrop_styles_list = $picture_instance['widget']['settings']['manualcrop_styles_list'];
ksort($manualcrop_styles_list);
$image_src = isset($content['field_picture']['#items'][0]['uri']) ? $content['field_picture']['#items'][0]['uri'] : '';
$image_alt = !empty($content['field_picture']['#items'][0]['alt']) ? $content['field_picture']['#items'][0]['alt'] : strip_tags($title);
$interchange = v2_mumm_interchange_images($image_src, $manualcrop_styles_list);
$image_transparent = v2_mumm_custom_get_path('images');
v2_breadcrumb_get_breadcrumb($node);
$breadcrumbs = drupal_get_breadcrumb();
$breadcrumb_result = v2_breadcrumb_load_breadcrumb($breadcrumbs);

$image_url_share = file_create_url($image_src);
$alilas_current = $base_url . request_uri();
$description_social = $node->metatags['en']['description']['value'];
$ritual_number = $content['field_ritual_number'][0]['#markup'];
$share_get_language = _hs_resource_get('share_text','plain', FALSE, FALSE,'Share');
$share = '<span class="text-share">'.$share_get_language.'</span>';
$tip_n = _hs_resource_get('n°','plain', FALSE, FALSE, FALSE, 'N°');

$social_share = variable_get('social_networks_sharing_' .$language->language);
?>
<div class="page-navigation">
    <div class="grid-fluid">
        <div class="inner">
          <?php if((!is_int($social_share['facebook']) && isset($social_share['facebook'])) || (!is_int($social_share['twitter']) && isset($social_share['twitter']))): ?>
            <div data-toggle-share="" class="share-block">
                <a href="#" title="<?php print $share_get_language; ?>" class="icon icon-share-toggle hidden-sm"><?php print $share_get_language; ?></a>
                <div class="share">
                    <?php print hs_resource_contextual_link('share_text', $share, 'text-share'); ?>
                    <ul class="social">
                      <?php if(!is_int($social_share['facebook']) && isset($social_share['facebook'])): ?>
                        <li>
                          <a href="javascript:;" title="<?php print t('Facebook'); ?>" class="icon icon-fb-small" data-share="data-share" data-share-content="{&quot;urlPage&quot;: &quot;<?php print $alilas_current; ?>&quot;, &quot;urlImg&quot;: &quot;<?php print $image_url_share; ?>&quot;, &quot;caption&quot;: &quot;<?php print $node->title; ?>&quot;, &quot;description&quot;: &quot;<?php print $description_social; ?>&quot;}"
                            data-tracking data-track-action="share" data-track-category="header" data-track-label="facebook" data-track-type="event">
                            <?php print t('Facebook'); ?>
                          </a>
                        </li>
                      <?php endif; ?>
                      <?php if(!is_int($social_share['twitter']) && isset($social_share['twitter'])): ?>
                        <li class="last-share">
                            <a href="https://twitter.com/intent/tweet?text=<?php print urlencode($base_url . $node_url); ?>" title="<?php print t('Twitter'); ?>" data-share-twitter class="icon icon-tw-small"
                              data-tracking data-track-action="share" data-track-category="header" data-track-label="twitter" data-track-type="event">
                              <?php print t('Twitter'); ?>
                            </a>
                        </li>
                      <?php endif; ?>
                    </ul>
                </div>
            </div>
          <?php endif; ?>
            <?php if (count($breadcrumbs)): ?>
              <?php print $breadcrumb_result; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="intro-block spacing-bottom">
    <?php print render($title_prefix); ?>
    <?php print render($title_suffix); ?>
    <div class="grid-fluid">
        <img src="<?php print $image_transparent; ?>transparent.png" alt="<?php print $image_alt; ?>" data-interchange='<?php print $interchange; ?>'>
        <h1 class="title-medium">
            <?php print hs_resource_contextual_link('n°', $tip_n , 'tip-n-contextualink') .$ritual_number.' / '.$title; ?>
        </h1>
        <div class="desc">
            <?php print render($content['field_ritual_body']); ?>
        </div>
    </div>
</div>
