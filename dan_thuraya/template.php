<?php

/*
 * @file
 * template.php
 */

/**
 * Implements hook_preprocess_page().
 */
function dan_thuraya_preprocess_page(&$variable) {
  $common_css = array(
    'libs',
    'style',
  );
  $common_js = array(
//'modernizr',
    'l10n',
    'libs',
    'script',
  );
  thuraya_include_asset($common_css, 'css');
  thuraya_include_common_js($common_js, 'js');
}

/**
 * Implement include css/js for each page.
 */
function thuraya_include_asset($variable, $type) {
  $path = drupal_get_path('theme', 'dan_thuraya');
  if ($type == 'css') {
    foreach ($variable as $key => $item) {
      drupal_add_css($path . '/css/' . $item . '.css', array(
        'group' => CSS_THEME,
        'type' => 'file',
        'media' => 'screen',
        'preprocess' => FALSE,
        'every_page' => FALSE,
        'group' => CSS_THEME,
        'weight' => $key,
      ));
    }
  }
  if ($type == 'js') {
    foreach ($variable as $key => $item) {
      drupal_add_js($path . '/js/' . $item . '.js', array(
        'type' => 'file',
        'scope' => 'footer',
        'group' => JS_THEME,
        'every_page' => FALSE,
        'weight' => $key,
      ));
    }
  }
}

/**
 * Implement include js common in footer for every page.
 */
function thuraya_include_common_js($variable) {
  $path = drupal_get_path('theme', 'dan_thuraya');
  foreach ($variable as $item) {
    drupal_add_js($path . '/js/' . $item . '.js', array(
      'type' => 'file',
      'scope' => 'footer',
      'group' => JS_THEME,
      'every_page' => TRUE,
      'weight' => -1,
    ));
  }
}

/**
 * Implement hook_menu_link()
 * @param type array $variables
 * @return type
 */
function dan_thuraya_menu_link__menu_top_menu(array $variables) {
  $element = $variables ['element'];
  $sub_menu = '';

  if ($element ['#below']) {
    $sub_menu = drupal_render($element ['#below']);
  }
  $output = l($element ['#title'], $element ['#href'], $element ['#localized_options']);
  return '<li>' . $output . $sub_menu . "</li>\n";
}

/**
 * Implement hook_menu_tree()
 * @param type $variables
 * @return type
 */
function dan_thuraya_menu_tree__menu_top_menu($variables) {
  return $variables ['tree'];
}

/**
 * Implement hook_menu_link()
 * @param type array $variables
 * @return type
 */
function dan_thuraya_menu_link__main_menu(array $variables) {
  $element = $variables ['element'];
  $sub_menu = '';

  $class_menu = $element['#localized_options']['attributes']['class'][0];
  if ($class_menu) {
    switch ($class_menu) {
      case 'products':
        $sub_menu = dan_render_submenu_product('dan_thuraya_submenu_product_theme');
        break;

      default:
        break;
    }
  }

  $output = l($element ['#title'], $element ['#href'], $element ['#localized_options']);
  if (strpos($output, "active") > 0) {
    $class_active = 'active';
  }
  if ($class_menu == 'products' AND preg_match('/products\/[0-9]+/i', $_GET['q'])) {
    $class_active = 'active';
  }
  return '<li class="' . $class_active . '" >' . $output . $sub_menu . "</li>\n";
}

/**
 * Implement hook_menu_tree()
 * @param type $variables
 * @return type
 */
function dan_thuraya_menu_tree__main_menu($variables) {
  return $variables['tree'];
}

/**
 * Implement hook_menu_tree()
 * @param type $variables
 * @return type
 */
function dan_thuraya_menu_tree__menu_footer_menu($variables) {
  return $variables ['tree'];
}

/**
 * Implement hook_menu_link()
 * @param type array $variables
 * @return type
 */
function dan_thuraya_menu_link__menu_footer_menu(array $variables) {
  global $theme;
  $element = $variables ['element'];
  $sub_menu = $output = '';
  $class_menu = $element['#localized_options']['attributes']['class'][0];
  if ($theme == 'dan_thuraya' && $class_menu == 'products-footer') {
    $sub_menu = dan_render_submenu_product('dan_thuraya_product_theme_footer');
    $output = '<h2 class="title-2 text-white">' . $element['#title'] . '</h2>';
  }
  return $output . $sub_menu . "\n";
}

