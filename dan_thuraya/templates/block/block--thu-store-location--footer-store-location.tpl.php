<?php

print render($title_prefix);
print render($title_suffix);

$locations = get_node_by_type("service_partner");
$list = array();

foreach($locations as $location):
  $sectors = $location->field_loc_icon_sector[LANGUAGE_NONE];
  $item = array(
      "lat"   => $location->field_location[LANGUAGE_NONE][0]["lat"] ,
      "lng"   => $location->field_location[LANGUAGE_NONE][0]["lon"] ,
      "title"   => $location->title ,
  );

  $item["tel"] = (!empty($location->field_telephone_number))? $location->field_telephone_number[LANGUAGE_NONE][0]["value"] : '';
  $item["email"] = (!empty($location->field_email))? $location->field_email[LANGUAGE_NONE][0]["value"] : '';
  $item["fax"] = (!empty($location->field_fax_number))? $location->field_fax_number[LANGUAGE_NONE][0]["value"] : '';
  $item["site"] = (!empty($location->field_website))? $location->field_website[LANGUAGE_NONE][0]["value"] : '';
  //$item["timezone"] = (!empty($location->field_location_timezone))? $location->field_location_timezone[LANGUAGE_NONE][0]["value"] : '';
  
  $item["sector"]= array();
  foreach($sectors as $item_sector){
    $sector = node_load($item_sector['nid']);
    $url_img = image_style_url('37x36', $sector->field_icon_sector[LANGUAGE_NONE][0]['uri']);
    $item["sector"][] =  $url_img;
  }
  $list[] = $item;
endforeach;

$json_encode = json_encode($list);
$json_encode = str_replace("'", "&#39;", $json_encode);

?>

<section id="<?php print $block_html_id; ?>" data-stores='<?php print $json_encode ?>' data-maps-custom class="map-block <?php print $classes; ?>" <?php print $attributes; ?>>
    
    <div id="store-map"></div>
    <a href="javascript:;" class="find-store-link">
        <span class="wi-icon wi-icon-place"></span>
        <?php print t("Find a store near you"); ?>
    </a>
    
    <div class="see-all-link">
        <a href="javascript:;" class="find-store-link">
            <span class="wi-icon wi-icon-place"></span>
            <?php print t("see all stores");?>
        </a>
    </div>
</section>