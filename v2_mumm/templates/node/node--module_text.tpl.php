<?php
/*
 * @file
 * node--module_text.tpl.php.
 *
 */
$type_select = isset($node->field_type_text[LANGUAGE_NONE][0]['value']) ? $node->field_type_text[LANGUAGE_NONE][0]['value'] :'';
$one_column = isset($node->field_one_column[LANGUAGE_NONE][0]['value']) ? $node->field_one_column[LANGUAGE_NONE][0]['value'] :'';
$two_column_one = isset($node->field_two_column[LANGUAGE_NONE][0]['value']) ? $node->field_two_column[LANGUAGE_NONE][0]['value'] :'';
$two_column_tow = isset($node->field_two_column[LANGUAGE_NONE][1]['value']) ? $node->field_two_column[LANGUAGE_NONE][1]['value'] :'';
$field_maps_long = isset($node->field_text_gmap_long['und'][0]['value']) ? $node->field_text_gmap_long['und'][0]['value'] :'';
$field_maps_lat = isset($node->field_text_gmap_lat['und'][0]['value']) ? $node->field_text_gmap_lat['und'][0]['value'] :'';
$marker_icon_src = v2_mumm_custom_get_path('images') . 'icon-pin.png';
$show_map = (trim($field_maps_long) !== '' && trim($field_maps_lat) !== '');
?>
<?php if($type_select == '1column'): ?>
<div class="text-block spacing-bottom">
  <div class="grid-fluid">
    <div class="editor">
      <div><?php print nl2br($one_column); ?></div>
      <?php if($show_map) : ?>
      <div data-gmap="" data-lat="<?php print $field_maps_lat ?>" data-long="<?php print $field_maps_long ?>" data-icon-marker="<?php print $marker_icon_src ?>" class="map-frame"></div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php endif;?>
<?php if($type_select == '2column'): ?>
<div class="text-block two-col spacing-bottom">
  <div class="grid-fluid">
    <div class="editor">
      <div class="row">
        <?php if($two_column_one): ?>
        <div class="col">
          <div><?php print $two_column_one; ?></div>
        </div>
        <?php endif; ?>
        <?php if($two_column_tow): ?>
        <div class="col">
          <div><?php print $two_column_tow; ?></div>
          <?php if($show_map) : ?>
          <div data-gmap="" data-lat="<?php print $field_maps_lat ?>" data-long="<?php print $field_maps_long ?>" data-icon-marker="<?php print $marker_icon_src ?>" class="map-frame"></div>
          <?php endif; ?>
        </div>
        <?php endif;?>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