/**
 * @todo Get node by type
 * @param type $type
 * @return type
 */
function get_node_by_type($type) {
  $query = db_select('node', 'n');
  $query->condition('type', $type, '=');

  $query->fields('n', array('nid'));
  $nids = $query->execute()->fetchCol();
  if (!empty($nids)) {
    $node = node_load_multiple($nids);
    return $node;
  }

  return NULL;
}

function replace_hashtag_in_string($text, $tag = '#', $type = '') {
  preg_match_all("/" . $tag . "(\\w+)/", $text, $matches);

  foreach ($matches[1] as $hashtag) {
    if ($tag === '#') {
      switch ($type) {
        case "facebook":
          $text = str_replace($tag . $hashtag, '<a class="link-2 text-blue" target="_blank" href="https://www.facebook.com/hashtag/' . $hashtag . '">' . $tag . $hashtag . '</a>', $text);
          break;
        case "twitter":
          $text = str_replace($tag . $hashtag, '<a class="link-2 text-blue" target="_blank" href="http://twitter.com/search?q=' . $hashtag . '">' . $tag . $hashtag . '</a>', $text);
          break;
        case "instagram":
          $text = str_replace($tag . $hashtag, '<a class="link-2 text-blue" target="_blank" href="https://www.instagram.com/explore/tags/' . $hashtag . '">' . $tag . $hashtag . '</a>', $text);
          break;
        case "youtube":
          $text = str_replace($tag . $hashtag, '<a class="link-2 text-blue" target="_blank" href="https://www.youtube.com/results?search_query=' . $hashtag . '">' . $tag . $hashtag . '</a>', $text);
          break;
        default:
          $text = str_replace($tag . $hashtag, '<a class="link-2 text-blue" target="_blank" href="http://twitter.com/search?q=' . $hashtag . '">' . $tag . $hashtag . '</a>', $text);
          break;
      }
    }
    else {
      $text = str_replace($tag . $hashtag, '<a class="link-2 text-blue" target="_blank" href="http://twitter.com/intent/user?screen_name=' . $hashtag . '">' . $tag . $hashtag . '</a>', $text);
    }
  }

  return $text;
}

/**
 * Implement Hook_form_element()
 * @param type $variables
 * @return string
 */
function dan_thuraya_form($variables) {
  $element = $variables ['element'];
  if (isset($element ['#action'])) {
    $element ['#attributes']['action'] = drupal_strip_dangerous_protocols($element ['#action']);
  }
  element_set_attributes($element, array('method', 'id'));
  if (empty($element ['#attributes']['accept-charset'])) {
    $element ['#attributes']['accept-charset'] = "UTF-8";
  }
// Anonymous DIV to satisfy XHTML compliance.
  return '<form' . drupal_attributes($element ['#attributes']) . '>' . $element ['#children'] . '</form>';
}

/**
 * Implement hook_prorocess_html(&$vars)
 */
function dan_thuraya_preprocess_html(&$vars) {
  $obj = menu_get_object();
  $path = path_to_theme();
  $header = drupal_get_http_header('status');

//Add body class
  if (in_array('html__front', $vars['theme_hook_suggestions'])) {
    $vars['classes_array'] = array('home');
  }

  if (in_array('html__products', $vars['theme_hook_suggestions'])) {
    $taxonomy = taxonomy_term_load(arg(1));
    $vars['classes_array'] = array('product-category landing');
    $vars['title'] = $taxonomy->name;
  }

  if (in_array('html__node', $vars['theme_hook_suggestions'])) {
    $vars['classes_array'] = array('m2m-products product');
  }

  if (in_array('html__landing_developer', $vars['theme_hook_suggestions'])) {
    $vars['classes_array'] = array('developer');
  }

  if (in_array('html__sectors', $vars['theme_hook_suggestions'])) {
     $vars['classes_array'] = array('landing');
  }

  if ($obj->type == 'module_segment_blog' || $obj->type == 'module_developer_blog') {
    $vars['classes_array'] = array('segment');
  }

  if ($obj->type === 'landing_sector_content' || $obj->type === 'sector_solution_category') {
    $vars['classes_array'] = array('detail');
  }

  if (in_array('html__social_media', $vars['theme_hook_suggestions'])) {
    $vars['classes_array'] = array('social-media bg-light-gray');
  }

  if ($header == '404 Not Found') {
    $vars['theme_hook_suggestions'] = array('html__404');
  }
}

