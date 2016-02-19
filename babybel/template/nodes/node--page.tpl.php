<?php
global $language;

hide($content['comments']);
hide($content['links']);

$privacy_cover_image = babybel_variable_get('babybel_variable_privacy_page_id', $language->language, '');
$termcondition_cover_image = babybel_variable_get('babybel_variable_term_conditions_page_id', $language->language, '');

$cover_image = '';
if($node->nid == $privacy_cover_image) {
  $cover_image = 'background_header_privacy_page';
} elseif($node->nid == $termcondition_cover_image) {
  $cover_image = 'background_header_term_conditions_page';
}

?>
<div id="term" data-type="open">
<!--    <div class="page-cover visible-md visible-lg">
        <img src="" alt="Babybel">
    </div>-->
    <?php print babybel_contextual_render($cover_image); ?>
    <div class="block-2 policy-block">
        <div class="container">
            <?php print render($title_prefix); ?>
            <?php print render($title_suffix); ?>
            <h2 class="title-1"><?php print $node->title; ?></h2>
            <div class="terms-box custom-editor">
                <?php print render($content); ?>
            </div>
        </div>
    </div>
</div>