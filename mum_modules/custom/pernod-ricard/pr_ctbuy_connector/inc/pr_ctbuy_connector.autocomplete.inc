<?php

function pr_ctbuy_connector_autocomplete_products($string) {

  // All the checks have already been done to this point, we can directly query
  // the console.

  list($key, $url, $instance) = array(
    pr_ctbuy_connector_get_var_auto('pr_ctbuy_connector_key'),
    pr_ctbuy_connector_get_var_auto('pr_ctbuy_connector_endpoint'),
    pr_ctbuy_connector_get_var_auto('pr_ctbuy_connector_instance'),
  );

  $data = '?instance=' . $instance . '&search=' . $string;
  $options = array(
    'method' => 'GET',
    'timeout' => 15,
    'headers' => array(
      'X-PR-ACCESSKEY' => $key,
    ),
  );

  $result = drupal_http_request($url . '/getListForInstance' . $data, $options);

  $data = $result->data;

  print $data;
  drupal_exit();

}