/**
 * Implement of hook_theme()
 */
function dan_thuraya_theme($existing, $type, $theme, $path) {
  $hooks['user_login'] = array(
    'template' => 'templates/user_login',
    'render element' => 'form',
  );
  return $hooks;
}

/**
 * Implement of preprocess_breadcrumb
 */
function dan_thuraya_preprocess_breadcrumb(&$variables) {
  if (arg(0) == 'node' && arg(1) && is_numeric(arg(1))) {
    $node = node_load(arg(1));
    switch ($node->field_product_type['und'][0]['taxonomy_term']->name) {
      case 'Land Voice':
        $variables['breadcrumb'] = thu_get_breadcrumb(array(
          array(
            'title' => t('Land Voice'),
            'href' => '#',
          ),
          array('title' => $node->title),
        ));
        break;

      default:
        break;
    }
  }
}

/**
 * Theme breadcrumb altering for FO.
 */
function dan_thuraya_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  $crumbs = '';
  if (!empty($breadcrumb)) {
    $crumbs = '<ol class="breadcrumb">';
    foreach ($breadcrumb as $key => $value) {
      $crumbs .= '<li>';
      $crumbs .=!isset($value['href']) ? '' : '';
      $crumbs .= $value;
      $crumbs .=!isset($value['href']) ? '' : '';
      $crumbs .= ($key == count($breadcrumb) - 1) ? '' : "";
      $crumbs .= '</li>';
    }
    $crumbs .= '</ol>';
  }
  return $crumbs;
}

function dan_thuraya_process_page(&$variables) {
  global $base_url;
  if (in_array('page__front', $variables['theme_hook_suggestions'])) {
    $variables['attributes_js'] = 'data-scroll-custom';
    drupal_add_css($base_url . '/' . 'sites/all/libraries/colorbox-master/example3/colorbox.css', array(
        'type' => 'file',
        'media' => 'screen',
        'scope' => 'footer',
        'preprocess' => FALSE,
        'every_page' => FALSE,
        'group' => CSS_THEME,
        'weight' => 0,
      ));
    drupal_add_js($base_url . '/' . 'sites/all/libraries/colorbox-master/jquery.colorbox-min.js', array(
      'type' => 'file',
      'scope' => 'footer',
      'group' => JS_THEME,
      'weight' => 0,
    ));
    $inline_script = <<<EOL
        jQuery(document).ready(function(){
            var padding = parseInt(40);
            var sheight = jQuery('#sheight').text();
            var swidth = jQuery('#swidth').text();
            sheight = parseInt(sheight) + padding;
            swidth = parseInt(swidth) + padding;
            if(jQuery.trim( jQuery('#splash').html() ).length > 0) {
        console.log(swidth+"---"+sheight);
                setTimeout(function() {
                    jQuery.colorbox({innerWidth: swidth, innerHeight: sheight, width: swidth, height: sheight, inline:true, href:"#splash"});
				}, 1500);
            }
        });
EOL;
    drupal_add_js($inline_script, array(
      'type' => 'inline',
      'scope' => 'footer',
      'group' => JS_THEME,
      'weight' => 1,
    ));
  }

  if (in_array('page__products_list', $variables['theme_hook_suggestions'])) {
    $variables['attributes_js'] = 'data-scroll-custom data-product-list';
  }

  if (in_array('page__products', $variables['theme_hook_suggestions'])) {
    $variables['data_js_category_product'] = 'data-scroll-custom';
  }

  if (in_array('page__node', $variables['theme_hook_suggestions'])) {
    $variables['data_js_node'] = 'data-scroll-product';
  }

  if (in_array('page__social_media', $variables['theme_hook_suggestions'])) {
    $variables['class_social_media'] = 'bg-light-gray';
    $variables['check_social_media'] = 'data-is-set-min-height="false"';
  }
  if (in_array('page__landing_page', $variables['theme_hook_suggestions'])) {
    $variables['class_social_media'] = 'bg-light-gray';
    $variables['check_social_media'] = 'data-is-set-min-height="false"';
  }

  $content_type = $variables['node']->type;
  $variables['theme_hook_suggestions'] = array('page__node__' . $content_type, 'page__node__module_segment_blog');
}

