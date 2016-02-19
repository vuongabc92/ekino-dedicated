<!--data-type="open|closed|archives"-->
<div id="news" data-type="open">
    <?php
    $arr_iframe = babybel_news_get_iframe();
    $arr_news = babybel_news_get_news_limit(0, 2);
    if(empty($arr_iframe) && empty($arr_news)){
      drupal_goto('<front>');
    }
    if ($arr_iframe) {
      foreach ($arr_iframe as $iframe) {
        $view_news = node_view($iframe, 'iframe');
        print drupal_render($view_news);
      }
    }
    $data_loadmore = '';
    global $user;
    if ($user->uid) {
      $data_loadmore = 'data-loadmore-wrap=".content-general"';
    }
    ?>
    <div data-load-more data-ajax-url="load-more/" <?php print $data_loadmore; ?>
         data-limit="5" data-offset="2" class="block-2 list-news">
        <div class="container">
            <?php
            if ($arr_news) {
              foreach ($arr_news as $news) {
                print '<div id="article-' . $news->vid . '" data-sharing class="news-block">';
                $view_news = node_view($news, 'news');
                print drupal_render($view_news);
                print '</div>';
                //$i++;
              }
            }
            else {
              drupal_goto('<front>');
            }
            ?>
            <?php
            $total_news = babybel_news_get_news();
            if (count($total_news) > 2) {
              print babybel_contextual_render('button_load_more_news');
            }
            ?>
        </div>
        <!-- .container -->
    </div>
    <!-- .list-news -->

</div>
<!-- .news -->