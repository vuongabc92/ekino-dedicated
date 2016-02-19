<?php
/**
 * @file template theme form newsletter.
 */
global $language;
$path = baybel_get_path('images');
?>
<div class="insert-form-block">
    <div class="row">
        <div class="col-md-5 thumb">
            <?php print babybel_contextual_render('image_form_input_newsletter'); ?>
        </div>
        <div class="col-md-7 content-input">
            <div class="form-group style-1">
                <div class="wrap-input wrap-first-name">
                    <div class="item">
                        <?php print render($form['submitted']['first_name']); ?>
                    </div>
                </div>
                <div class="wrap-input wrap-last-name">
                    <div class="item">
                        <?php print render($form['submitted']['last_name']); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="wrap-input wrap-email">
                    <div class="item">
                        <?php print render($form['submitted']['email']); ?>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <?php print render($form['actions']['submit']); ?>
            </div>

        </div>
    </div>
</div>

<?php print drupal_render_children($form); ?>
