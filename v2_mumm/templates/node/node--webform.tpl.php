<?php
/**
 * @file
 * Default theme implementation to display a node.
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
 *
 * @ingroup themeable
 */
?>
<?php
$image_src = isset($node->field_webform_picture[LANGUAGE_NONE][0]['uri']) ? $node->field_webform_picture[LANGUAGE_NONE][0]['uri'] : '';
$image_alt = !empty($node->field_webform_picture[LANGUAGE_NONE][0]['alt']) ? $node->field_webform_picture[LANGUAGE_NONE][0]['alt'] : strip_tags($node->title);
$crop_style_list = array('1173x387', '944x311', '924x601');
$interchange = v2_mumm_interchange_images($image_src, $crop_style_list);
$webform_header = isset($node->field_webform_header[LANGUAGE_NONE][0]['value']) ? $node->field_webform_header[LANGUAGE_NONE][0]['value'] : '';
$webform_footer = isset($node->field_webform_footer[LANGUAGE_NONE][0]['value']) ? $node->field_webform_footer[LANGUAGE_NONE][0]['value'] : '';

$webform_template = isset($node->field_webform_template[LANGUAGE_NONE][0]['value']) ? $node->field_webform_template[LANGUAGE_NONE][0]['value'] : 'default';
?>

<div class="grid-fluid">
<?php print render($title_prefix); ?>
<?php print render($title_suffix); ?>
<?php if ($image_src): ?>
    <div class="intro-block intro-contest">
      <img src="<?php print image_style_url('1173x387', $image_src); ?>" alt="<?php print $image_alt; ?>" data-interchange='<?php print $interchange; ?>'>
    </div>
  <?php endif; ?>
  <div class="heading-block">
    <h1 class="title title-large"><?php print $node->title; ?></h1>
  </div>
  <div class="content <?php print $webform_template; ?>">
    <?php if($webform_header) :?>
    <div class="field-text-head">
      <?php print $webform_header; ?>
    </div>
    <?php endif; ?>
    <?php print render($content); ?>
    <?php if($webform_footer): ?>
    <div class="field-text-description hidden-xs">
      <?php print $webform_footer; ?>
    </div>
    <?php endif; ?>
  </div>
</div>
