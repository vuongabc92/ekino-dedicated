<?php
/*
 * @file node--champagne_ritual-item.tpl.php.
 *
 */
?>
<div class="product-item">
<?php
print render($title_prefix);
?>
<?php if ($block->subject): ?>
  <h2<?php print $title_attributes; ?>><?php print $block->subject ?></h2>
<?php endif; ?>
<?php print render($title_suffix); ?>
<?php
$title = $node->title;
$field_picture = field_get_items('node', $node, 'field_picture');
$field_picture_src = !empty($field_picture[0]['uri']) ? image_style_url('gallery_thumbnail', $field_picture[0]['uri']) : '';
$field_picture_alt = !empty($field_picture[0]['alt']) ? $field_picture[0]['alt'] : strip_tags($title);
$field_ritual_number = field_get_items('node', $node, 'field_ritual_number');
$field_ritual_number = !empty($field_ritual_number[0]['value']) ? $field_ritual_number[0]['value'] : '';
$read_more_get_language = _hs_resource_get('read_more','plain', FALSE, FALSE, FALSE, 'Read more');
$read_more = '<a href="'.$node_url.'" title="'.$read_more_get_language.'" class="btn btn-white"'
    . 'data-tracking data-track-action="cta" data-track-category="tips-list" data-track-label="' . $node_url . '" data-track-type="event">'.$read_more_get_language.'</a>';
$kind_get_language = _hs_resource_get('tips_n°','plain', FALSE, FALSE, FALSE, 'Tips n°').str_pad($field_ritual_number, 2, 0, STR_PAD_LEFT);
$kind = '<a href="'.$node_url.'" title="'.$kind_get_language.'" class="link-title">'.$kind_get_language.'</a>';
?>
  <div class="visual">
    <a href="<?php print $node_url; ?>" title="<?php print strip_tags($title); ?>" class="image-wrap">
      <img src="<?php print $field_picture_src ; ?>" alt="<?php print $field_picture_alt; ?>" class="product-image"/>
    </a>
    <div class="roll-over">
      <div class="inner">
        <div class="content">
          <?php print hs_resource_contextual_link('read_more', $read_more); ?>
        </div>
      </div>
    </div>
  </div>
  <h3 class="kind"
    data-tracking data-track-action="cta" data-track-category="tips-list" data-track-label="<?php print $node_url; ?>" data-track-type="event">
    <?php print hs_resource_contextual_link('tips_n°', $kind);?>
  </h3>
  <h2 class="title">
    <a href="<?php print $node_url; ?>" title="<?php print strip_tags($title); ?>" class="link-title"
      data-tracking data-track-action="cta" data-track-category="tips-list" data-track-label="<?php print $node_url; ?>" data-track-type="event">
      <?php print $title ;  ?>
    </a>
  </h2>
</div>