<?php
/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
$node_social_create = $row->node_created;
$path_image = drupal_get_path('theme', 'dan_thuraya') . '/images/';
$type = strtolower($row->field_field_social_feed_type[0]['rendered']['#title']);
//$url = $row->field_field_reference_url[0]['rendered']['#element']['display_url'];
$url = $row->field_field_reference_url[0]['raw']['display_url'];
$img_type = $type;
$share_url = "#";
switch ($type) {
  case "instagram":
    $img_type = 'intergram';
    break;

  case "facebook":
    preg_match_all("/facebook\.com\/(\d*)_(\d*)$/", $url, $output);
    if (!empty($output[2])) {
      $fb_post_id = $output[2][0];
      $temp_url = "http://facebook.com/" . $fb_post_id;
      $share_url = "http://www.facebook.com/sharer.php?u=" . $temp_url;
    }
    break;

  case "twitter":
    preg_match_all("/twitter\.com\/(.*)\/(.*)\/(.*)/", $url, $output);
    if (!empty($output[3])) {
      $twitter_id = $output[3][0];
    }
    $share_url = "https://twitter.com/intent/retweet?tweet_id=" . $twitter_id . "&via=";
    break;

  case "youtube":
    break;

  default:
    break;
}
?>
<section class="block-10 feed-image-block bg-white <?php print $type . "-item"; ?>">
    <?php if (!empty($row->field_field_image[0]['rendered']['#item']['uri'])): ?>
      <figure class="main-img">
          <a href="#">
              <img src="<?php print file_create_url($row->field_field_image[0]['rendered']['#item']['uri']); ?>" alt="<?php print $row->field_field_image[0]['rendered']['#item']['filename']; ?>"/>
          </a>
      </figure>
    <?php endif; ?>
    <div class="inner">
        <div class="date-group">
            <figure class="icon-img">
                <img src="/<?php print $path_image . 'ico-' . $img_type . '-2.png'; ?>" alt="icon-1"/>
            </figure>
            <span class="date"><a href="<?php print $url; ?>"><?php print utf8_decode($row->node_title); ?></a> &bullet; <?php print date('M d, Y', $node_social_create); ?></span>
            <a target="_new "href="<?php print $share_url; ?>" class="wi-icon wi-icon-link-1 link-3 share"></a>
        </div>
        <h2 class="title-2"><?php
            $content = utf8_decode($row->field_body[0]['raw']['value']);
            $content = replace_hashtag_in_string($content, '#', $type);
            print $content;
            ?>
        </h2>
    </div>
    <?php if (!empty($row->field_field_youtube)): ?>
      <figure>
          <?php print render($row->field_field_youtube); ?>
      </figure>
    <?php endif; ?>
    <?php if (!empty($row->field_field_vimeo)): ?>
      <br/>
      <figure>
          <?php print render($row->field_field_vimeo); ?>
      </figure>
    <?php endif; ?>
</section>


