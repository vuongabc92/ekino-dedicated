<?php
/**
 * @file
 * v2-mumm-custom-webform-email.tpl.php.
 */
global $language, $base_url;

$path = v2_mumm_custom_get_path('images');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <style type="text/css">
      #outlook a{padding:0; text-decoration: none!important;}
      #outlook a:visited{color: transparent!important;}
      .ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
      .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
      body, table, td, a{-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;}
      table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;}
      img{-ms-interpolation-mode:bicubic;}
      body{margin:0; padding:0;}
      img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
      table{border-collapse:collapse !important;}
      body{height:100% !important; margin:0; padding:0; width:100% !important;}
      .appleBody a {color:#68440a; text-decoration: none;}
      .appleFooter a {color:#999999; text-decoration: none;}
      fieldset{ border: none; padding: 0; margin: 0;}
    </style>
  </head>
<body style="margin: 0; padding: 0;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff">
      <tr>
        <td align="center">
          <table border="0" cellpadding="0" cellspacing="0" style=" width: 600px;">
            <tr>
              <td bgcolor="#ffffff" valign="top" align="center" style="padding: 48px 0 0; color: #000000; text-decoration: none;">
                <a href="<?php print $base_url. '/' .$language->prefix; ?>" title="<?php print t('Home'); ?>" target="_blank">
                  <img alt="Logo" src="<?php print $path; ?>logo-top-3.jpg" width="166" height="89" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #000000; font-size: 16px;" border="0">
                </a>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff">
      <tr>
        <td align="center">
          <table border="0" cellpadding="0" cellspacing="0" style=" width: 420px;">
            <tr>
              <td bgcolor="#ffffff" valign="top" style="padding: 56px 0 0 10px; color: #000000; text-decoration: none;">
                <p style="font-size: 12px; color: #000000; font-family: Arial, sans-serif; margin: 0; padding: 0; line-height: 1.8;"><?php print nl2br($message); ?></p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff">
      <tr>
        <td align="center" style=" padding-bottom: 19px;">
          <table border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style=" width: 600px;">
            <tr>
              <td bgcolor="#ffffff" valign="top" align="center" style="color: #000000; text-decoration: none; padding: 46px 0 18px;"><img alt="line" src="<?php print $path; ?>line-gray.jpg" width="420" height="1" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #000000; font-size: 16px;" border="0"></td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" valign="top" align="center" style="color: #000000; text-decoration: none;">
                  <a href="<?php print $base_url. '/' .$language->prefix; ?>" title="<?php print t('Home'); ?>" target="_blank">
                    <img alt="logo bottom" src="<?php print $path; ?>logo-bottom.jpg" width="55" height="37" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #000000; font-size: 16px;" border="0">
                  </a>
                </td>
            </tr>
            <tr>
              <td bgcolor="#ffffff" valign="top" align="center" style="color: #000000; text-decoration: none; padding-top: 13px;">
                <p style="font-size: 10px; color: #000000; font-family: Arial, sans-serif; margin: 0; padding: 0; text-transform: uppercase;"><?php print v2_age_gate_variable_get('mention_health', $language->language);  ?> </p>
              </td>
            </tr>
            <tr>
              <td bgcolor="#ffffff" valign="top" align="center" style="color: #ffffff; text-decoration: none; padding-top: 19px;">
                <table border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style=" width: 420px;">
                  <tr>
                    <?php print $email_menu_footer; ?>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td bgcolor="#ffffff" valign="top" align="center" style="color: #000000; text-decoration: none; padding: 22px 0 0;"><img alt="line" src="<?php print $path; ?>line-gray.jpg" width="420" height="1" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #000000; font-size: 16px;" border="0"></td>
            </tr>
            <tr>
              <?php print $email_menu_footer_policy; ?>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
