<?php
/**
 * @file v2_menu-menu-popup.tpl.php.
 * Render template popup for mobile
 *
 */
$new_main_menu = $list_menu['menu-new-main-menu'];
$menu_header = $list_menu['menu-header'];
unset($new_main_menu['#sorted']);
unset($new_main_menu['#theme_wrappers']);
unset($menu_header['#theme_wrappers']);
unset($menu_header['#sorted']);
$form_search = drupal_get_form('v2_search_custom_form');
$form_search = v2_search_custom_form_mobile($form_search);
?>
<div data-popup id="popup-mobile" class="popup mobile-navigation">
    <div class="overlay white">&nbsp;</div>
    <a href="javascript:;" title="<?php print _hs_resource_get('close','plain', FALSE, FALSE) ; ?>" class="btn-close">
        <span class="line"></span><span class="line"></span></a>
    <div class="content">
        <div class="inner">
            <nav class="main-menu-mobile">
                <?php
                // Get logo for header and footer.
                $file = file_load(variable_get('logo_header_mobile', 0));
                if ($file) :
                  print '<a href="'.url('<front>').'" title="' . t('Home') . '"';
                  print 'data-tracking data-track-action="click" data-track-category="header" data-track-label="logo" data-track-type="event">';
                  print '<img class="logo" src="' . file_create_url($file->uri) . '" alt="' . t('Home') . '" /></a>';
                endif
                ?>
                <ul>
                    <?php foreach ($new_main_menu as $key => $menu_item) : ?>
                      <?php if (in_array('hidden', $menu_item['#localized_options']['attributes']['class']) == FALSE): ?>
                        <li>
                            <?php
                            $class = $menu_item['#localized_options']['attributes']['class'];
                            $menu_item['#localized_options']['attributes'] = array(
                              'class' =>$class,
                              'data-tracking' => '',
                              'data-track-action' => 'click',
                              'data-track-category' => 'header',
                              'data-track-label' => strtolower($menu_item ['#title']),
                              'data-track-type' => 'event',
                            );

                            $output = l($menu_item ['#title'], $menu_item ['#href'], $menu_item ['#localized_options']);
                            print $output;
                            ?>
                        </li>
                      <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
                <div class="tool-box">
                    <?php
                    foreach ($menu_header as $menu_item) :
                      if (in_array('search-btn', $menu_item['#localized_options']['attributes']['class'])) :
                        print '<a href="javascript:;" title="' . $menu_item ['#title'] . '" class="icon icon-search-gray search-btn" data-trigger-toggle="search-box-mobile"'
                              . 'data-tracking data-track-action="click" data-track-category="header" data-track-label="search" data-track-type="event">'
                              . $menu_item ['#title'] . '</a>';
                      else :
                        $class = $menu_item['#localized_options']['attributes']['class'];
                        $menu_item['#localized_options']['attributes'] = array(
                          'class' =>$class,
                          'data-tracking' => '',
                          'data-track-action' => 'click',
                          'data-track-category' => 'header',
                          'data-track-label' => 'book_a_visit',
                          'data-track-type' => 'event',
                        );

                        print l($menu_item ['#title'], $menu_item ['#href'], $menu_item ['#localized_options']);
                      endif;
                    endforeach;
                    ?>
                    <div data-toggle data-id="search-box-mobile" data-overlay-selector=".mobile-navigation .overlay.white" data-is-scroll="true" data-scroll-wrapper="#popup-mobile .content .inner" class="search-box search-box-mobile">
                        <?php print drupal_render($form_search); ?>
                    </div>
                    <a href="javascript:;" title="<?php print trim(_hs_resource_get('change_location','plain', FALSE, FALSE)); ?>" class="location" data-trigger-popup="popup-location"
                      data-tracking data-track-action="click" data-track-category="footer" data-track-label="<?php print trim(_hs_resource_get('change_location','plain', FALSE, FALSE)); ?>" data-track-type="event">
                      <?php print trim(_hs_resource_get('change_location','plain', FALSE, FALSE)); ?>
                    </a>
                </div>
            </nav>
        </div>
    </div>
</div>