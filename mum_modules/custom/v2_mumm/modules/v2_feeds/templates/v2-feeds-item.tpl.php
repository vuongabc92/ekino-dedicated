<?php global $base_path; ?>

<li class="social-wall-item <?php print $feed_type; ?>">
	<?php if ($media_url): ?>
	<div class="outer-img">
		<?php print theme('imagecache_external', array('style_name' => 'mumm_social_wall_thumbnail', 'path' => $media_url)) ?>
	</div>
	<?php else: ?>
	<img class="default-img" alt="<?php print $feed_type; ?>" src="<?php print $base_path . drupal_get_path('theme', 'mumm') . '/design/images/default-' . $feed_type . '.png'; ?>" />
	<?php endif ?>
	<p><?php print $message; ?></p>
	<div class="share-box">
		<a class="twitter" data-share="twitter" href="<?php print $url; ?>"><?php print t('twitter'); ?></a>
		<a class="facebook" data-share="fb" href="<?php print $url; ?>"><?php print t('facebook'); ?></a>
	</div>
</li>