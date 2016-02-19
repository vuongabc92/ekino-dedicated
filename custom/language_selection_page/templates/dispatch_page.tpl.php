<?php
global $base_url;
if (count($links)) :
  $language_list = language_list();
  $destination = ($_GET['destination'] != '<front>') ? $_GET['destination'] : '';
  unset($links['#sorted'], $links['#theme_wrappers']);
  $count = 1;
  foreach ($links as $link) :
    ?>
    <?php
    if (count($link['#below'])) :
      unset($link['#below']['#sorted'], $link['#below']['#theme_wrappers']);
      //print '<ul class="child-items">';
      print '<div class="item">
                  <div data-content-id="' . $count . '" class="tab-title">
                    <h3>' . $link['#title'] . '</h3>
                  </div>
                  <div data-id="' . $count . '" class="tab-content">';
      if (count($link['#below']) > 4) {
        print '<ul class="lists multi-col">';
      }
      else {
        print '<ul class="lists">';
      }
      foreach ($link['#below'] as $mlid => $below) :
        $target = '';
        $entity = menu_fields_load_by_mlid($mlid);
        if (isset($entity->field_language_code[LANGUAGE_NONE][0]['value']) &&
          !empty($entity->field_language_code[LANGUAGE_NONE][0]['value'])) {
          $language_item = $language_list[$entity->field_language_code[LANGUAGE_NONE][0]['value']];
          $url = $language_item->prefix;
          $path = babybel_common_url_get_multi_domain($entity->field_language_code[LANGUAGE_NONE][0]['value'], $language_item->prefix, $below['#href']);
          if (url_is_external($below['#href'])) {
            $target = 'target="_blank"';
          }
        }
        else {
          $path = babybel_common_url_get_multi_domain('', 'en-gb', $below['#href']);
          $target = 'target="_blank"';
        }
        ?>
        <li><a href="<?php print $path; ?>" <?php print $target; ?> title="<?php print $below['#title']; ?>"><?php print $below['#title']; ?></a></li>
        <?php
      endforeach;
      print '</ul></div></div>';
    endif;
    ?>
    <?php
    $count ++;
  endforeach;
  //print '</ul></div>';
endif;