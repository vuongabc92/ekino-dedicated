<?php
/**
 * Templating for the click to buy console link
 * text : the text for the link
 * $key : the click to buy remote product key
 * $lang : the language as configured in admin/prctbuyconnector/settings
 * $custom_class : a string class, containing the class set in the field formatter
 */

?>

<a
  href="#"
  title="<?php print $text; ?>"
  data-ctbuy-key="<?php print $key; ?>"
  data-ctbuy-lang="<?php print $lang; ?>"
  class="<?php print $custom_class; ?>"
  target="_blank"
>

    <?php print $text; ?>

</a>
