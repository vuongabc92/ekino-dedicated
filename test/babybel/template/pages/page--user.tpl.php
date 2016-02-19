<?php print theme('babybel_cookie_banner'); ?>
<?php if (theme_get_setting('mothership_poorthemers_helper')) { ?>
  <!-- page.tpl.php-->
<?php } ?>
<?php print $mothership_poorthemers_helper; ?>
<div class="app">
    <header class="header">
        <?php print render($page['header']); ?>
    </header>
    <?php if ($page['highlighted'] OR $messages) { ?>
      <div class="drupal-messages">
          <?php print render($page['highlighted']); ?>
          <?php print $messages; ?>
      </div>
    <?php } ?>
    <!--data-type="open|closed|archives"-->
    <div id="user-page" data-type="open" class="user-login">
        <?php print render($page['content']); ?>
    </div>
    <footer class="footer">
        <?php print render($page['footer']); ?>
    </footer>
</div>