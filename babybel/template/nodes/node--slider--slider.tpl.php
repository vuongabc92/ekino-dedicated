<?php
hide($content['comments']);
hide($content['links']);
global $language;
?>
<?php print render($title_prefix); ?>
<?php print render($title_suffix); ?>
<div class="slider-block banner-slide">
    <div class="slide-wrap">
        <div class="slide-content"  data-set-nav-position="true" data-slider data-slide=".item">
            <?php if (isset($content['field_slides']['#items'])): ?>
              <?php
              foreach ($content['field_slides']['#items'] as $item):
                $field = field_collection_item_load($item['value']);
                $ext_link = isset($field->field_cta_link[LANGUAGE_NONE][0]['url']) ? url_is_external($field->field_cta_link[LANGUAGE_NONE][0]['url']) : '';
                ?>
                <div class="item"><img src="<?php print image_style_url('1440x660', $field->field_picture[LANGUAGE_NONE][0]['uri']); ?>" alt="Cover images">
                    <div class="wrap-content">
                        <div class="content">
                            <h2 class="title"><?php print $field->field_slide_title[LANGUAGE_NONE][0]['value']; ?></h2>
                            <p class="desc"><?php print isset($field->field_content [LANGUAGE_NONE][0]['value']) ? nl2br($field->field_content [LANGUAGE_NONE][0]['value']) : ''; ?></p>
                            <?php if (isset($field->field_cta_link[LANGUAGE_NONE][0]['url'])): ?>
                              <?php if ($ext_link): ?>
                                <a  <?php print ($ext_link) ? 'target="_blank"' : ''; ?> href="<?php print $field->field_cta_link[LANGUAGE_NONE][0]['url']; ?>" title="<?php print $field->field_cta_link[LANGUAGE_NONE][0]['title']; ?>" class="btn-viewmore">
                                    <?php print $field->field_cta_link[LANGUAGE_NONE][0]['title']; ?>
                                </a>
                              <?php else: ?>
                                <a href="<?php print url($field->field_cta_link[LANGUAGE_NONE][0]['url']); ?>" title="<?php print $field->field_cta_link[LANGUAGE_NONE][0]['title']; ?>" class="btn-viewmore">
                                    <?php print $field->field_cta_link[LANGUAGE_NONE][0]['title']; ?>
                                </a>
                              <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>