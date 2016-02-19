<?php
global $language;

?>
<p><?php print v2_age_gate_variable_get('instructions', $language->language); ?></p>
<div class="form-group form-group-1">
    <div class="dropdown custom-dropdown">
        <button type="button" class="btn-dropdown dropdown-toggle"></button>
        <?php print render($form['country']); ?>
    </div>
</div>
<div class="form-group">
    <label class="label-date"><?php print t('Date of your birth'); ?></label>
    <div data-hide-label-agegate data-name="#country-birthday">
      <?php print render($form['birthdate']); ?>
    </div>
</div>
<?php print render($form['country-hidden']); ?>
<?php print render($form['submit']); ?>
<?php print drupal_render_children($form); ?>