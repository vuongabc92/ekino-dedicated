<?php
  $locations = get_node_by_type("module_store_location_m2m");
  $list = array();
  if (!empty($locations)):
    foreach ($locations as $location):

      $segments = $location->field_loc_icon_segment[LANGUAGE_NONE];
      $item = array(
          "lat" => $location->field_latitude_longitude[LANGUAGE_NONE][0]["lat"],
          "lng" => $location->field_latitude_longitude[LANGUAGE_NONE][0]["lng"],
          "title" => $location->title,
      );

      $item["tel"] = (!empty($location->field_telephone_number)) ? $location->field_telephone_number[LANGUAGE_NONE][0]["value"] : '';
      $item["email"] = (!empty($location->field_email)) ? $location->field_email[LANGUAGE_NONE][0]["value"] : '';
      $item["fax"] = (!empty($location->field_fax_number)) ? $location->field_fax_number[LANGUAGE_NONE][0]["value"] : '';
      $item["site"] = (!empty($location->field_website)) ? $location->field_website[LANGUAGE_NONE][0]["value"] : '';
      //$item["timezone"] = (!empty($location->field_location_timezone))? $location->field_location_timezone[LANGUAGE_NONE][0]["value"] : '';

      $item["segment"] = array();
      if (!empty($segments)):
        foreach ($segments as $item_segment) {
          $segment = node_load($item_segment['nid']);
          $url_img = image_style_url('37x36', $segment->field_icon_segment_for_get_start[LANGUAGE_NONE][0]['uri']);
          $item["segment"][] = $url_img;
        }
      endif;
      $list[] = $item;
    endforeach;
  endif;

  $json_encode = json_encode($list);
  $json_encode = str_replace("'", "&#39;", $json_encode);
  ?>

  <section data-stores='<?php print $json_encode ?>' data-segment="true" data-maps-custom class="map-block">
    <div id="store-map"></div>
    <a href="javascript:;" class="find-store-link">
      <span class="wi-icon wi-icon-place"></span>
      <?php print t('Find a store near you'); ?>
    </a>
    <div class="see-all-link">
      <a href="javascript:;" class="find-store-link">
        <span class="wi-icon wi-icon-place"></span>
        <?php print t('see all stores'); ?>
      </a>
    </div>
  </section>
