<?php
global $language;
$current_lang = $language->language;
$image_path = baybel_get_path('images');
?>
<style>
    .contextual-links-region:hover a.contextual-links-trigger {
        display: block;
    }
</style>
<?php print theme('babybel_newsletter'); ?>
<div class="app">
    <div class="inner">
        <header class="header">
            <?php print render($page['header']); ?>
        </header>
        <div class="talking-cheese" data-type="open" >
            <?php print babybel_contextual_render('background_header_fun_stuff'); ?>

            <div class="block-2 intro-block">
                <?php
                $first_block_id = babybel_variable_get_nid_translated('babybel_variable_funstuff_first_id');
                if (isset($first_block_id['entity_id'])) {
                  $first_block = node_load($first_block_id['entity_id']);
                  if ($first_block) {
                    print '<div class="container">';
                    $view_first_block = node_view($first_block, 'article_fun_stuff_first');
                    print drupal_render($view_first_block);
                    print '<h2 class="title-box style-1">See them in action</h2>';
                    $article_id = babybel_variable_get_nid_translated('babybel_variable_article_id');
                    if (isset($article_id['entity_id'])) {
                      $article = node_load($article_id['entity_id']);
                      if ($article) {
                        if ($article->field_video_player[LANGUAGE_NONE][0]['nid']) {
                          $video = node_load($article->field_video_player[LANGUAGE_NONE][0]['nid']);
                          $view_video = node_view($video, 'video_player');
                          print drupal_render($view_video);
                        }
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
                    $supercheese_block_id = babybel_variable_get_nid_translated('babybel_variable_funstuff_supercheese_id');
                    if (isset($supercheese_block_id['entity_id'])) {
                      $supercheese_block = node_load($supercheese_block_id['entity_id']);
                      if ($supercheese_block) {
                        $view_supercheese_block = node_view($supercheese_block, 'article_fun_stuff_supercheese');
                        print drupal_render($view_supercheese_block);
                      }
                    }
                    ?>

                    <?php
                    $arr_fun_stuff = babybel_fun_stuff_get_fun_stuff();
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
    </div>
    <!-- .inner -->

    <footer class="footer">
        <?php print render($page['footer']); ?>
    </footer>
</div>
<!-- .app -->