<?php

/**
 * @file
 * email-menu-footer.tpl.php.
 */

global $language, $base_url;
$path = v2_mumm_custom_get_path('images');
$email_main_menu = $list_menu['menu-new-main-menu'];
unset($email_main_menu['#sorted']);
unset($email_main_menu['#theme_wrappers']);
$email_main_menu = array_values($email_main_menu);
?>

<?php
if($email_main_menu):
  foreach ($email_main_menu as $key => $item) :
    $email_url = '';
    if (isset($item['#href'])):
      $href_array = explode('/', $item['#href']);
      if ($href_array[0] == 'node' && is_numeric($href_array[1])):
        $node = node_load($href_array[1]);
        $email_url = $base_url . '/' . $language->prefix . '/node/' . $node->nid;
        elseif ($href_array[0] == '<front>'):
          $email_url = $base_url . '/' . $language->prefix;
        else:
        $email_url = $item['#href'];
      endif;
    endif;
?>
<td valign="center" align="center" style="color: #000000; text-decoration: none;">
  <a href="<?php print $email_url; ?>" target="_blank" title="<?php print $item['#title'] ?>" style="display: inline-block; color: #cbcbcb; text-decoration: none; font-size: 10px;text-transform: uppercase;"><?php print $item['#title'] ?></a>
</td>
<?php if($key < (count($email_main_menu)) - 1): ?>
<td valign="center" align="center" style="color: #000000; text-decoration: none;">
  <img alt="line" src="<?php print $path; ?>transparent.png" width="34" height="9" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #000000; font-size: 16px; width: 34px; height: 9px;" border="0">
</td>
<?php endif; ?>
<?php
  endforeach;
endif;
?>
