<?php
hide($content['comments']);
hide($content['links']);
global $language;
?>
<?php print render($title_prefix); ?>
<?php print render($title_suffix); ?>

<h2 class="title-1 white-color"><?php print $node->title; ?></h2>
<div class="text-description-2">
    <p><?php print nl2br($node->field_content_secret[LANGUAGE_NONE][0]['value']); ?></p>
</div>
<div data-step-show class="list-steps">
    <?php
    $steps = $node->field_steps[LANGUAGE_NONE];
    if ($steps):
      foreach ($steps as $step):
        $field = field_collection_item_load($step['value']);
        ?>
        <div class="item">
            <div class="inner clearfix">
                <div class="thumb">
                    <div class="img-circle">
                        <img src="<?php print image_style_url('240x240', $field->field_picture_step[LANGUAGE_NONE][0]['uri']); ?>" alt="<?php print $filed->field_title_secret[LANGUAGE_NONE][0]['value'] ?>">
                    </div>
                </div>
                <div class="content ">
                    <div class="inner-1">
                        <h3 class="title-3"><span><?php print $field->field_title_secret[LANGUAGE_NONE][0]['value'] ?></span></h3>
                        <div class="desc">
                            <p><?php print nl2br($field->field_content_step[LANGUAGE_NONE][0]['value']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
      endforeach;
    endif;
    ?>
    <div class="item">
        <div class="inner clearfix">
            <div class="thumb">
                <div class="img-circle">
                    <img src="<?php print image_style_url('315x315', $node->field_final_picture[LANGUAGE_NONE][0]['uri']); ?>" alt="<?php print $node->title; ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-description"><strong><?php print $node->field_final_text[LANGUAGE_NONE][0]['value'] ?></strong></div>
<!--<div class="text-center">
    <a href="<?php //print url('products'); ?>" title="<?php //print t('Discover all products'); ?>" class="btn-viewmore style-2"><?php //print t('Discover all products'); ?></a>
</div>-->

<?php print babybel_contextual_render('button_discover_all_products_our_secret'); ?>