<?php
/**
 * @file
 * email-menu-footer-policy.tpl.php.
 */
global $base_url, $language;
$email_menu_policy = $list_menu['menu-doormat'];

unset($email_menu_policy['#sorted']);
unset($email_menu_policy['#theme_wrappers']);
$email_menu_footer_policy = array_values($email_menu_policy);
?>

<?php
if ($email_menu_footer_policy):
?>
  <td bgcolor="#ffffff" valign="top" align="center" style="color: #ffffff; text-decoration: none; padding: 10px 0 30px;">
    <p style="font-size: 8px; color: #000000; font-family: Arial, sans-serif; text-align: center; margin: 0; padding: 0; text-decoration: none;">
    <?php
      foreach ($email_menu_footer_policy as $key => $item):
        $email_url = '';
        if(isset($item['#href'])):
          $href_array = explode('/', $item['#href']);
          if ($href_array[0] == 'node' && is_numeric($href_array[1])):
            $node = node_load($href_array[1]);
            $email_url = $base_url . '/' . $language->prefix .'/node/' . $node->nid;
          else:
            $email_url = $item['#href'];
          endif;
        endif;
    ?>
      <a href="<?php print $email_url; ?>" target="_blank" title="<?php print $item['#title']; ?>" style="display: inline-block; color: #000000; font-size: 8px; text-transform: uppercase; text-decoration: none;"><?php print $item['#title']; ?></a>
      <?php if ($key < (count($email_menu_footer_policy) - 1)): ?>
        &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <?php
        endif;
      endforeach;
      ?>
    </p>
  </td>
<?php
endif;
?>
