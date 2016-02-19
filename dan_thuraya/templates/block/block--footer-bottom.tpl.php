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

<section class="block-1 bottom-footer bg-darker-gray">
  <div class="container">
    <div id="<?php print $block_html_id; ?>" class="main-menu <?php print $classes; ?>"<?php print $attributes; ?>>

      <?php print render($title_prefix); ?>
      <?php print render($title_suffix); ?>
      <p class="description hidden-md hidden-xs">
        <?php print variable_get('thu_variables_description'); ?>
      </p>
      <p class="copy-right hidden-md hidden-xs">
        <?php print variable_get('thu_variables_copy_right'); ?>
      </p>
      <div class="footer-menu">
        <ul class="list-unstyled extra-link hidden-xs">
          <li class="active"><a target="_blank" href="<?php print variable_get('thu_variables_link_terms_of_use'); ?>"><?php print variable_get('thu_variables_terms_of_use'); ?></a>
          </li>
          <li><a target="_blank" href="<?php print variable_get('thu_variables_link_privacy'); ?>"><?php print variable_get('thu_variables_privacy'); ?></a>
          </li>
          <li><a target="_blank" href="<?php print variable_get('thu_variables_link_sitemap'); ?>"><?php print variable_get('thu_variables_sitemap'); ?></a>
          </li>
        </ul>
        <ul class="link-group-1 hidden-lg hidden-lg hidden-xs">
          <li class="drop-down text-menu">
              <a href="javascript:;"><?php print t('Blog');?><span class="wi-icon wi-icon-caret hidden-xs"></span></a>
            <ul class="sub-menu hidden">
              <li><a href="#">menu 1</a>
              </li>
              <li><a href="#">menu 2</a>
              </li>
              <li><a href="#">menu 3</a>
              </li>
            </ul>
          </li>
          <li class="text-menu"><a href="#"><span><?php print t('Keep updated ?'); ?></span><span class="wi-icon wi-icon-arrow"></span></a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="block-1 social-footer bg-dark-gray hidden-lg">
  <div class="container">
    <ul class="social-menu">
      <li><a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_linkedIn')); ?>" class="wi-icon wi-icon-linked-in"><?php print t('ssLinkedIn'); ?></a>
      </li>
      <li><a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_youTube')); ?>" class="wi-icon wi-icon-youtube"><?php print t('YouTube'); ?></a>
      </li>
      <li><a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_twitter')); ?>" class="wi-icon wi-icon-twitter"><?php print t('Twitter'); ?></a>
      </li>
      <li><a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_instagram')); ?>" class="wi-icon wi-icon-instagram"><?php print t('Instagram'); ?></a>
      </li>
      <li><a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_facebook')); ?>" class="wi-icon wi-icon-facebook"><?php print t('Facebook'); ?></a>
      </li>
      <li><a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_wav')); ?>" class="wi-icon wi-icon-wav"><?php print t('Wav'); ?></a>
      </li>
    </ul>
  </div>
</section>