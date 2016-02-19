<?php

function v2_feeds_page($share)
{
    global $language;

    $wall_items = v2_feeds_get_wall_items($language);

    if (empty($wall_items)) {
        return MENU_NOT_FOUND;
    }

    $items = array();
    foreach ($wall_items['list-item'] as $wall_item) {
        $items[$wall_item['sfiid']] = array(
            '#message' => $wall_item['message'],
            '#feed_type' => $wall_item['feed_type'],
            '#media_url' => $wall_item['media_url'],
            '#url' => $wall_item['url'],
            '#published' => $wall_item['published'],
            '#username' => $wall_item['username'],
        );
    }

    $build = array(
        '#theme' => 'v2_feeds',
        '#items' => array('list_item' => $items, 'total' =>  $wall_items['total'], 'share' => $share)
    );

    return $build;
}