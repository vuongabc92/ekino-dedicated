<?php
global $language, $base_url;

$site_name = variable_get('site_name', 'Gh Mumm');
// Get image for logo.
if (variable_get('age_gate_logo_' . $language->language)):
  $file_logo = file_load(variable_get('age_gate_logo_' . $language->language));

  $logo = image_style_url('173x111', $file_logo->uri);
else:
  $logo = $base_url . '/' . drupal_get_path('theme', 'v2_mumm') . '/images/logo-header-sm.svg';
endif;
if (variable_get('age_gate_background_image_' . $language->language)):
  $file_background = file_load(variable_get('age_gate_background_image_' . $language->language));
  $background = image_style_url('1380x768', $file_background->uri);
else:
  $background = $base_url . '/' . drupal_get_path('theme', 'v2_mumm') . '/images/upload/bg-agegate.jpg';
endif;
if (variable_get('age_gate_background_mobile_' . $language->language)):
  $file_background_mobile = file_load(variable_get('age_gate_background_mobile_' . $language->language));
  $background_mobile = image_style_url('309x564', $file_background_mobile->uri);
else:
  $background_mobile = $base_url . '/' . drupal_get_path('theme', 'v2_mumm') . '/images/upload/bg-agegate-mobile.jpg';
endif;

$mention_cookies_data = v2_age_gate_variable_get('mention_cookies', $language->language);
?>
<div data-interchange='["<?php print $background ?>","<?php print $background ?>","<?php print $background_mobile; ?>"]' data-type="background-image" class="age-gate-bgd"></div>
<div class="age-gate-block">
  <div class="welcome-block">
    <?php if ($logo): ?>
      <a href="<?php print url('<front>'); ?>" title="<?php print $site_name; ?>" class="logo">
        <img src="<?php print $logo; ?>" alt="<?php print $site_name; ?>"/>
      </a>
    <?php endif; ?>
    <h1 class="welcome-title"><?php print v2_age_gate_variable_get('title', $language->language); ?></h1>
    <?php print render(drupal_get_form('v2_age_gate_form')); ?>
    <p class="error-mess hidden"></p>
    <p class="error-mess-trans hidden"><?php print v2_age_gate_variable_get('error_underaged', $language->language); ?></p>
    <p class="error-no-legal-age hidden"><?php print v2_age_gate_variable_get('error_no_legal_age', $language->language); ?></p>
    <div class="legal-notice">
      <?php $conditions = v2_age_gate_variable_get('conditions', $language->language); ?>
      <p><?php print check_markup($conditions['value'], $conditions['format']); ?></p>
      <p class="mention-health"><?php print v2_age_gate_variable_get('mention_health', $language->language); ?></p>
    </div>
  </div>
  <input type="hidden" value="<?php print strtotime("now"); ?>" name="current-year"/>
</div>
