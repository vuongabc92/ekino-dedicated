<div id="how" data-type="open">
    <?php print babybel_contextual_render('background_header_our_secret'); ?>
    <div class="block-2 secret-block">
        <?php
        if ($our_secret && $our_secret_status):
          $view_our_secret = node_view($our_secret, 'article_our_secret');
          print drupal_render($view_our_secret);

        endif;
        ?>
    </div>
    <div class="block-2 style-1 steps-block">
        <div class="container">
            <div class="content">
                <?php
                if ($milk_origins && $milk_origins_status):
                  $view_milk_origins = node_view($milk_origins, 'article_milk_origins');
                  print drupal_render($view_milk_origins);

                endif;
                ?>
            </div>
            <div class="content">
                <?php
                if ($cheese && $cheese_status):
                  $view_cheese = node_view($cheese, 'cheese_steps');
                  print drupal_render($view_cheese);
                endif;
                ?>
            </div>
        </div>
    </div>
</div>