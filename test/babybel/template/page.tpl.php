<?php
/**
 * @file Page front template.
 */
global $language;
global $base_url;
$current_lang = $language->language;

$image_path = baybel_get_path('images');
?>
<style>
    .contextual-links-region:hover a.contextual-links-trigger {
        display: block;
    }
</style>
<?php print theme('babybel_cookie_banner'); ?>
<?php print theme('babybel_newsletter'); ?>
<div class="app">
    <div class="inner">
        <header class="header">
            <?php print render($page['header']); ?>
        </header>
        <!--data-type="open|closed|archives"-->
        <?php print render($page['content']); ?>
    </div>
    <footer class="footer">
        <?php print render($page['footer']); ?>
    </footer>
</div>