function dan_thuraya_preprocess_node(&$variables) {
  $taxonomy = taxonomy_term_load($variables['field_product_type'][0]['taxonomy_term']->tid);
  if ($taxonomy->field_select_template['und'][0]['value'] == 1) {
    $variables['theme_hook_suggestions'] = array('node__' . $variables['type'] . '__' . $variables['view_mode'] . '__m2m');
  }
  else {
    if ($variables['view_mode'] == NULL) {
      $variables['theme_hook_suggestions'] = array('node__' . $variables['type']);
    }
    else {
      $variables['theme_hook_suggestions'] = array('node__' . $variables['type'] . '__' . $variables['view_mode']);
    }
  }
}

/**
 * Get solutions by solution category id.
 *
 * @param int $cat_id Category id
 *
 * @return array|null List of solutions or null for otherwise
 */
function dan_thuraya_get_solution_by_cat_id($cat_id) {

  $query = db_select('node', 'n');

  $query->leftJoin('field_data_field_sector_solution_category', 'r', 'r.entity_id = n.nid');
  $query->join('node', 'x', 'r.field_sector_solution_category_nid = x.nid');
  $query->condition('n.type', 'solution', '=');
  $query->condition('r.field_sector_solution_category_nid', $cat_id, '=');
  $query->fields('n', array('nid'));
  $nids = $query->execute()->fetchCol();

  if (!empty($nids)) {
    $node = node_load_multiple($nids);

    return $node;
  }

  return NULL;
}

/**
 * Get product by sector id.
 *
 * @param int $sector_id Sector id
 *
 * @return array|null List of solutions or null for otherwise
 */
function dan_thuraya_get_product_by_sector($sector_id) {

  $query = db_select('node', 'n');

  $query->leftJoin('field_data_field_associated_solutions', 'r', 'r.entity_id = n.nid');
  $query->join('node', 'x', 'r.field_associated_solutions_nid = x.nid');
  $query->condition('n.type', 'product', '=');
  $query->condition('r.field_associated_solutions_nid', $sector_id, '=');
  $query->fields('n', array('nid'));
  $nids = $query->execute()->fetchCol();

  if (!empty($nids)) {
    $node = node_load_multiple($nids);

    return $node;
  }

  return NULL;
}

/**
 * Get solutions by solution categiry id
 *
 * @param int $cat_id
 *
 * @return array|NULL An array of soluions or NULL
 */
function dan_thuraya_get_solutions_by_cat_id($cat_id) {

  $query = db_select('node', 'n');
  $query->leftJoin('field_data_field_sector_solution_category', 'r', 'r.entity_id = n.nid');
  $query->join('node', 'x', 'r.field_sector_solution_category_nid = x.nid');
  $query->condition('n.type', 'solution', '=');
  $query->condition('r.field_sector_solution_category_nid', $cat_id, '=');

  $query->fields('n', array('nid'));
  $nids = $query->execute()->fetchCol();

  if (!empty($nids)) {
    $node = node_load_multiple($nids);

    return $node;
  }

  return NULL;
}

/**
 * Get solution categories by landing sector id
 *
 * @param int $sector_id
 *
 * @return array|NULL An array of categories or NULL
 */
function dan_thuraya_get_solution_cat_by_landing_sector_id($sector_id) {

  $query = db_select('node', 'n');
  $query->leftJoin('field_data_field_landing_sector', 'r', 'r.entity_id = n.nid');
  $query->join('node', 'x', 'r.field_landing_sector_nid = x.nid');
  $query->condition('n.type', 'sector_solution_category', '=');
  $query->condition('r.field_landing_sector_nid', $sector_id, '=');

  $query->fields('n', array('nid'));
  $nids = $query->execute()->fetchCol();

  if (!empty($nids)) {
    $node = node_load_multiple($nids);

    return $node;
  }

  return NULL;
}