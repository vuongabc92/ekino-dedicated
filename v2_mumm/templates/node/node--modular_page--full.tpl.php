<?php

/*
 * @file node--modular_page.tpl.php.
 *
 */
?>
<?php

$field_display_title = field_get_items('node', $node, 'field_display_title');
$field_display_brc_sharing = field_get_items('node', $node, 'field_display_brc_sharing');
$field_modular_page_template = field_get_items('node', $node, 'field_modular_page_template');
v2_breadcrumb_get_breadcrumb($node);
$breadcrumbs = drupal_get_breadcrumb();
$breadcrumb_result = v2_breadcrumb_load_breadcrumb($breadcrumbs);
global $base_url, $language;
$image_url_share = file_create_url($image);
$alilas_current = $base_url . request_uri();
$description_social = $node->metatags['en']['description']['value'];
$image_url = file_create_url($node->field_picture_social['und'][0]['uri']);
$share_get_language = _hs_resource_get('share_text','plain', FALSE, FALSE,'Share');
$share = '<span class="text-share">'.$share_get_language.'</span>';

$social_share = variable_get('social_networks_sharing_' .$language->language);
?>
<?php print render($title_prefix); ?>
<?php print render($title_suffix); ?>
<?php

$title = '';
if (!empty($field_display_title[0]['value']) && $field_display_title[0]['value'] == 1):
  $title = $node->title;
endif;

$arr_display = array(
  'breadcrumb' => $field_display_brc_sharing[0]['value'],
  'title' => $title,
  'breadcrumb_results' => $breadcrumbs,
);

if (!empty($field_modular_page_template[0]['value'])):
  $output = '';
  switch ($field_modular_page_template[0]['value']):
    case 'collection_list_page':
      $content = module_invoke('v2_products', 'block_view', 'collections', $arr_display);
      $output = $content['content'];
      break;
    case 'tips_list_page':
      $content = module_invoke('v2_list_tip', 'block_view', 'list_tip', $arr_display);
      $output = $content['content'];
      break;
    case 'articles_list_page':
      $content = module_invoke('v2_news', 'block_view', 'news', $arr_display);
      $output = $content['content'];
      break;
    case 'venues_list_page':
      $content = module_invoke('v2_venues', 'block_view', 'venues', $arr_display);
      $output = $content['content'];
      break;
    case 'wall_of_victories_page':
      $content = module_invoke('v2_feeds', 'block_view', 'wall_of_victories', $arr_display);
      $output = $content['content'];
      break;
    case 'default':
      $output = '';
      if ($field_display_brc_sharing[0]['value'] == 1):
        $output .= '<div class="page-navigation"><div class="grid-fluid"><div class="inner">';
        if((!is_int($social_share['facebook']) && isset($social_share['facebook'])) || (!is_int($social_share['twitter']) && isset($social_share['twitter']))):
          $output .= '<div data-toggle-share="" class="share-block"><a href="#" title="' . $share_get_language . '" class="icon icon-share-toggle hidden-sm">' . $share_get_language . '</a>';
          $output .= '<div class="share">' . hs_resource_contextual_link('share_text', $share, 'text-share');
          $output .= '<ul class="social">';
          if(!is_int($social_share['facebook']) && isset($social_share['facebook'])):
            $output .= '<li><a href="javascript:;" title="' . t('Facebook') . '" class="icon icon-fb-small" data-share="data-share" data-share-content="{&quot;urlPage&quot;: &quot;' . $alilas_current . '&quot;, &quot;urlImg&quot;: &quot;' . $image_url . '&quot;, &quot;caption&quot;: &quot;' . $title . '&quot;, &quot;description&quot;: &quot;&quot;}"';
            $output .= 'data-tracking data-track-action="share" data-track-category="header" data-track-label="facebook" data-track-type="event">' . t('Facebook') . '</a></li>';
          endif;
          if(!is_int($social_share['twitter']) && isset($social_share['twitter'])):
            $output .= '<li class="last-share"><a href="https://twitter.com/intent/tweet?text=' . urlencode($alilas_current) . '" data-share-twitter title="Twitter" class="icon icon-tw-small"';
            $output .= 'data-tracking data-track-action="share" data-track-category="header" data-track-label="twitter" data-track-type="event">' . t('Twitter') . '</a></li>';
          endif;
          $output .= '</ul>';
          $output .= '</div></div>';
        endif;

        if (count($breadcrumbs)) {
          $output .= $breadcrumb_result;
        }
        $output .='</div></div></div>';
      endif;
      if (!empty($title)):
        $output .= '<h1 class="title title-medium">' . $title . '</h1>';
      endif;
      break;
  endswitch;
  print $output;
endif;
?>