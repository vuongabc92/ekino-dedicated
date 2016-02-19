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
global $base_url;

$img = image_style_url("218x240", $row->field_field_product_image[0]["raw"]["uri"]);

$url = file_create_url($row->field_field_icons[0]["raw"]["uri"]);
$url = parse_url($url);
$icon_product_type = $base_url .  $url['path'];
                    
?>
<div class="item col-sm-3 col-xs-6" style="opacity: 1;" data-icon_product_type="<?php print $icon_product_type ?>">
    <figure class="product-image">
        <a href="<?php print url('node/' . $row->nid); ?>">
            <img src="<?php print $img; ?>" alt="<?php print $row->node_title ?>">
        </a>
    </figure>

    <a href="<?php print url('node/' . $row->nid); ?>" class="text-2"><?php print $row->node_title ?></a>
    <ul class="list-inline">
        <?php
        foreach ($row->field_field_associated_solutions as $sector) {
          if ($sector['raw']['node']->type === 'sector') {
            ?>
            <li>
                <figure>
                    <?php
                        $sector_title = $sector['raw']['node']->title;
                        $sector_title = eregi_replace('Comms', '', $sector_title);
                    ?>
                    <img src="<?php print image_style_url('37x36', $sector['raw']['node']->field_icon_sector_for_catetory['und'][0]['uri']); ?>" title="<?php print $sector_title; ?>" alt="<?php print $sector['raw']['node']->field_icon_sector_for_catetory['und'][0]['filename']; ?>">
                </figure>
            </li>
            <?php
          }
        }
        ?>
    </ul>
    <div class="product-button">
        <a href="#" class="wi-icon wi-icon-basket hidden"><?php print('Basket'); ?></a>
        <a href="#" class="wi-icon wi-icon-address"><?php print t('Address'); ?></a>
    </div>
</div>