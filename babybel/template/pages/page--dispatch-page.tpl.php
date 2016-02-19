<?php
global $language;
$image_path = baybel_get_path('images');
?>
<style>
    .contextual-links-region:hover a.contextual-links-trigger {
        display: block;
    }
</style>
<?php print theme('babybel_cookie_banner'); ?>
<div class="app app-agegate">
    <div class="dispatch background-layer">
        <div class="logo-agegate"><img src="<?php print $logo; ?>" alt="<?php print t('Babybel'); ?>" class="picto">
        </div>
        <div class="container">
            <div class="row">
                <?php print babybel_contextual_render('title_dispatch'); ?>
                <div class="col-md-8 country-box">
                    <?php print babybel_contextual_render('menu_dispatch', array('menu_content' => render($page['content']))); ?>
                </div>
            </div>
        </div>
        <?php print babybel_contextual_render('map_sticky_dispatch'); ?>
    </div>
</div>