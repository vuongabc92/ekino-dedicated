<?php
global $language;
$path = baybel_get_path('images');
$current_lang = $language->language;
$webform = babybel_variable_get('babybel_variable_newsletter_webform_id', $current_lang);
$title = babybel_variable_get('babybel_variable_newsletter_form_input_title', $current_lang, 'SUBSCRIBE TO OUR NEWSLETTER');
$image_form_id = babybel_variable_get('babybel_variable_newsletter_form_success_image', $current_lang);
$image_form_file = file_load($image_form_id);
if ($image_form_file) {
  $image_url = image_style_url('275x225', $image_form_file->uri);
}
$success_content = babybel_variable_get('babybel_variable_newsletter_form_success_content', $current_lang);
$success_cta = babybel_variable_get('babybel_variable_newsletter_form_success_cta_link', $current_lang);
?>
<?php if ($webform): ?>
  <div class="popin popin-newsletter hidden">
      <div class="popin-wrapper">
          <div class="popin-content">
              <div class="container">
                  <a href="javascript:;" title="<?php print t('Close'); ?>" class="btn-close-popin">
                      <span class="icon-close-1"></span>
                  </a>
                  <?php print babybel_contextual_render('title_form_newsletter'); ?>
                  <div id="form-content-wrapper">
                      <?php
                      $submission = array();
                      $enabled = TRUE;
                      $preview = FALSE;
                      $node = node_load($webform);
                      $node_status = isset($node->status) ? $node->status : 0;
                      if($node_status) {
                        print render(drupal_get_form('webform_client_form_' . $webform, $node, $submission, $enabled, $preview));
                      }
                      ?>
                      <div class="success-form-block content-block" style="display: none;">
                          <div class="content">
                            <?php print babybel_contextual_render('image_form_success_newsletter'); ?>
                            <?php print babybel_contextual_render('message_form_success_newsletter'); ?>
                            <?php print babybel_contextual_render('button_form_success_newsletter'); ?>

                              <!-- <div class="photo"><img src="<?php //print $image_url; ?>" alt="">
                              </div>
                              <div class="desc">
                                  <p><?php //print isset($success_content['value']) ? nl2br($success_content['value']) : ''; ?></p>
                              </div>
                              <?php //if ($success_cta['url']): ?>
                                <a href="<?php //print $success_cta['url']; ?>" title="<?php print $success_cta['title']; ?>" class="btn-green"><?php print $success_cta['title']; ?></a>
                              <?php //endif; ?> -->
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
<?php endif; ?>