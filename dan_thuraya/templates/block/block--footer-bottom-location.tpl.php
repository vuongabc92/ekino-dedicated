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
<?php
$full_menu_items = menu_tree_all_data('main-menu');

$vocabulary = taxonomy_vocabulary_machine_name_load('product_type');
$categories = taxonomy_term_load_multiple(FALSE, array('vid' => $vocabulary->vid));

$contents = array();
if (!empty($categories)) {
  foreach ($categories as $category) {
    $term = taxonomy_term_load($category->tid);
    if ($term->field_status['und'][0]['value'] == 1) {
      $contents[] = array('id' => $term->tid, 'name' => $term->name, 'icon' => $term->field_icons['und'][0]['uri']);
    }
  }
}
?>
<section class="block-1 main-link-block" data-extra-links="">
  <div class="container">

    <div class="block-2 products-block-1 hidden-lg hidden-xs">
      <?php
      if (!empty($full_menu_items)):
        foreach ($full_menu_items as $value):
          if ($value['link']['options']['attributes']['class'][0] == 'products'):
            ?>
            <h2 class="title-2 text-white"><?php print $value['link']['link_title']; ?></h2>
            <div class="content active">
              <ul class="list-unstyled list-1">
                <?php
                foreach ($contents as $content):
                  ?>
                  <li><a href="<?php print '/products/' . $content['id']; ?>"><?php print $content['name']; ?></a>
                  </li>
            <?php endforeach; ?>
              </ul>
            </div>
            <?php
          endif;
        endforeach;
      endif;
      ?>
    </div>
    <div class="block-2 support-block">
      <?php
      if (!empty($full_menu_items)):
        foreach ($full_menu_items as $value):
          if ($value['link']['options']['attributes']['class'][0] == 'supports'):
            ?>
            <h2 class="title-2 text-white"><?php print $value['link']['link_title']; ?></h2>
            <div class="content">
              <ul class="list-unstyled list-1">
                <?php
                $menu_sub = menu_tree_output($value['below']);
                foreach ($menu_sub as $v):
                  ?>
                  <li><a href="<?php print url(drupal_get_path_alias($v['#href'])); ?>"><?php print $v['#title']; ?></a>
                  </li>
                <?php endforeach; ?>
                <?php
              endif;
            endforeach;
          endif;
          ?>
        </ul></div>
    </div>

    <div class="block-2 support-block">
      <?php
      if (!empty($full_menu_items)):
        foreach ($full_menu_items as $value):
          if ($value['link']['options']['attributes']['class'][0] == 'sectors'):
            ?>
            <h2 class="title-2 text-white"><?php print $value['link']['link_title']; ?></h2>
            <div class="content">
              <ul class="list-unstyled list-1">
                <?php
                $menu_sub = menu_tree_output($value['below']);
                foreach ($menu_sub as $v):
                  ?>
                  <li><a href="<?php print url(drupal_get_path_alias($v['#href'])); ?>"><?php print $v['#title']; ?></a>
                  </li>
                <?php endforeach; ?>
                <?php
              endif;
            endforeach;
          endif;
          ?>
        </ul></div>
    </div>

    <div class="block-2 support-block">
      <?php
      if (!empty($full_menu_items)):
        foreach ($full_menu_items as $value):
          if ($value['link']['options']['attributes']['class'][0] == 'about-us'):
            ?>
            <h2 class="title-2 text-white"><?php print $value['link']['link_title']; ?></h2>
            <div class="content">
              <ul class="list-unstyled list-1">
                <?php
                $menu_sub = menu_tree_output($value['below']);
                foreach ($menu_sub as $v):
                  ?>
                  <li><a href="<?php print url(drupal_get_path_alias($v['#href'])); ?>"><?php print $v['#title']; ?></a>
                  </li>
                <?php endforeach; ?>
                <?php
              endif;
            endforeach;
          endif;
          ?>
        </ul></div>
    </div>

    <div class="block-2 upcoming-block">
      <?php
      $events = get_latest_event("module_event");
      if (!empty($events)):
        foreach ($events as $event) :
          ?>
          <h2 class="title-2 text-white"><?php print $event->title; ?></h2>
          <div class="content">
            <p class="desc"><?php print_r($event->field_certificates['und'][0]['value']); ?></p>
            <p class="text-1 text-blue"><?php print $event->field_date_event['und'][0]['value']; ?></p>
            <ul class="list-unstyled link-group">
            <!--
            <li>
                <a class="link-1" href="<?php //print url(drupal_get_path_alias('node/' . $event->nid)); ?>">
                  <?php //print $event->field_link_detail['und'][0]['title']; ?>
                  <span class="wi-icon wi-icon-arrow"></span>
                </a>
            </li>
            -->
              <li>
                <a target="_blank" class="link-1" href="<?php print $event->field_link_all_event['und'][0]['url']; ?>"><?php print $event->field_link_all_event['und'][0]['title']; ?>
                  <span class="wi-icon wi-icon-arrow"></span>
                </a>
              </li>
            </ul>
          </div>
        <?php
        endforeach;
      endif;
      ?>
    </div>
  </div>
</section>