<?php
global $language, $base_root;

$message = babybel_variable_get('babybel_variable_banner_cookies_message', $language->language, '');
$dismiss = babybel_variable_get('babybel_variable_banner_cookies_dismiss', $language->language, '');
$learmore_title = babybel_variable_get('babybel_variable_banner_cookies_learnmore_cta_link_title', $language->language, '');
$learmore_url = babybel_variable_get('babybel_variable_banner_cookies_learnmore_cta_link_url', $language->language, '');
?>
<div class="cookies-banner"></div>
<!--<div class="cookies-wrapper"><?php //print babybel_contextual_render('banner_cookies'); ?></div>-->
<script>
  window.cookieconsent_options = {
    "message": "<?php print $message; ?>",
    "dismiss": "<?php print $dismiss; ?>",
    "learnMore": "<?php print $learmore_title; ?>",
    "link": "<?php print $base_root . url($learmore_url); ?>",
    "container": ".cookies-banner"
  };

</script>
