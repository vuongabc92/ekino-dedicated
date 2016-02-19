<?php
/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>

<section class="block-9 social-media-block">
    <div class="container">
        <h1 class="title-1 text-light-gray-2"><?php print t('Social media feed'); ?></h1>
        <div class="inner">
            <button data-block-filter="true" data-fill-class="all" type="button" id="btn-social" name="btn-social" class="text-uppercase btn-1 active">See all</button>
            <ul class="social-list">
                <li>
                    <button data-block-filter="true" data-fill-class="in" type="button" id="btnIn" name="btnIn" class="wi-icon wi-icon-linked-in-grey"></button>
                </li>
                <li>
                    <button data-block-filter="true" data-fill-class="youtube" type="button" id="btnYoutube" name="btnYoutube" class="wi-icon wi-icon-youtube-grey"></button>
                </li>
                <li>
                    <button data-block-filter="true" data-fill-class="twitter" type="button" id="btnTwitter" name="btnTwitter" class="wi-icon wi-icon-twitter-grey"></button>
                </li>
                <li>
                    <button data-block-filter="true" data-fill-class="instagram" type="button" id="btnInstagram" name="btnInstagram" class="wi-icon wi-icon-instagram-grey"></button>
                </li>
                <li>
                    <button data-block-filter="true" data-fill-class="facebook" type="button" id="btnFacebook" name="btnFacebook" class="wi-icon wi-icon-facebook-grey"></button>
                </li>
            </ul>
        </div>
    </div>
</section>

<section class="feed-list">
    <div class="container">
        <div data-masonry class="masonry">
            <?php
            $i = 0;
            $limit = intval(variable_get('social_feed_limit', 10));
            if ($limit < 0) {
              $limit = 10;
            }
            ?>
            <?php foreach ($rows as $row): ?>
              <?php if ($limit >= 0 && ($i < $limit || $limit == 0)): ?>
                <?php print $row; ?>
              <?php endif ?>
              <?php $i++; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="block-9 follow-block">
    <div class="container">
        <ul class="social-list">
            <li>
                <a target="_blank" href="<?php print variable_get('thu_variables_link_header_linkedIn'); ?>"><button type="button" id="btn-in" name="btn-in" class="wi-icon wi-icon-linked-in-blue"></button></a>
            </li>
            <li>
                <a target="_blank" href="<?php print variable_get('thu_variables_link_header_youTube'); ?>"><button type="button" id="btn-youtube" name="btn-youtube" class="wi-icon wi-icon-youtube-blue"></button></a>
            </li>
            <li>
                <a target="_blank" href="<?php print variable_get('thu_variables_link_header_twitter'); ?>"><button type="button" id="btn-twitter" name="btn-twitter" class="wi-icon wi-icon-twitter-blue"></button></a>
            </li>
            <li>
                <a target="_blank" href="<?php print variable_get('thu_variables_link_header_instagram'); ?>"><button type="button" id="btn-instagram" name="btn-instagram" class="wi-icon wi-icon-instagram-blue"></button></a>
            </li>
            <li>
                <a target="_blank" href="<?php print variable_get('thu_variables_link_header_facebook'); ?>"><button type="button" id="btn-facebook" name="btn-facebook" class="wi-icon wi-icon-facebook-blue"></button></a>
            </li>
        </ul>
        <h1 class="title-1 text-blue"><?php print t('Follow us'); ?></h1>
    </div>
</section>

<?php print theme('thu_store_location'); ?>

