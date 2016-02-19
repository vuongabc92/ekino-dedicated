<?php
/*
 * @file
 * v2-newsletter.tpl.php.
 */
$newsletter_get_language = _hs_resource_get('Newsletter','plain', FALSE, FALSE, FALSE, 'Newsletter');
$newsletter = '<a href="'.$link.'" title="'.$newsletter_get_language.'" class="btn btn-white"'
    . 'data-tracking data-track-action="click" data-track-category="newsletter" data-track-label="cta" data-track-type="event">'.$newsletter_get_language.'</a>';
?>
<div class="newsletter margin-top">
  <div class="grid-fluid">
    <div class="inner">
      <h2 class="newsletter-title"><?php print $title; ?></h2>
      <div class="subscribe">
        <h3 class="title-1"><?php print $link_title; ?></h3>
        <?php print hs_resource_contextual_link('Newsletter', $newsletter);?>
      </div>
      <div class="social-block">
        <h3 class="title-1"><?php print _hs_resource_get('follow_us', 'plain', FALSE, TRUE, FALSE, 'FOLLOW US');?></h3>
        <ul class="socials">
          <?php if ($facebook['link']):?>
            <li>
              <a target="_blank" href="<?php print $facebook['link']; ?>" title="<?php print $facebook['title']; ?>" class="icon icon-fb"
                data-tracking data-track-action="cta" data-track-category="newsletter" data-track-label="facebook" data-track-type="event">
                <?php print $facebook['title']; ?>
              </a>
            </li>
            <?php
          endif;
          if ($twitter['link']) :
            ?>
            <li>
              <a target="_blank"  href="<?php print $twitter['link']; ?>" title="<?php print $twitter['title']; ?>" class="icon icon-tw"
                data-tracking data-track-action="cta" data-track-category="newsletter" data-track-label="twitter" data-track-type="event">
                <?php print $twitter['title']; ?>
              </a>
            </li>
            <?php
          endif;
          if ($youtube['link']) :
            ?>
            <li>
              <a target="_blank" href="<?php print $youtube['link']; ?>" title="<?php print $youtube['title']; ?>" class="icon icon-yt"
                data-tracking data-track-action="cta" data-track-category="newsletter" data-track-label="youtube" data-track-type="event">
                <?php print $youtube['title']; ?>
              </a>
            </li>
            <?php
          endif;
          if ($instagram['link']) :
            ?>
            <li>
              <a target="_blank" href="<?php print $instagram['link']; ?>" title="<?php print $instagram['title']; ?>" class="icon icon-ig"
                data-tracking data-track-action="cta" data-track-category="newsletter" data-track-label="instagram" data-track-type="event">
                <?php print $instagram['title']; ?>
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</div>