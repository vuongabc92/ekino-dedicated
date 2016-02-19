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
global $base_url, $language;

$term_id = isset($node->field_article_category[LANGUAGE_NONE][0]['tid']) ? $node->field_article_category[LANGUAGE_NONE][0]['tid'] : '';
$taxonomy_term = taxonomy_term_load($term_id);
$taxonomy_name = $taxonomy_term->name;

$picture_instance = field_info_instance('node', 'field_picture', 'article');
$manualcrop_styles_list = $picture_instance['widget']['settings']['manualcrop_styles_list'];
ksort($manualcrop_styles_list);
$image_src = isset($content['field_picture']['#items'][0]['uri']) ? $content['field_picture']['#items'][0]['uri'] : '';
$image_alt = !empty($content['field_picture'][0]['#item']['alt']) ? $taxonomy_name . ' - ' .$content['field_picture'][0]['#item']['alt'] : $taxonomy_name . ' - ' .strip_tags($title);
$interchange = v2_mumm_interchange_images($image_src, $manualcrop_styles_list);
$image_transparent = v2_mumm_custom_get_path('images');
v2_breadcrumb_get_breadcrumb($node);
$breadcrumbs = drupal_get_breadcrumb();
$breadcrumb_result = v2_breadcrumb_load_breadcrumb($breadcrumbs);

$image_url_share = file_create_url($image_src);
$alilas_current = $base_url . request_uri();
$description_social = $node->metatags['en']['description']['value'];
$share_get_language = _hs_resource_get('share_text','plain', FALSE, FALSE,'Share');
$share = '<span class="text-share">'.$share_get_language.'</span>';

$social_share = variable_get('social_networks_sharing_' .$language->language);
?>
<div class="page-navigation">
    <div class="grid-fluid">
        <div class="inner">
          <?php if((!is_int($social_share['facebook']) && isset($social_share['facebook'])) || (!is_int($social_share['twitter']) && isset($social_share['twitter']))): ?>
            <div data-toggle-share="" class="share-block">
                <a href="#" title="<?php print $share_get_language; ?>" class="icon icon-share-toggle hidden-sm"><?php print $share_get_language; ?></a>
                <div class="share">
                    <?php print hs_resource_contextual_link('share_text', $share, 'text-share'); ?>
                    <ul class="social">
                      <?php if(!is_int($social_share['facebook']) && isset($social_share['facebook'])): ?>
                        <li>
                          <a href="javascript:;" title="<?php print t('Facebook'); ?>" class="icon icon-fb-small" data-share="data-share" data-share-content="{&quot;urlPage&quot;: &quot;<?php print $alilas_current; ?>&quot;, &quot;urlImg&quot;: &quot;<?php print $image_url_share; ?>&quot;, &quot;caption&quot;: &quot;<?php print $node->title; ?>&quot;, &quot;description&quot;: &quot;<?php print $description_social; ?>&quot;}"
                            data-tracking data-track-action="share" data-track-category="header" data-track-label="facebook" data-track-type="event">
                            <?php print t('Facebook'); ?>
                          </a>
                        </li>
                      <?php endif; ?>
                      <?php if(!is_int($social_share['twitter']) && isset($social_share['twitter'])): ?>
                        <li class="last-share">
                          <a href="https://twitter.com/intent/tweet?text=<?php print urlencode($base_url . $node_url); ?>" data-share-twitter title="<?php print t('Twitter'); ?>" class="icon icon-tw-small"
                            data-tracking data-track-action="share" data-track-category="header" data-track-label="twitter" data-track-type="event">
                            <?php print t('Twitter'); ?>
                          </a>
                        </li>
                      <?php endif; ?>
                    </ul>
                </div>
            </div>
          <?php endif; ?>

            <?php if (count($breadcrumbs)): ?>
              <?php print $breadcrumb_result; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="intro-block spacing-bottom">
    <?php print render($title_prefix); ?>
    <?php print render($title_suffix); ?>
    <div class="grid-fluid">
        <img src="<?php print $image_transparent; ?>transparent.png" alt="<?php print $image_alt; ?>" data-interchange='<?php print $interchange; ?>'>
        <h1 class="title-medium">
            <?php print $title; ?>
        </h1>
        <div class="desc">
            <?php print render($content['field_article_body']); ?>
        </div>
    </div>
</div>
