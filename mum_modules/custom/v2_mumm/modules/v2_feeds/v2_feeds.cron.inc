<?php

function v2_feeds_cron() {
  // @todo cooldown check
  _v2_feeds_cron_update();
}

function _v2_feeds_cron_update() {
  if ($feeds = v2_feeds_get_feeds()) {
    foreach ($feeds as $sfid => $feed) {
      v2_feeds_feed_update($feed);
    }
  }
}
