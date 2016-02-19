<?php
$prefix_title = ($node->field_champagne_brand[LANGUAGE_NONE][0]['value']) ? $node->field_champagne_brand[LANGUAGE_NONE][0]['value']: '';
$see_product_get_language = _hs_resource_get('see_product','plain', FALSE, FALSE, FALSE, 'See product');
$see_product = '<a href="'.$node_url.'" title="'.$see_product_get_language.'" class="btn btn-white"'
    . 'data-tracking data-track-action="cta" data-track-category="products-list" data-track-label="'.$node_url.'" data-track-type="event">'.$see_product_get_language.'</a>';

$image_src = isset($node->field_picture_collection['und'][0]['uri']) ? $node->field_picture_collection['und'][0]['uri'] : '';
$image_alt = !empty($node->field_picture_collection['und'][0]['alt']) ? $node->field_picture_collection['und'][0]['alt'] : $prefix_title . ' ' . strip_tags($node->title);
$url = image_style_url('product_champagne__315x451_', $image_src);
$image_transparent = v2_mumm_custom_get_path('images');
?>
<div data-rollover="" data-block="" class="product-item">
    <div class="visual style-2">
        <?php print render($title_prefix); ?>
        <?php print render($title_suffix); ?>
        <a href="<?php print $node_url ?>" title="<?php print strip_tags($title); ?>" class="image-wrap">
            <img src="<?php print $image_transparent; ?>transparent.png" alt="<?php print $image_alt;?>" class="product-image" data-interchange="[&quot;<?php print $url; ?>&quot;,&quot;<?php print $url; ?>&quot;,&quot;<?php print $url; ?>&quot;]">
        </a>
        <div class="roll-over style-2">
            <div class="inner">
                <div class="content">
                    <h1 class="title-result"><?php print $prefix_title.'<br>'.$title; ?></h1>
                    <?php print hs_resource_contextual_link('see_product', $see_product); ?>
                </div>
            </div>
        </div>
    </div>
</div>