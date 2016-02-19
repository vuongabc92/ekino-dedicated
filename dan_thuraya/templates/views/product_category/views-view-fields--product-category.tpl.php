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
$node = node_load($row->nid);
$sector_ids = $node->field_associated_solutions['und'];
?>
<div class="item col-sm-3 col-xs-6">
  <figure class="product-image"><a href="<?php print url(drupal_get_path_alias('node/'.$node->nid)); ?>"><img src="<?php print image_style_url('290x380',$row->field_field_product_image[0]['raw']['uri']); ?>" alt="<?php print $row->node_title; ?>"></a>
  </figure><a href="#" class="text-2"><?php print $row->node_title; ?></a>
  <ul class="list-inline">
    <?php
    foreach ($sector_ids as $sector_id) :
      $sector = node_load($sector_id["nid"]);
      if($sector->type === 'sector'):
    ?>
    <li>
      <figure><img src="<?php print file_create_url($sector->field_icon_sector_for_catetory['und'][0]['uri']); ?>" title="<?php echo $sector->title ?>" alt="<?php print $sector->field_icon_sector_for_catetory['und'][0]['filename']; ?>">
      </figure>
    </li>
    <?php endif; endforeach; ?>    
  </ul>
  <div class="product-button"><a href="#" class="wi-icon wi-icon-basket hidden"><?php print t('Basket'); ?></a><a href="#" class="wi-icon wi-icon-address"><?php print t('Address'); ?></a>
  </div>
</div>
