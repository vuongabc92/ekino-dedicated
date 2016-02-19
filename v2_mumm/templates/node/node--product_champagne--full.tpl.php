<?php
global $base_url, $language;

$price = $content['field_price']['#items'][0]['value'];
$buy_url = isset($node->field_click_to_buy[LANGUAGE_NONE][0]['remote_key']) ? $node->field_click_to_buy[LANGUAGE_NONE][0]['remote_key'] : '';
$buy_url_title = isset($node->field_click_to_buy[LANGUAGE_NONE][0]['title']) ? $node->field_click_to_buy[LANGUAGE_NONE][0]['title'] : '';
$drink_mumm_cta_link = $content['field_champagne_drink_mumm_cta']['#items'][0]['url'];
$cta_url_external = v2_mumm_check_url_external($drink_mumm_cta_link);
$drink_mumm_cta_title = isset($content['field_champagne_drink_mumm_cta']['#items'][0]['title']) ? $content['field_champagne_drink_mumm_cta']['#items'][0]['title'] : t('WHERE TO DRINK');
$category_name = taxonomy_term_load($node->field_champagne_category[LANGUAGE_NONE][0]['tid'])->name;
$image_src = v2_mumm_custom_get_path('images');
$prefix_title = ($content['field_champagne_brand'][0]['#markup']) ? $content['field_champagne_brand'][0]['#markup'] : '';
v2_breadcrumb_get_breadcrumb($node);
$breadcrumbs = drupal_get_breadcrumb();
$breadcrumb_result = v2_breadcrumb_load_breadcrumb($breadcrumbs);
$image_url = file_create_url($image_uri);
$alilas_current = $base_url . request_uri();
$description_social = $node->metatags['en']['description']['value'];
$share_get_language = _hs_resource_get('share_text','plain', FALSE, FALSE,'Share');
$share = '<span class="text-share">'.$share_get_language.'</span>';

$language_buy = variable_get('pr_ctbuy_connector_lang');
$social_share = variable_get('social_networks_sharing_' .$language->language);

$image_uri = isset($content['field_picture']['#items'][0]['uri']) ? $content['field_picture']['#items'][0]['uri'] : '';
$image_alt = !empty($content['field_picture'][0]['#item']['alt']) ? $content['field_picture'][0]['#item']['alt'] : $prefix_title . ' ' .strip_tags($node->title);
$crop_style_list = array('376x840', '376x840', '376x840');
$interchange = v2_mumm_interchange_images($image_uri, $crop_style_list);
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
                          <a href="javascript:;" title="<?php print t('Facebook'); ?>" class="icon icon-fb-small" data-share="data-share" data-share-content="{&quot;urlPage&quot;: &quot;<?php print $alilas_current; ?>&quot;, &quot;urlImg&quot;: &quot;<?php print $image_url; ?>&quot;, &quot;caption&quot;: &quot;<?php print trim($prefix_title) . ' ' . $node->title; ?>&quot;, &quot;description&quot;: &quot;<?php print $description_social; ?>&quot;}"
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
<div class="product-infomation">
    <div class="grid-fluid">
        <h1 class="title title-medium hidden-sm visible-xs">
            <?php print trim(htmlspecialchars_decode($prefix_title)) . '<br>' . $title; ?>
        </h1>
        <div class="row">
            <?php print render($title_prefix); ?>
            <?php print render($title_suffix); ?>
            <div class="col product">
                <img src="<?php print $image_src; ?>transparent.png" alt="<?php print $image_alt; ?>" data-interchange='<?php print $interchange; ?>'>
            </div>
            <div class="col description">
                <div class="text-group">
                    <h1 class="title title-medium hidden-xs">
                        <?php print trim(htmlspecialchars_decode($prefix_title)) . '<br>' . $title; ?>
                    </h1>
                    <div class="text-block editor">
                        <?php print render($content['field_description']); ?>
                    </div>
                    <?php if ($price): ?>
                      <?php
                      $retail_selling_price_get_language = _hs_resource_get('retail_selling_price','plain', FALSE, FALSE, FALSE, 'Retail selling price');
                      $retail_selling_price = '<p class="price">'.$retail_selling_price_get_language.': '.$price. '</p>';
                      print hs_resource_contextual_link('retail_selling_price', $retail_selling_price);
                      ?>
                    <?php endif; ?>
                </div>
                <div class="bottom-group">
                    <?php if ($drink_mumm_cta_link): ?>
                      <a <?php print ($cta_url_external['external']) ? 'target="_blank"' : '' ;?> href="<?php print $drink_mumm_cta_link; ?>" title="<?php print $drink_mumm_cta_title; ?>" class="link where-drink"
                        data-tracking data-track-action="cta" data-track-category="product" data-track-label="where_to_drink" data-track-type="event">
                        <?php print $drink_mumm_cta_title; ?>
                      </a>
                    <?php endif; ?>
                    <?php if ($buy_url && $buy_url_title): ?>
                      <a href="javascript:void(0)" title="<?php print $buy_url_title; ?>"
                        data-ctbuy-key="<?php print $buy_url; ?>" data-ctbuy-lang="<?php print $language_buy; ?>"
                        class="cta link btn red-btn" target="_blank"
                        data-tracking data-track-action="buy-cta" data-track-category="product" data-track-label="" data-track-type="event">
                        <?php print $buy_url_title; ?>
                      </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
