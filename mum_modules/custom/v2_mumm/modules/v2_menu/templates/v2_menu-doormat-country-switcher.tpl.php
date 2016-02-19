<?php
/**
 * @file v2_menu-doormat-country-switcher.tpl.php.
 * Render template for conutry
 *
 */
?>
<?php
if ($block_region == 'popup') :
  $prefix = '<div data-popup id="popup-location" class="popup">'
      . '<a href="javascript:;" title="' . _hs_resource_get('close','plain', FALSE, FALSE) . '" class="btn-close">'
      . '<span class="line"></span><span class="line"></span></a>'
      . '<div class="content">'
      . '<div class="inner">'
      . '<div id="change-location" class="choose-country">'
      . '<div class="grid-fluid">';
  $suffix = '</div></div></div></div></div>';
else :
  $prefix = '<div data-toggle data-is-scroll="true" data-id="change-location" class="choose-country hidden-xs">'
      . '<div class="inner">'
      . '<a href="javascript:;" title="' . _hs_resource_get('close','plain', FALSE, FALSE) . '" class="icon icon-close btn-close">' . _hs_resource_get('close','plain', FALSE, FALSE) . '</a>';
  $suffix = '</div></div>';
endif;
?>
<?php
print $prefix;
?>
<h2 class="title-country"><?php print _hs_resource_get('doormat_menu_header_text'); ?></h2>
<div class="list-area" data-change-locations>
  <?php foreach ($links_per_region as $region_name => $country_options):
    ?>
    <div class="area">
      <h3 class="title-area">
        <?php
        $region_name = explode("_",$region_name);
        print $region_name[1];
        ?>
      </h3>
      <ul>
        <?php foreach ($country_options as $language_code => $link): ?>
          <?php if (isset($link['href'])): ?>
              <li><a href="<?php print url($link['href'], array('language' => $link['language'])); ?>" data-country-code ="<?php print $language_code; ?>"><?php print $link['name']; ?></a></li>
          <?php endif; ?>
        <?php endforeach ?>
      </ul>
    </div>
<?php endforeach; ?>
</div>
<?php print $suffix; ?>
