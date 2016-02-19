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
?>
<ul class="social-menu <?php print $classes; ?>">  

    <?php print render($title_prefix); ?>
    <?php print render($title_suffix); ?>

    <li><a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_linkedIn')); ?>" class="wi-icon wi-icon-linked-in"><?php print t('LinkedIn'); ?></a>
    </li>
    <li><a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_youTube')); ?>" class="wi-icon wi-icon-youtube"><?php print t('YouTube'); ?></a>
    </li>
    <li><a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_twitter')); ?>" class="wi-icon wi-icon-twitter"><?php print t('Twitter'); ?></a>
    </li>
    <li><a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_instagram')); ?>" class="wi-icon wi-icon-instagram"><?php print t('Instagram'); ?></a>
    </li>
    <li><a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_facebook')); ?>" class="wi-icon wi-icon-facebook"><?php print t('Facebook'); ?></a>
    </li>
    <li class="link-group-1">
      <ul>
        <li class="link-group-2 text-menu">
          <a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_block')); ?>"><?php print t('Blog'); ?>
            <span class="wi-icon wi-icon-arrow"></span>
          </a>
          <a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_newlleter')); ?>"><?php print t('Press Release'); ?>
            <span class="wi-icon wi-icon-arrow"></span>
          </a>
        </li>
        <li class="text-menu">
          <a class="wi-icon wi-icon-wav" href="<?php print_r(variable_get('thu_variables_link_header_wav')); ?>">
            <?php print t('Wav'); ?>
          </a>
          <a class="text-3" href="javascript:;">
            <span><?php print t('Want to keep updated?'); ?></span>
          </a>
        </li>
      </ul>
    </li>
</ul>