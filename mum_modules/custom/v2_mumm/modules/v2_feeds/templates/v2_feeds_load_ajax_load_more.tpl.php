<?php 
  $path_no_image = v2_mumm_custom_get_path('images').'no-image.jpg';
  $image_url = !empty($items['media_url']) ? $items['media_url'] : $path_no_image;
?>
<div class="article">
    <div class="item visual">
        <div class="image-wrap">
            <img src="<?php print $image_url; ?>" alt="<?php print $items['username']; ?>" class="article-image grayscale" data-interchange="[&quot;<?php print $image_url; ?>&quot;,&quot;<?php print $image_url; ?>&quot;,&quot;<?php print $image_url; ?>&quot;]">
        </div>
    </div>
    <div data-block="" class="item detail">
        <div class="content">
            <div class="social-box">
                <a href="<?php print $items['url']; ?>" title="<?php print $items['feed_type']; ?>" class="icon icon-<?php print $items['feed_type']; ?>-nobg" target="_blank">
                    <?php print $items['feed_type']; ?>
                </a>
            </div>
            <span class="date">
                <?php print format_date($items['published'], 'custom', 'j M'); ?>
            </span>
            <p>
              <?php print $items['message']; ?>
            </p>
            <span class="prefix"><?php print $items['username']; ?></span>
        </div>
    </div>
</div>