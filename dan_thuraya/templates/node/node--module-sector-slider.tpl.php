<?php
/**
 * @file
 * Bartik's theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
$path_image = drupal_get_path('theme', 'dan_thuraya') . '/images/icon_sector/';
print render($title_prefix);
print render($title_suffix);

$field_sector_slider_collections = $node->field_sector_slider_collection['und'];
$field_sector_slider_collection_value = array();
foreach($field_sector_slider_collections as $slider) {
  $field_sector_slider_collection_value = field_collection_item_load($slider['value']); 
}
$auto_play = ($node->field_slider_auto_play[LANGUAGE_NONE][0]["value"]) ? "true" : "false";
?>

<section data-slider data-type="sync" data-slide-for=".carousel-campaign" data-slide-nav=".list-button ul" name="carousel-campaign" class="block-4 home-campaign campaign-block list-slider node-<?php print $node->nid; ?>" <?php print $attributes; ?>>
  <div data-autoplay="<?php print $auto_play; ?>" class="slider carousel-campaign">
    <?php $count = 0;
    foreach ($field_sector_slider_collections as $slider) :
      $field_sector_slider_collection_value = field_collection_item_load($slider['value']);
      ?>
      <div class="slide slide-1 <?php print ($count++ == 0) ? 'move-in' : ''  ?>">
        <figure>
          <a target="_blank" href="<?php print $field_sector_slider_collection_value->field_link[LANGUAGE_NONE][0]['url']; ?>">
            <img src="<?php print image_style_url('1600x642', $field_sector_slider_collection_value->field_background_slider[LANGUAGE_NONE][0]['uri']); ?>" alt="<?php print $field_sector_slider_collection_value->field_introduction[LANGUAGE_NONE][0]['value']; ?>"/>
          </a>
        </figure>
        <div class="container">
          <div class="inner">
            <div class="block-3">
              <h2 style="color: <?php print $field_sector_slider_collection_value->field_color_for_introduction[LANGUAGE_NONE][0]['rgb']; ?>" class="title-1">
                <?php print $field_sector_slider_collection_value->field_introduction[LANGUAGE_NONE][0]['value']; ?>
              </h2>

              <a style="color: <?php print $field_sector_slider_collection_value->field_color_for_introduction[LANGUAGE_NONE][0]['rgb']; ?>" target="_blank" href="<?php print $field_sector_slider_collection_value->field_link[LANGUAGE_NONE][0]['url']; ?>" class="link-1">
                <?php print $field_sector_slider_collection_value->field_link[LANGUAGE_NONE][0]['title']; ?>
                <span class="icon-moon-arrow-right2"></span>
              </a>
            </div>
          </div>
        </div>
      </div>
<?php endforeach; ?>
  </div>
  <div class="list-button">
    <div class="container">
      <ul class="list-inline">
        <?php $count = 0;
        foreach ($field_sector_slider_collections as $slider) :
          $field_sector_slider_collection_value = field_collection_item_load($slider['value']);
          ?>
          <li class="<?php print ($count++ === 0) ? "slick-current " : ""; ?>">
            <?php
              $sector_title = $field_sector_slider_collection_value->field_icon_title[LANGUAGE_NONE][0]['value'];
              $sector_title = eregi_replace('<strong>', '', $sector_title);
              $sector_title = eregi_replace('</strong>', '', $sector_title);
              $sector_title = eregi_replace('comms', '', $sector_title);
            ?>
            <a href="javascript:;" title="<?php print $sector_title ?>">
              <span style="background-color: <?php print $field_sector_slider_collection_value->field_icon_background['und'][0]['rgb']; ?>" data-hover-color="<?php print $field_sector_slider_collection_value->field_icon_background['und'][0]['rgb']; ?>" class="label-color"></span>
              <span class="group-icon">
                <img src="<?php print $path_image . $field_sector_slider_collection_value->field_icon_style[LANGUAGE_NONE][0]["value"] ?>.png" alt="<?php print $field_sector_slider_collection_value->field_icon_style[LANGUAGE_NONE][0]["value"] ?>"/>
              </span>
            </a>
            <span style="color: <?php print $field_sector_slider_collection_value->field_icon_background['und'][0]['rgb']; ?>" data-hover-color="<?php print $field_sector_slider_collection_value->field_icon_background['und'][0]['rgb']; ?>" class="text-1"><?php print $field_sector_slider_collection_value->field_icon_title[LANGUAGE_NONE][0]['value']; ?></span>
          </li>
        <?php
        endforeach;
        ?>
      </ul>
    </div>
  </div>
</section>
