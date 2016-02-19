<div class="wov-gallery cmp-gallery cmp-article">
    <ul class="gallery-mosaic">
        <?php $key = 0; ?>
        <?php foreach ($recent_items as $item): ?>
        <?php
            $thumb_img = sprintf('<a href="%s">%s</a>', $link_path, theme('imagecache_external', array('style_name' => 'gallery_thumbnail', 'path' => $item['media_url'])));

            if ($key % 2 == 0) {
                printf('<li>%s', $thumb_img);
            } else {
                printf('%s</li>', $thumb_img);
            }

            $key++;
        ?>
        <?php endforeach ?>
    </ul>

    <div class="outer-content">
        <h3>
            <a href="<?php print $link_path; ?>"><?php print _hs_resource_get('social_wall_gallery_title'); ?></a>
            <br />
            <a href="<?php print $link_path; ?>"><span><?php print _hs_resource_get('social_wall_gallery_link_title'); ?></span></a>
        </h3>
        <div class="content">
            <div class="left">
                <?php if ($highlighted_item): ?>
                    <?php print render($highlighted_item); ?>
                <?php endif ?>
            </div>
            <div class="clear"></div>
        </div>
        <?php // print render($content['mumm_share_widget']); ?>
    </div>

</div>