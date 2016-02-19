<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

print render($title_prefix);
print render($title_suffix);

$blog = $node->field_blog_article_reference[LANGUAGE_NONE][0]["node"];
$blog_created = getdate($blog->created);

$node_social = Thu_Social_Get_Feed::get_lastest_feed();
?>

<section name="blog" class="block-4 blog-block bg-light-gray active node-<?php print $node->nid; ?>" <?php print $attributes; ?>>
    <div class="col-sm-6 block-group">
        <div class="block-3 capatity-block bg-light-gray">
            <div class="inner">
                <?php if(!is_null($node_social)): ?>
                <?php
                  $node_social_create = new DateTime($node_social->field_feed_create_at[LANGUAGE_NONE][0]["value"]);
                  $social_content = $node_social->field_feed_content[LANGUAGE_NONE][0]["value"];
                  $social_content = replace_hashtag_in_string($social_content);
                  $social_content = replace_hashtag_in_string($social_content, '@');
                ?>
                  <div class="wrap">
                    <div class="content">
                      <div class="inner">
                        <span class="date">
                          <i class="wi-icon wi-icon-twitter-1"></i>
                          @<?php print $node_social->field_feed_name[LANGUAGE_NONE][0]["value"] ?> &bullet; <?php print $node_social_create->format('M d'); ?>
                        </span>
                        
                        <h2 class="title-2" data-limit-row="true" data-row="5" data-hidden-sibling="false" data-get-first-child="false"><?php print $social_content ?></h2>  
                          
                        <a target="_blank" href="https://twitter.com/<?php echo $node_social->field_feed_from_id[LANGUAGE_NONE][0]["value"] .'/status/' . $node_social->field_feed_id[LANGUAGE_NONE][0]["value"]; ?>" class="link-1">
                            <?php print t('Retweet it');?>
                            <span class="wi-icon wi-icon-arrow-2"></span>
                        </a>  
                      </div>
                    </div>    
                  </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="block-3 social-block bg-blue">
            <div class="inner">
              <div class="wrap">
                  <div class="content">
                    <div class="inner">
                      <ul class="social">
                          <li><a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_linkedIn')); ?>" class="wi-icon wi-icon-linked-in"><?php print t("LinkedIn");?></a>
                          </li>
                          <li><a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_youTube')); ?>" class="wi-icon wi-icon-youtube"><?php print t("YouTube");?></a>
                          </li>
                          <li><a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_twitter')); ?>" class="wi-icon wi-icon-twitter"><?php print t("Twitter");?></a>
                          </li>
                          <li><a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_instagram')); ?>" class="wi-icon wi-icon-instagram"><?php print t("Instagram");?></a>
                          </li>
                          <li><a target="_blank" href="<?php print_r(variable_get('thu_variables_link_header_facebook')); ?>" class="wi-icon wi-icon-facebook"><?php print t("Facebook");?></a>
                          </li>                    
                      </ul>
                      <h2 class="title-1 text-white"><?php print t('Follow us')?></h2>
                    </div>  
                  </div>
              </div>                
            </div>
        </div>
    </div>
    <div class="col-sm-6 block-3 hearty-block">
        <figure>
            <a href="<?php print url("node/" . $blog->nid) ?>"><img src="<?php print image_style_url('631x383', $blog->field_image[LANGUAGE_NONE][0]['uri']); ?>" alt="photo-3"/></a>
        </figure>
        
        <div class="inner text-dark-gray">
            <div class="wrap">
                <div class="content">
                  <div class="inner">
                    <span class="date"><?php print t("ThurayaTelecom")?> &bullet; <?php print $blog_created["month"]. ' '. $blog_created["mday"]?></span>
                    <h2 class="title-2"><?php print $blog->title ?></h2>
                    <div class="desc" data-limit-row><?php print $blog->body[LANGUAGE_NONE][0]["value"] ?></div>
                    <a href="<?php print url("node/" . $blog->nid) ?>" class="link-1" target="_blank">
                        <?php print t("Read the article") ?>
                        <span class="wi-icon wi-icon-arrow-2"></span>
                    </a>
                  </div>  
                </div>
            </div>
        </div>
    </div>
</section>