<?php

/**
 * @file
 * This template handles the layout of Social Feed block.
 *
 */
global $language;
if(!empty($data)):
  ?>
<div id="fb-root"></div>
<script>
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];  
      if (d.getElementById(id)) return;  
      js = d.createElement(s); 
      js.id = id;  
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";  
      fjs.parentNode.insertBefore(js, fjs);
    }
      (document, 'script', 'facebook-jssdk'));

</script>
<?php if($feed_title['title']):  ?>
  <div class="container">
        <h2 class="title-1"><?php print $feed_title['title']; ?></h2>
  </div> 
<?php endif; ?>
<div class="facebook-feed">
  <?php
  foreach ($data as $value) :
    if($value['type'] == 'facebook'):  
    ?>
      <div class="fb-container">
        <div class="fb-post" data-href="https://www.facebook.com/<?php print $value['page_name']; ?>/posts/<?php print $value['post_id']; ?>"  data-width="100%">
            <div class="fb-xfbml-parse-ignore" ></div>
        </div>    
      </div>
    <?php 
    endif;
    if($value['type'] == 'twitter'):
      ?>
    <div class="fb-container">
      <blockquote class="twitter-tweet" style="max-width: 100%" lang="<?php print $language->language; ?>">
          <a href="https://twitter.com/<?php print $value['username']; ?>/status/<?php print $value['id']; ?>"></a>
      </blockquote>
    </div>
    <?php
    endif;
    if($value['type'] == 'instagram'):
      ?>
    <div class="fb-container">
        <blockquote class="instagram-media" data-instgrm-captioned data-instgrm-version="5" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 5px; max-width:100%; padding:0; width:100%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px); float: left;">
          <div style="padding:8px; float: left;">
              <div style=" background:#F8F8F8; line-height:0; margin-top:40px; padding:50.0% 0; text-align:center; width:100%;"> 
                  <div style=" background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAAGFBMVEUiIiI9PT0eHh4gIB4hIBkcHBwcHBwcHBydr+JQAAAACHRSTlMABA4YHyQsM5jtaMwAAADfSURBVDjL7ZVBEgMhCAQBAf//42xcNbpAqakcM0ftUmFAAIBE81IqBJdS3lS6zs3bIpB9WED3YYXFPmHRfT8sgyrCP1x8uEUxLMzNWElFOYCV6mHWWwMzdPEKHlhLw7NWJqkHc4uIZphavDzA2JPzUDsBZziNae2S6owH8xPmX8G7zzgKEOPUoYHvGz1TBCxMkd3kwNVbU0gKHkx+iZILf77IofhrY1nYFnB/lQPb79drWOyJVa/DAvg9B/rLB4cC+Nqgdz/TvBbBnr6GBReqn/nRmDgaQEej7WhonozjF+Y2I/fZou/qAAAAAElFTkSuQmCC); display:block; height:44px; margin:0 auto -44px; position:relative; top:-22px; width:44px;"></div>
              </div> 
              <p style=" margin:8px 0 0 0; padding:0 4px;"> 
                  <a href="<?php print $value['link']; ?>" style=" color:#000; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none; word-wrap:break-word;" target="_blank"></a>
              </p>        
          </div>
      </blockquote>
    </div>
      <?php
    endif;
    ?>
<?php 
  endforeach;
  ?>
</div>
<?php 
endif; ?>