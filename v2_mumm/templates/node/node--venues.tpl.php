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
$picture_instance = field_info_instance('node', 'field_venues_picture', 'venues');
$crop_style_list = $picture_instance['widget']['settings']['manualcrop_styles_list'];

$image = isset($node->field_venues_picture[LANGUAGE_NONE][0]['uri']) ? $node->field_venues_picture[LANGUAGE_NONE][0]['uri'] : '';
$interchange = v2_mumm_interchange_images($image, $crop_style_list);
$field_subtitle = isset($node->field_subtitle[LANGUAGE_NONE][0]['value']) ? $node->field_subtitle[LANGUAGE_NONE][0]['value'] : '';
$field_introduction = isset($node->field_article_introduction[LANGUAGE_NONE][0]['value']) ? $node->field_article_introduction[LANGUAGE_NONE][0]['value'] : '';

$button_url = isset($node->field_venues_cta[LANGUAGE_NONE][0]['url']) ? $node->field_venues_cta[LANGUAGE_NONE][0]['url'] : '';
$button_title = isset($node->field_venues_cta[LANGUAGE_NONE][0]['title']) ? $node->field_venues_cta[LANGUAGE_NONE][0]['title'] : '';
$field_maps_long = isset($node->field_maps[LANGUAGE_NONE][0]['lng']) ? $node->field_maps[LANGUAGE_NONE][0]['lng'] : '';
$field_maps_lat = isset($node->field_maps[LANGUAGE_NONE][0]['lat']) ? $node->field_maps[LANGUAGE_NONE][0]['lat'] : '';

$marker_icon_src = v2_mumm_custom_get_path('images') . 'icon-pin.png';

$type_col = isset($node->field_type_text[LANGUAGE_NONE][0]['value']) ? $node->field_type_text[LANGUAGE_NONE][0]['value'] : '';
$one_column = isset($node->field_one_column[LANGUAGE_NONE][0]['value']) ? $node->field_one_column[LANGUAGE_NONE][0]['value'] : '';
$tow_column_one = isset($node->field_two_column[LANGUAGE_NONE][0]['value']) ? $node->field_two_column[LANGUAGE_NONE][0]['value'] : '';
$tow_column_two = isset($node->field_two_column[LANGUAGE_NONE][1]['value']) ? $node->field_two_column[LANGUAGE_NONE][1]['value'] : '';

//Condition enable button readmore.
$enable_readmore = true;
if (!empty($type_col)):
  if (empty($field_introduction) && empty($one_column) && empty($tow_column_one) && empty($tow_column_two) && empty($field_maps_long) && empty($field_maps_lat)):
    $enable_readmore = false;
  endif;
else:
  $enable_readmore = false;
endif;

$read_more_get_language = _hs_resource_get('read_more','plain', FALSE, FALSE, FALSE, 'Read more');
$read_more = '<button type="button" name="open-button" title="'.$read_more_get_language.'" class="btn btn-gray open-btn">'.$read_more_get_language.'</button>';
$close_get_language = _hs_resource_get('close','plain', FALSE, FALSE);
$close = '<button type="button" name="close-button" title="'.$close_get_language.'" class="btn btn-gray close-btn">'.$close_get_language.'</button>';
?>
<div class="image-text banner-item spacing-bottom">
    <div class="grid-fluid">
        <?php print render($title_prefix); ?>
        <?php print render($title_suffix); ?>
        <div class="inner">
            <span data-interchange='<?php print $interchange; ?>' data-type="background-image" class="image-background">
            </span>
        </div>
        <div data-read-more="" class="description">
            <h3 class="image-title <?php print is_numeric($node->title) ? 'large' : 'small'; ?>"><?php print $node->title; ?></h3>
            <?php if($field_subtitle): ?>
                <h4 class="sub-title"><?php print $field_subtitle; ?></h4>
             <?php endif; ?>
            <p><?php print nl2br($field_introduction); ?></p>
            <?php if ($enable_readmore): ?>
            <?php print hs_resource_contextual_link('read_more', $read_more, 'open-btn'); ?>
            <?php endif; ?>
            <div class="content">
                <?php if ($type_col == '1column'): ?>
                  <div class="editor">
                      <?php if (!empty($field_maps_long) || !empty($field_maps_lat)): ?>
                        <div data-gmap="" data-lat="<?php print trim($field_maps_lat); ?>" data-long="<?php print trim($field_maps_long); ?>" data-icon-marker="<?php print $marker_icon_src; ?>" class="map-frame spacing-bottom hidden-sm visible-xs"></div>
                      <?php endif; ?>

                      <?php if ($one_column): ?>
                        <?php print $one_column; ?>
                      <?php endif; ?>
                      <?php if (!empty($field_maps_long) || !empty($field_maps_lat)): ?>
                        <div data-gmap="" data-lat="<?php print trim($field_maps_lat); ?>" data-long="<?php print trim($field_maps_long); ?>" data-icon-marker="<?php print $marker_icon_src; ?>" class="map-frame hidden-xs"></div>
                      <?php endif; ?>
                      <?php if (!empty($button_title) || !empty($button_url)): ?>
                        <a href="<?php print $button_url; ?>" <?php print ($button_url) ? 'target="_blank"' : ''; ?> title="<?php print $button_title; ?>" class="btn red-btn center-btn"
                          data-tracking data-track-action="cta" data-track-category="venues-list" data-track-label="<?php print $button_url; ?>" data-track-type="event">
                          <?php print $button_title; ?>
                        </a>
                      <?php endif; ?>
                  </div>
                <?php endif; ?>

                <?php if ($type_col == '2column'): ?>
                  <div class="editor two-col border">
                      <div class="row">
                          <?php if (!empty($field_maps_long) || !empty($field_maps_lat)): ?>
                            <div data-gmap="" data-lat="<?php print trim($field_maps_lat); ?>" data-long="<?php print trim($field_maps_long); ?>" data-icon-marker="<?php print $marker_icon_src; ?>" class="map-frame spacing-bottom hidden-sm visible-xs"></div>
                          <?php endif; ?>
                          <?php if ($tow_column_one): ?>
                            <div class="col">
                                <?php print $tow_column_one; ?>
                            </div>
                          <?php endif; ?>
                          <?php if (!empty($tow_column_two) || !empty($field_maps_long) || !empty($field_maps_lat)): ?>
                            <div class="col">
                                <?php print $tow_column_two; ?>
                                <?php if (!empty($field_maps_long) || !empty($field_maps_lat)): ?>
                                  <div data-gmap="" data-lat="<?php print trim($field_maps_lat); ?>" data-long="<?php print trim($field_maps_long); ?>" data-icon-marker="<?php print $marker_icon_src; ?>" class="map-frame hidden-xs"></div>
                                <?php endif; ?>
                            </div>
                          <?php endif; ?>
                      </div>
                      <?php if (!empty($button_title) || !empty($button_url)): ?>
                        <a href="<?php print $button_url; ?>" <?php print ($button_url) ? 'target="_blank"' : ''; ?> title="<?php print $button_title; ?>" class="btn red-btn center-btn"
                          data-tracking data-track-action="cta" data-track-category="venues-list" data-track-label="<?php print $button_url; ?>" data-track-type="event">
                          <?php print $button_title; ?>
                        </a>
                      <?php endif; ?>
                  </div>
                <?php endif; ?>
                <?php print hs_resource_contextual_link('close', $close); ?>
            </div>
        </div>
    </div>
</div>
