<?php
global $base_url;
unset($form['name']['#title']);
unset($form['name']['#description']);
unset($form['pass']['#title']);
unset($form['pass']['#description']);
?>
<div class="container login-block">
  <ul>
    <li>
      <h2 class="title-2 text-blue"><?php print t('Login');?></h2>
      <ul>        
        <li><?php print render($form['name']); ?></li>
        <li><?php print render($form['pass']); ?></li>
        <li class="btn-log">
          <?php print render($form['actions']); ?>
        </li>
        <div style="display:none;">
          <?php print drupal_render_children($form); ?>
        </div>
      </ul>
    </li>
  </ul>
</div>