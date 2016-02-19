<?php
$first_block_id = babybel_variable_get_nid_translated('babybel_variable_funstuff_first_id');
$supercheese_block_id = babybel_variable_get_nid_translated('babybel_variable_funstuff_supercheese_id');
$first_block_data_node = ($first_block_id) ? node_load($first_block_id) : NULL;
$supercheese_data_node = ($supercheese_block_id) ? node_load($supercheese_block_id) : NULL;
$arr_fun_stuff = babybel_fun_stuff_get_fun_stuff();
if (empty($first_block_data_node) && empty($supercheese_data_node) && empty($arr_fun_stuff)) {
  drupal_goto('<front>');
}
?>
<div class="talking-cheese" data-type="open" >
    <?php print babybel_contextual_render('background_header_fun_stuff'); ?>

    <div class="block-2 intro-block">
        <?php
        if ($first_block_id) {
          $first_block = node_load($first_block_id);
          $status_first_block = isset($first_block->status) ? $first_block->status : 0;
          if ($first_block && $status_first_block) {
            print '<div class="container">';
            $view_first_block = node_view($first_block, 'article_fun_stuff_first');
            print drupal_render($view_first_block);

            if (isset($first_block->field_video_player[LANGUAGE_NONE][0]['nid'])) {
              $video_nid = babybel_variable_get_nid_node_translated($first_block->field_video_player[LANGUAGE_NONE][0]['nid'], $first_block_id);
              $video = node_load($video_nid);
              $video_status = isset($video->status) ? $video->status : 0;
              if ($video && $video_status) {
                $view_video = node_view($video, 'video_player');
                print drupal_render($view_video);
              }
            }
            print '</div>';
          }
        }
        ?>
    </div>
    <!-- .intro-block -->

    <div class="block-2 style-1 information-block">
        <div class="container">
            <?php
            if ($supercheese_block_id) {
              $supercheese_block = node_load($supercheese_block_id);
              $status_supercheese_block = isset($supercheese_block->status) ? $supercheese_block->status : 0;
              if ($supercheese_block && $status_supercheese_block) {
                $view_supercheese_block = node_view($supercheese_block, 'article_fun_stuff_supercheese');
                print drupal_render($view_supercheese_block);
              }
            }
            ?>

            <?php
            if ($arr_fun_stuff) {
              ?>

              <div class="detail-list">
                  <?php
                  foreach ($arr_fun_stuff as $fun_stuff) {
                    $view_fun_stuff = node_view($fun_stuff, 'fun_stuff');
                    print drupal_render($view_fun_stuff);
                    ?>
                  <?php } ?>
              </div>
              <!-- .detail-list -->

            <?php } ?>
        </div>
        <!-- .container -->
    </div>
    <!-- .information-block -->

    <div class="block-2 wax-tutorial-block">
        <div class="container">
            <?php print babybel_contextual_render('background_footer_fun_stuff'); ?>
        </div>
    </div>
    <!-- .wax-tutorial-block -->


</div>
<!-- .talking-cheese -->
