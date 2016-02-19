<?php
/**
 * @file
 * Outdated browser template.
 */
global $base_path, $base_url;
$assets_path = $base_url.'/'.drupal_get_path('theme', 'v2_mumm');
$site_name = variable_get('site_name', 'Gh Mumm');
?>

<div id="wrapper-unsupport-browser">
    <main>
        <div class="unsupported-block">
            <img src="<?php print $assets_path; ?>/images/upload/unsupported-browsers.jpg" alt="<?php print t('Unsupported browsers'); ?>" class="image-background"/>
            <span class="overlay"></span>
            <div class="content">
                <div class="inner">
                    <a href="<?php print $base_path; ?>" title="<?php print $site_name; ?>" class="logo">
                        <img src="<?php print $assets_path; ?>/images/logo-unsupport-browser.jpg" alt="<?php print $site_name; ?>"/>
                    </a>
                    <h2 class="title"><?php print t('Welcome'); ?></h2>
                    <p><?php print t('Your browser is outdated.'); ?><br /><?php print t('For a better experience, keep your browser up to date.'); ?></p>
                    <a href="http://browsehappy.com/" title="<?php print t('Check here for latest versions'); ?>" class="btn"><?php print t('Check here for latest versions'); ?></a>
                </div>
            </div>
        </div>
    </main>
</div>
