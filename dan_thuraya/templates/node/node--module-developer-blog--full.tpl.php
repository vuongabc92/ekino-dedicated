<?php
/**
 * @file
 * Bartik's theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
$develop_blog_collections = field_collection_item_load_multiple($node->field_developer_blog_collection['und']);
$develop_feature_collections = field_collection_item_load_multiple($node->field_developer_feauture_collect['und']);
?>

<?php
if (!empty($develop_blog_collections)):
  foreach ($develop_blog_collections as $develop_blog_collection):
    ?>
    <section class="block-4 campaign-block local-block">
      <div class="content">
        <figure>
          <img src="<?php print file_create_url($develop_blog_collection->field_banner_for_developer['und'][0]['uri']); ?>" alt="<?php print $field_developer_slider_collection->field_banner_for_developer['und'][0]['filename']; ?>"/>
        </figure>
        <div class="container">
          <div class="inner">
            <div class="block-3">
              <h2 class="title-1" style="color: <?php print $node->field_color_for_title['und'][0]['rgb']; ?>">
                <?php print $develop_blog_collection->field_title['und'][0]['value']; ?>
              </h2>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php
  endforeach;
endif;
?>

<?php if (!empty($develop_feature_collections)): ?>
  <section class="block-6 feature-details-block feature-details-block-1 bg-light-gray">
    <div class="container clearfix">
      <h2 class="title-4"><?php print t('Benefits & Applications'); ?></h2>
      <div class="accordion" data-extra-links="true">
        <?php foreach ($develop_feature_collections as $develop_feature_collection): 
          $segment_feature_content = $develop_feature_collection->field_content_feature['und'][0]['value'];
        ?>
          <h3 class="title-6 accordion-header<?php (trim($segment_feature_content)!=='' ? print(' cursor') : print('')) ?>">
            <?php print $develop_feature_collection->field_title_feature['und'][0]['value']; ?>
            <?php if(trim($segment_feature_content)!=='') : ?>
            <span class="accordion-icon">+</span>
            <?php endif; ?>
          </h3>
          <div class="accordion-content text-blue"><?php print $segment_feature_content; ?></div>          
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<section data-vertical-middle="true" data-get-height=".banner-1.banner-2 .container" data-set-padding=".content" class="banner-1 banner-3 editor-1">
  <figure class="adapt-image">
    <img src="<?php print file_create_url($node->field_background_for_developer['und'][0]['uri']); ?>" alt="<?php print $node->field_background_for_developer['und'][0]['filename']; ?>"/>
  </figure>
  <div class="content">
    <div class="container">
      <div class="wrap">
        <div class="inner">
          <?php if (!empty($node->field_icon_for_sector['und'][0]['uri'])): ?>
            <figure class="main-img">
              <img src="<?php print image_style_url('400x400', $node->field_icon_for_sector['und'][0]['uri']); ?>" alt="<?php print $node->field_icon_for_sector['und'][0]['filename']; ?>"/>
            </figure>
          <?php endif; ?>
          <div class="desc">
            <div class="text text-white">
              <p><?php print $node->field_introduction_for_developer['und'][0]['value']; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if (!empty($node->field_developer_how_it_work)): ?>
  <section class="block-6 works-block bg-light-gray">
    <div class="wrap">
      <div class="content">
        <h2 class="title-4 text-center"><?php print t('How it works'); ?></h2>
        <div class="container">
          <?php if ($node->field_developer_how_it_work['und'][0]['value'] == 'image'): ?>
            <figure class="main-img">
              <img src="<?php print file_create_url($node->field_developer_how_it_work_imag['und'][0]['uri']); ?>" alt="<?php print $node->field_developer_how_it_work_imag['und'][0]['filename']; ?>"/>
            </figure>
          <?php endif; ?>
          <?php if ($node->field_developer_how_it_work['und'][0]['value'] == 'video'): ?>
            <div class="video-block">
              <figure class="bg-gray-5"></figure>
              <h2 class="title-4 text-white text-center">
                <a href="<?php print file_create_url($node->field_developer_how_it_work_vide['und'][0]['uri']); ?>" class="text-gray-1">
                  <?php print t('Video'); ?>
                  <span class="icon-moon-arrow-right2"></span>
                </a>
              </h2>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php
$develop_products = $node->field_product_reference['und'];
$auto_play = ($node->field_slider_auto_play['und'][0]["value"]) ? "true" : "false";
if (!empty($develop_products)):
  ?>
  <section data-vertical-middle="true" class="block-4 carousel carousel-master carousel-master-1 hidden-xs active">
    <div data-slider data-type="custom" data-autoplay="<?php print $auto_play; ?>" class="slider">
      <?php
      foreach ($develop_products as $develop_product):
        $terms = taxonomy_term_load($develop_product['node']->field_product_type['und'][0]['tid']);
        $external_links = field_collection_item_load_multiple($develop_product['node']->field_external_links['und']);
        $ext_link = '';
        foreach ($external_links as $external_link) {
          $ext_link = $external_link->field_link_url['und'][0]['url'];
        }
        ?>
        <div class="slide bg-blue">
          <div class="container">
            <div class="block-3">
              <div class="inner">
                <h2 class="title-1 text-white"><?php print $develop_product['node']->title; ?></h2>
                <p class="desc text-white">
                  <?php print $develop_product['node']->field_short_description['und'][0]['value']; ?>
                </p>
                <p class="desc text-white">To access the information, you require a Thuraya Login ID. Please go to Become A Partner to sign up</p>
                <?php if ($terms->name === 'Developer' || $terms->name === 'M2M'): ?>
                  <?php if (!empty($ext_link)): ?>
                    <a target="_blank" href="<?php print $ext_link; ?>" class="link-1">
                      <?php print t('Know more'); ?>
                      <span class="icon-moon-arrow-right2"></span>
                    </a>
                  <?php endif; ?>
                <?php else: ?>
                  <a href="<?php print url(drupal_get_path_alias('node/' . $develop_product['node']->nid)); ?>" class="link-1">
                    <?php print t('Know more'); ?>
                    <span class="icon-moon-arrow-right2"></span>
                  </a>
                <?php endif; ?>
              </div>
              <figure>
                <a href="<?php print $ext_link; ?>">
                  <img src="<?php print file_create_url($develop_product['node']->field_product_image['und'][0]['uri']); ?>" alt="<?php print $develop_product['node']->field_product_image['und'][0]['filename']; ?>"/>
                </a>
              </figure>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>

<?php
$sectors = get_node_by_type('sector');
?>
<section data-vertical-middle="true" data-get-height=".started-block-2 .container" data-set-padding=".container" data-set-height="true" class="block-6 started-block started-block-2 bg-gray-6 active">
  <div class="container">
    <div class="wrap">
      <div class="content">
        <a href="<?php print $base_url.'/become-a-partner'?>" class="title-4 text-center text-dark-gray-1">
          <?php print t('Become a partner'); ?>
        </a>
        <div class="list-item list-item-1">
          <?php
          if (!empty($sectors)):
            foreach ($sectors as $sector):
              $sector_title = $sector->title;
              $sector_title = eregi_replace('Comms', '', $sector_title);
              ?>
              <a href="<?php print url(drupal_get_path_alias('node/'.$sector->nid)); ?>" class="item gray" title="<?php print $sector_title; ?>">
                <figure>
                  <img src="<?php print image_style_url('82x82', $sector->field_icon_sector['und'][0]['uri']); ?>" alt="<?php print $sector->field_icon_sector['und'][0]['filename']; ?>" class="img-current"/>
                  <img src="<?php print image_style_url('82x82', $sector->field_icon_sector_hover['und'][0]['uri']); ?>" alt="<?php print $sector->field_icon_sector_hover['und'][0]['filename']; ?>" class="img-hover"/>
                </figure>
                <span class="text-2"><?php print $sector_title; ?></span>
              </a>      
              <?php
            endforeach;
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="block-6 breadcrumb-block">
  <div class="container">
    <ol class="breadcrumb">      
      <li><a href="<?php print url($base_url); ?>"><?php print t('Home'); ?></a>
      </li>
      <li><a href="/products-list"><?php print t('Products'); ?></a>
      </li>
      <li class="active"><span><?php print $node->title; ?></span>
      </li>
    </ol>
  </div>
</section>

<?php
//render theme store location m2m
print theme('thu_store_location');
?>
