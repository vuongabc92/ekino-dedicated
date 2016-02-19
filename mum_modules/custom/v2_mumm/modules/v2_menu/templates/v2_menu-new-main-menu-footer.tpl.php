<?php
/**
 * @file v2_menu-new-main-menu-footer.tpl.php.
 * Render template for new main menu in footer
 *
 */
$new_main_menu = $list_menu['menu-new-main-menu'];
unset($new_main_menu['#sorted']);
unset($new_main_menu['#theme_wrappers']);
?>
<?php
foreach ($new_main_menu as $key => $menu_item) :
  $class_active = '';
  $class_last = '';
  if (in_array('last', (array) $menu_item['#attributes']['class'])):
    $class_last = ' last';
  endif;
  if (current_path() == $menu_item['#href'] || (drupal_is_front_page() && $menu_item['#href'] == '<front>')):
    $class_active = 'active';
  endif;
  ?>
  <div class="col<?php print $class_last; ?>">
      <?php if (in_array('hidden', (array) $menu_item['#localized_options']['attributes']['class']) == FALSE) : ?>
        <h3 class="link-title">
            <a href="<?php print url($menu_item['#href']); ?>" class="<?php print $class_active; ?>"
              data-tracking data-track-action="click" data-track-category="footer" data-track-label="<?php print strtolower($menu_item['#title']); ?>" data-track-type="event">
              <?php print $menu_item['#title']; ?>
            </a>
        </h3>
      <?php endif; ?>
      <?php
      if (isset($menu_item['#below']) && count($menu_item['#below']) > 0) :
        unset($menu_item['#below']['#sorted']);
        unset($menu_item['#below']['#theme_wrappers']);
        if (in_array('last', (array) $menu_item['#attributes']['class'])) :
          foreach ($menu_item['#below'] as $key => $value) :
            $class = $value['#localized_options']['attributes']['class'];
            $value['#localized_options']['attributes'] = array(
              'class' =>$class,
              'data-tracking' => '',
              'data-track-action' => 'click',
              'data-track-category' => 'footer',
              'data-track-label' => 'book_a_visit',
              'data-track-type' => 'event',
            );

            $output = l($value ['#title'], $value ['#href'], $value ['#localized_options']);
            print $output;
          endforeach;
        else:
          ?>
          <ul class="links">
              <?php
              foreach ($menu_item['#below'] as $key => $value) :
                ?>
                <li>
                    <?php
                    if ($value ['#localized_options']['fragment']):
                      $value['#localized_options']['attributes']['data-change-href'] = $value['#href'] . '?filter=' . $value ['#localized_options']['fragment'];
                    endif;
                    $value['#localized_options']['attributes'] = array(
                      'class' =>$class,
                      'data-tracking' => '',
                      'data-track-action' => 'click',
                      'data-track-category' => 'footer',
                      'data-track-label' => strtolower($value ['#title']),
                      'data-track-type' => 'event',
                    );
                    $output = l($value ['#title'], $value ['#href'], $value ['#localized_options']);
                    print $output;
                    ?>
                </li>
                <?php
              endforeach;
              ?>
          </ul>
        <?php
        endif;
      endif;
      ?>
  </div>
<?php endforeach; ?>
