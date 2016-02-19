<?php
/**
 * @file
 * Default theme implementation to display a block.
 *
 * Available variables:
 * - $block->subject: Block title.
 * - $content: Block content.
 * - $block->module: Module that generated the block.
 * - $block->delta: An ID for the block, unique within each module.
 * - $block->region: The block region embedding the current block.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - block: The current template type, i.e., "theming hook".
 *   - block-[module]: The module generating the block. For example, the user
 *     module is responsible for handling the default user navigation block. In
 *     that case the class would be 'block-user'.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $block_zebra: Outputs 'odd' and 'even' dependent on each block region.
 * - $zebra: Same output as $block_zebra but independent of any block region.
 * - $block_id: Counter dependent on each block region.
 * - $id: Same output as $block_id but independent of any block region.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $block_html_id: A valid HTML ID and guaranteed unique.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 * @see template_process()
 *
 * @ingroup themeable
 */
global $language, $base_url;
$mention_cookies_data = v2_age_gate_variable_get('mention_cookies', $language->language);

if (variable_get('age_gate_background_image_' . $language->language)):
  $file_background = file_load(variable_get('age_gate_background_image_' . $language->language));
  $background = image_style_url('1380x768', $file_background->uri);
else:
  $background = $base_url.'/'.drupal_get_path('theme', 'v2_mumm') . '/images/upload/bg-agegate.jpg';
endif;
if (variable_get('age_gate_background_mobile_' . $language->language)):
  $file_background_mobile = file_load(variable_get('age_gate_background_mobile_' . $language->language));
  $background_mobile = image_style_url('309x564', $file_background_mobile->uri);
else:
  $background_mobile = $base_url.'/'.drupal_get_path('theme', 'v2_mumm') . '/images/upload/bg-agegate-mobile.jpg';
endif;
?>
<div data-render-login data-interchange='["<?php print $background ?>","<?php print $background ?>","<?php print $background_mobile; ?>"]' data-type="background-image" class="age-gate">
    <iframe id="iframe-agegate" src="javascript:;" allowfullscreen="" class="age-gate-frame"></iframe>
    <p data-legal class="age-gate-legal"><?php print v2_age_gate_variable_get('mention_health', $language->language); ?></p>
</div>
<?php if($mention_cookies_data['value']): ?>
<div class="mention-block">
  <a href="javascript:;" title="<?php print t('close'); ?>" class="icon icon-close" data-close-hint="data-close-hint"><?php print t('close'); ?></a>
  <div class="content">
    <?php print check_markup($mention_cookies_data['value'], $mention_cookies_data['format']); ?>
  </div>
</div>
<?php endif; ?>
