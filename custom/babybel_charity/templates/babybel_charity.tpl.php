<div id="charity" data-type="open">
    <!--.background header-->
    <?php print babybel_contextual_render('background_header_charity'); ?>
    <div data-limit="5" data-offset="5" data-load-more data-ajax-url="load-more-charity/<?php print $data_loadmore; ?>"  data-item-class=".charity-block" class="block-2 list-charity">
        <?php
        // get article
        $offset = 0;
        $limit = 5;
        $article_id = babybel_variable_get_nid_translated('babybel_variable_charity_article_id');
        $arr_charity = babybel_charity_get_charity_limit($offset, $limit);
        $article = ($article_id) ? node_load($article_id) : NULL;
        if (empty($article) && empty($arr_charity)) {
          drupal_goto('<front>');
        }
        ?>      
        <div class="container">        
            <?php
            $article_status = isset($article->status) ? $article->status : 0;
            if ($article && $article_status) {
              $view_article = node_view($article, 'article_charity');
              print '<div id="" data-sharing class="charity-block">';
              print drupal_render($view_article);
              if ($article->field_video_player[LANGUAGE_NONE][0]['nid']) {
                $video_nid = babybel_variable_get_nid_node_translated($article->field_video_player[LANGUAGE_NONE][0]['nid'], $article_id);
                $video = node_load($video_nid);
                $video_status = isset($video->status) ? $video->status : 0;
                if ($video && $video_status) {
                  $view_video = node_view($video, 'video_player_charity');
                  print drupal_render($view_video);
                }
              }
              print '</div>';
            }
            ?>
            <!--.get charity-->
            <?php
            if ($arr_charity) {
              foreach ($arr_charity as $charity) {
                print '<div id="charity-' . $charity->vid . '" data-sharing class="charity-block">';
                $view_charity = node_view($charity, 'charity');
                print drupal_render($view_charity);
                print '</div>';
              }
            }
            ?>
            <?php
            $total_charity = babybel_charity_get_charity();
            if (count($total_charity) > 5) {
              print babybel_contextual_render('button_load_more_charity') ? babybel_contextual_render('button_load_more_charity') : 'Load more';
            }
            ?>
        </div>
    </div>
    <!--.background footer-->
    <div class="background-block">
        <?php print babybel_contextual_render('background_footer_charity'); ?>
    </div>
</div>

