<?php

/*
 * @file
 * template.php
 */

function v2_mumm_preprocess_html(&$vars) {
  $arg = arg();
  // Ensure that the $vars['rdf'] variable is an object.
  if (!isset($vars['rdf']) || !is_object($vars['rdf'])) {
    $vars['rdf'] = new StdClass();
  }

  if (module_exists('rdf')) {
    $vars['doctype'] = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML+RDFa 1.1//EN">' . "\n";
    $vars['rdf']->version = 'version="HTML+RDFa 1.1"';
    $vars['rdf']->namespaces = $vars['rdf_namespaces'];
    $vars['rdf']->profile = ' profile="' . $vars['grddl_profile'] . '"';
  }
  else {
    $vars['doctype'] = '<!DOCTYPE html>' . "\n";
    $vars['rdf']->version = '';
    $vars['rdf']->namespaces = '';
    $vars['rdf']->profile = '';
  }

  $viewport = array(
    '#tag' => 'meta',
    '#attributes' => array(
      'name' => 'viewport',
      'content' => 'width=device-width, initial-scale=1, maximum-scale=1',
    ),
  );
  drupal_add_html_head($viewport, 'viewport');

  // Get title of the international page version of the page
  $ga_page_title = NULL;
  if ($vars['language']->language == 'en') {
    $ga_page_title = drupal_get_title();
  }
  else {
    if (arg(0) == 'node' && is_numeric(arg(1))) {
      $node = node_load(arg(1));
      $node_en = mumm_helpers_get_translated_node($node, 'en');
      $ga_page_title = $node_en->title;
    }
  }
  // Add description static page
  if ($arg && isset($arg[0])) {
    switch ($arg[0]) {
      case 'portraits':
        $vars['head_title'] = v2_mumm_get_meta_tag($arg[0], $vars['head_title_array']['name']);
        v2_mumm_config_meta_tag($arg[0]);
        break;
      case 'champagne-ritual':
        $vars['head_title'] = v2_mumm_get_meta_tag($arg[0], $vars['head_title_array']['name']);
        v2_mumm_config_meta_tag($arg[0]);
        break;

      default:
        break;
    }
  }

  // Get node for GA.
  if(isset($arg) && $arg[0] == 'node' && is_numeric($arg[1])){
    $node_ga = mumm_helpers_get_current_node();
    $vars['node_ga'] = $node_ga;
  }

  $vars['ga_page_title'] = $ga_page_title;
}

// remove a tag from the head for Drupal 7
function v2_mumm_html_head_alter(&$head_elements) {
  $url = explode('/', current_path());
  if ($url[0] == 'gallery-photo') {
    unset($head_elements['metatag_og:title_0']);
    unset($head_elements['metatag_og:url_0']);
  }
  if(isset($head_elements['metatag_canonical']) && $head_elements['metatag_canonical']['#type'] =='html_tag'){
    $head_elements['metatag_canonical']['#value'] = urldecode($head_elements['metatag_canonical']['#value']);
  }
}

function v2_mumm_config_meta_tag($param) {
  global $language;
  $list_meta = variable_get('list_meta', array());
  $open_graph_protocol = array();
  if ($list_meta[$language->language]['title_' . $param]) {
    $open_graph_protocol['title'] = $list_meta[$language->language]['title_' . $param];
  }

  if ($list_meta[$language->language]['desc_' . $param]) {
    $open_graph_protocol['description'] = $list_meta[$language->language]['desc_' . $param];
  }
  $vars['head_title'] = $open_graph_protocol['title'] . ' | ' . $vars['head_title_array']['name'];
  v2_mumm_add_meta_tags($open_graph_protocol);
}

/**
 * Add meta tag for new page.
 */
function v2_mumm_add_meta_tags($open_graph_protocol) {
  $elements = array();
  $elements[] = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'property' => 'description',
      'content' => htmlspecialchars_decode($open_graph_protocol['description'], ENT_QUOTES),
    ),
  );

  $i = 0;
  foreach ($elements as $element) {
    drupal_add_html_head($element, 'open_graph_protocol_' . $i++);
  }
}

/**
 * Get meta tag with language default.
 */
function v2_mumm_get_meta_tag($arg = '', $name = '') {
  global $language;
  $title = t('Mumm International');
  $list_meta = variable_get('list_meta', array());
  if ($list_meta[$language->language]['title_' . $arg]) {
    $title = $list_meta[$language->language]['title_' . $arg] . ' | ' . $name;
  }
  return $title;
}

/**
 * Implement hook_preprocess_node().
 */
function v2_mumm_preprocess_node(&$variables) {
  $js = $css = array();

  switch ($variables['type']) {
    case 'lucky_draw':
      $js = array_merge($js, array(
        'lucky-draw',
      ));
      $css = array_merge($css, array(
        'lucky-draw'
      ));
      break;

    default:
      break;
  }
  v2_mumm_include_asset($css, 'css');
  v2_mumm_include_common_js($js, 'js');

  if ($variables['type'] == 'product_champagne') {
    $variables['theme_hook_suggestions'] = array('node__product_champagne__' . $variables['view_mode']);
  }

  if ($variables['type'] == 'article') {
    $variables['theme_hook_suggestions'] = array('node__article__' . $variables['view_mode']);
  }

  if ($variables['type'] == 'modular_page') {
    $variables['theme_hook_suggestions'] = array('node__modular_page__' . $variables['view_mode']);
  }
  if ($variables['type'] == 'basic_page') {
    $variables['theme_hook_suggestions'] = array('node__basic_page__' . $variables['view_mode']);
  }

  // Get html tag into title variable.
  $variables['title'] = $variables['node']->title;
}

function v2_mumm_preprocess_page(&$variable) {
  global $language;

  // Set in header the rel='alternate' hreflang tag of the page node
  mumm_v2_preprocess_page_add_hreflang($variable['node']);

  drupal_add_js('//maps.googleapis.com/maps/api/js', 'external');

  $common_css = array(
    'style',
  );
  $common_js = array(
    'browser',
    'vendors',
  );

  $common_js_footer = array(
    'l10n',
    'script',
    'script-age-gate',
  );

  v2_mumm_include_asset($common_css, 'css');
  v2_mumm_include_common_js($common_js, 'js');

  // Add language for datepicker.
  $js_path = drupal_get_path('module', 'jquery_update').'/replace/ui/ui/i18n/jquery.ui.datepicker-'.$language->prefix.'.js';
  if(module_enable('jquery_update') && file_exists($js_path)){
    drupal_add_js($js_path,array(
      'type' => 'file',
      'scope' => 'footer',
      'group' => JS_THEME,
      'every_page' => TRUE,
      'weight' => -1,
    ));
  }
  v2_mumm_include_common_js($common_js_footer, 'js');
  // Get logo for header and footer.
  $logo_arr = array('logo_header_desktop', 'logo_header_mobile', 'logo_footer_desktop', 'logo_footer_mobile');
  foreach ($logo_arr as $value) {
    $file = file_load(variable_get($value, 0));
    if ($file) {
      $variable[$value] = $file;
    }
  }

  global $base_url;
    $url = explode('/', current_path());
  if ($url[0] != 'gallery-photo') {
  //add metatag twitter.
  $metatags = $variable['page']['content']['metatags'];
  $metatags_twitter = array_shift($metatags);

  $meta = array();
  $meta[] = array('type' => 'image', 'content' => $metatags_twitter['og:image']['#attached']['drupal_add_html_head'][0][0]['#value']);
  $meta[] = array('type' => 'url', 'content' => urlencode($metatags_twitter['og:url']['#attached']['drupal_add_html_head'][0][0]['#value']));
  $meta[] = array('type' => 'title', 'content' => $metatags_twitter['title']['#attached']['metatag_set_preprocess_variable'][0][2]);
  $meta[] = array('type' => 'site', 'content' => $base_url);
  $meta[] = array('type' => 'card', 'content' => 'photo');
  v2_mumm_add_metatag_twitter($meta);
  }

  drupal_add_js(drupal_get_path('module', 'v2_mumm') . '/js/script_gmap.js');
  if ($_GET['q'] === 'outdated-browser') {
    $css = drupal_add_css();
    unset($css['sites/all/themes/v2_mumm/css/style.css']);
    v2_mumm_include_asset($common_css, 'css');
  }
  // Condition redirect if empty page
  v2_modules_check_redirect_empty_page($variable);
}

function v2_mumm_css_alter(&$css) {
  //Remove style.css in page outdated-browser
  $path = drupal_get_path('theme', 'v2_mumm');
  if ($_GET['q'] === 'outdated-browser') {
    unset($css[$path . '/css/style.css']);
  }
  else {
    unset($css[$path . '/css/unsupported-browsers.css']);
  }
}

/*
  function v2_mumm_preprocess_region(&$vars,$hook) {
  //  kpr($vars['content']);
  }
 */

function v2_mumm_preprocess_block(&$vars, $hook) {
  $block = $vars['elements']['#block']->region . '-' .
      $vars['elements']['#block']->module . '-' .
      $vars['elements']['#block']->delta;

  switch ($block) {
    case 'footer_menu-menu-menu-doormat':
      $vars['classes_array'][] = 'menu-footer';
      break;
    case 'header_main_menu-menu-menu-new-main-menu':
      $vars['classes_array'][] = 'main-menu-desktop';
      break;
    case 'sidebar-system-navigation':
      $vars['classes_array'][] = '';
      break;
    default:

      break;
  }

  switch ($vars['elements']['#block']->region) {
    case 'header':
      $vars['classes_array'][] = '';
      break;
    case 'sidebar':
      $vars['classes_array'][] = '';
      $vars['classes_array'][] = '';
      break;
    default:

      break;
  }
}

function v2_mumm_interchange_images($uri, $style_names = array(), $content_type = null) {

  $result = array();
  $data_thumb = '';
  // Patterns: ["http://example1.jpg","http://example2.jpg"].
  if ($style_names && $uri) {
    $key = 0;
    foreach ($style_names as $style_name) {
      $result[$key] = image_style_url($style_name, $uri);
      if ($key == 0) {
        // Condtition content type module slider.
        if ($content_type == 'module_slider') {
          unset($result[$key]);
        }
        $data_thumb = image_style_url($style_name, $uri);
      }
      $key++;
    }
    $result = '["' . implode('","', $result) . '"]';

    // Check the condition in case get data thumb
    if ($content_type) {
      return array(
        'data_thumb' => $data_thumb,
        'style_list' => $result,
      );
    }
  }

  return $result;
}

/**
 * Implement include css/js for each page.
 */
function v2_mumm_include_asset($variable, $type) {
  $path = drupal_get_path('theme', 'v2_mumm');
  if ($type == 'css') {
    foreach ($variable as $key => $item) {
      drupal_add_css($path . '/css/' . $item . '.css', array(
        'group' => CSS_THEME,
        'type' => 'file',
        'media' => 'screen',
        'preprocess' => TRUE,
        'every_page' => TRUE,
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
        'every_page' => TRUE,
        'preprocess' => TRUE,
        'cache' => TRUE,
        'weight' => $key,
      ));
    }
  }
}

/**
 * Implement include js common in footer for every page.
 */
function v2_mumm_include_common_js($variable) {
  $path = drupal_get_path('theme', 'v2_mumm');
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

/*
 * hook menu tree new main menu
 */

function v2_mumm_menu_tree__menu_new_main_menu(&$variables) {
  return '<ul>' . $variables['tree'] . '</ul>';
}

/*
 * hook menu link menu new main menu
 */

function v2_mumm_menu_link__menu_new_main_menu(&$variables) {
  $element = $variables ['element'];
  if (!$element ['#title']) {
    $href_array = explode('/', $element['#href']);
    if ($href_array[0] == 'node' && is_numeric($href_array[1])) {
      $node = node_load($href_array[1]);
      $element['#title'] = $node->title;
    }
  }
  $element['#localized_options']['attributes'] = array(
    'data-tracking' => '',
    'data-track-action' => 'click',
    'data-track-category' => 'header',
    'data-track-label' => strtolower($element ['#title']),
    'data-track-type' => 'event',
    );
  $output = l($element ['#title'], $element ['#href'], $element ['#localized_options']);

  if (in_array('first', (array)$element['#attributes']['class'])) {
    return '<li class="first">' . $output . '</li>';
  }
  if (in_array('hidden', (array)$element['#localized_options']['attributes']['class'])) {
    return '';
  }
  $class_item_attributes = $element['#original_link']['options']['item_attributes']['class'];
  return '<li class="item '.$class_item_attributes.'">' . $output . '</li>';
}

/*
 * hook menu tree menu doormat
 */

function v2_mumm_menu_tree__menu_doormat(&$variables) {
  return $variables['tree'];
}

/*
 * hook menu link menu doormat
 */

function v2_mumm_menu_link__menu_doormat(&$variables) {
  $element = $variables ['element'];
  $sub_menu = '';

  if ($element ['#below']) {
    $sub_menu = drupal_render($element ['#below']);
  }

  if ($element['#change_location']) {

    $output = '<a class="hidden-xs" data-trigger-toggle="change-location" title="' . $element ['#title'] . '" href="javascript:;"'
        . 'data-tracking data-track-action="click" data-track-category="footer" data-track-label="' . strtolower($element ['#title']) . '" data-track-type="event">' . $element ['#title'] . '</a>';
    }
  else {
    $element['#localized_options']['attributes'] = array(
    'data-tracking' => '',
    'data-track-action' => 'click',
    'data-track-category' => 'footer',
    'data-track-label' => strtolower($element ['#title']),
    'data-track-type' => 'event',
    );

    $output = l($element ['#title'], $element ['#href'], $element ['#localized_options']);
  }
  return $output . $sub_menu;
}

/*
 * hook menu tree menu header
 */

function v2_mumm_menu_tree__menu_header(&$variables) {
  return $variables['tree'];
}

/*
 * hook menu link menu header
 */

function v2_mumm_menu_link__menu_header(&$variables) {

  $element = $variables ['element'];
  $sub_menu = '';

  if ($element ['#below']) {
    $sub_menu = drupal_render($element ['#below']);
  }

  if (in_array('search-btn', $element['#localized_options']['attributes']['class'])) {

    $output = '<button id="search-btn" class="icon icon-search-gray search-btn" data-trigger-toggle="search-box" title="" name="search-btn" type="button"
      data-tracking data-track-action="click" data-track-category="header" data-track-label="search" data-track-type="event">
      </button>';
  }
  else {
    $class = $element['#localized_options']['attributes']['class'];
    $element['#localized_options']['attributes'] = array(
      'class' =>$class,
      'data-tracking' => '',
      'data-track-action' => 'click',
      'data-track-category' => 'header',
      'data-track-label' => 'book_a_visit',
      'data-track-type' => 'event',
    );

    $output = l($element ['#title'], $element ['#href'] , $element['#localized_options']);
  }
  return $output;
}

/**
 * hook preprocess_search_results
 * @param array $variables
 */
function v2_mumm_preprocess_search_results(&$variables) {
  $results = $variables['results'];

  $champange = array();
  $article = array();
  foreach ($results as $key => $value) {
    if ($value['type'] == 'Champagne') {
      $champange[] = $value;
    }
    else {
      $article[] = $value;
    }
  }
  $variables['search_champagne'] = $champange;
  $variables['search_article'] = $article;
}

/**
 * Implement Hook_form_element()
 * @param type $variables
 * @return string
 */
function v2_mumm_form_element($variables) {
  $element = &$variables ['element'];

  // Condition element edit-linkit-path of form linkit.
  if ($element['#id'] == 'edit-linkit-path') {
    $element ['#children'] = str_replace("linkit-path-element", "linkit-path-element required", $element ['#children']);
    $variables['element']['#required'] = false;
  }

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
  );

  // Add element #id for #type 'item'.
  if (isset($element ['#markup']) && !empty($element ['#id'])) {
    $attributes ['id'] = $element ['#id'];
  }
  // Add element's #type and #name as class to aid with JS/CSS selectors.
  $attributes ['class'] = array('form-item');
  if (!empty($element ['#type'])) {
    $attributes ['class'][] = 'form-type-' . strtr($element ['#type'], '_', '-');
  }
  if (!empty($element ['#name'])) {
    $attributes ['class'][] = 'form-item-' . strtr($element ['#name'], array(' ' => '-', '_' => '-', '[' => '-', ']' => ''));
  }
  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element ['#attributes']['disabled'])) {
    $attributes ['class'][] = 'form-disabled';
  }
  $output = "";

  // If #title is not set, we don't display any label or required marker.
  if (!isset($element ['#title'])) {
    $element ['#title_display'] = 'none';
  }
  $prefix = isset($element ['#field_prefix']) ? '<span class="field-prefix">' . $element ['#field_prefix'] . '</span> ' : '';
  $suffix = isset($element ['#field_suffix']) ? ' <span class="field-suffix">' . $element ['#field_suffix'] . '</span>' : '';

  switch ($element ['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      $output .= ' ' . $prefix . $element ['#children'] . $suffix . "\n";
      break;

    case 'after':
      $output .= ' ' . $prefix . $element ['#children'] . $suffix;
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $prefix . $element ['#children'] . $suffix . "\n";
      break;
  }

  if (!empty($element ['#description'])) {
    $output .= '<div class="description">' . $element ['#description'] . "</div>\n";
  }

  $output .= "";

  return $output;
}

/**
 * Implement hook_select()
 * @param type $variables
 * @return type
 */
function v2_mumm_select($variables) {
  $element = $variables['element'];
  element_set_attributes($element, array('id', 'name', 'size'));
  _form_set_class($element, array('form-select'));
  $select_name = $variables['element']['#name'];
  if ($select_name == 'country') {
    return '<select' . drupal_attributes($element['#attributes']) . '>' . v2_mumm_form_select_options($element) . '</select>';
  }
  else {
    return '<select' . drupal_attributes($element ['#attributes']) . '>' . form_select_options($element) . '</select>';
  }
}

/**
 * Implement hook_preprocess_taxonomy_term()
 */
function v2_mumm_preprocess_taxonomy_term(&$variables) {
  if ($variables['vocabulary_machine_name'] == 'champagne_categories') {
    $contextual_links = array(
      '#type' => 'contextual_links',
      '#contextual_links' => array(
        'taxonomy' => array('taxonomy/term', array($variables['tid'])),
      ),
    );
    $variables['title_suffix']['contextual_links'] = $contextual_links;
  }
}

/**
 * Override webform element text.
 * Hidden parent field (fieldset), set same line for all remain fields.
 * Output a form element in plain text format.
 */
function v2_mumm_webform_element_text($variables) {
  $element = $variables['element'];
  $value = $variables['element']['#children'];

  $output = '';
  $is_group = webform_component_feature($element['#webform_component']['type'], 'group');

  // Output the element title.
  if (isset($element['#title'])) {
    if ($is_group) {
      // Hidden fieldset.
      // $output .= '--' . $element['#title'] . '--';
      $output .= '';
    }
    elseif (!in_array(drupal_substr($element['#title'], -1), array('?', ':', '!', '%', ';', '@'))) {
      $output .= $element['#title'] . ': ';
    }
    else {
      $output .= $element['#title'];
    }
  }

  // Wrap long values at 65 characters, allowing for a few fieldset indents.
  // It's common courtesy to wrap at 75 characters in e-mails.
  if ($is_group && drupal_strlen($value) > 65) {
    $value = wordwrap($value, 65, "\n");
    $lines = explode("\n", $value);
    foreach ($lines as $key => $line) {
      $lines[$key] = '' . $line;
    }
    // Remove unused break line.
    // $value = implode("\n", $lines);
  }

  // Add the value to the output. Add a newline before the response if needed.
  // Remove unused break line.
  // $output .= (strpos($value, "\n") === FALSE ? ' ' : "\n") . $value;
  $output .= $value;

  // Indent fieldsets.
  if ($is_group) {
    $lines = explode("\n", $output);
    foreach ($lines as $number => $line) {
      if (strlen($line)) {
        $lines[$number] = '' . $line;
      }
    }
    $output = implode("\n", $lines);
    // Remove unused break line.
    // $output .= "\n";
  }

  if ($output) {
    if (!$is_group) {
      $output .= "\n";
    }
  }

  return $output;
}

function mumm_v2_preprocess_page_add_hreflang(&$node) {
  // Add the default page
  global $language;

  // Define hreflang replacements for special cases
  $hreflang_overrides = array(
    array('en-uk'),
    array('en-gb'),
  );

  /* $element = array(
    '#tag' => 'link',
    '#attributes' => array(
    'hreflang' => 'x-default',
    'rel' => 'alternate',
    'href' => url('<front>', array(
    'absolute' => true,
    'language' => language_default(),
    ))
    ),
    ); */

  drupal_add_html_head($element, 'hreflang_x_default');

  // Add the page and all its translations
  $t_nodes = mumm_helpers_get_node_translations($node);
  if (!$t_nodes) {
    return;
  }

  $languages = language_list();
  $languages_code = array();

  foreach ($languages as $language_item) {
    $language_code = substr($language_item->prefix, 0, 2);
    if (isset($languages_code[$language_code])) {
      $languages_code[$language_code] ++;
    }
    else {
      $languages_code[$language_code] = 1;
    }
  }

  foreach ($t_nodes as $t_node) {

    $hreflang = FALSE;
    $language_object = FALSE;

    foreach ($languages as $language_item) {
      if ($language_item->language == $t_node->language) {
        $language_code = substr($language->prefix, 0, 2);
        if ($languages_code[$language_code] == 1) {
          $hreflang = $language_item->prefix;
        }
        else {
          $hreflang = $language_item->prefix;
        }
        $language_object = $language_item;
        break;
      }
    }

    $url = url(drupal_is_front_page() ? '<front>' : sprintf('node/%s', $t_node->nid), array(
      'absolute' => TRUE,
      'alias' => FALSE,
      'language' => $language_object
        )
    );


    $element = array(
      '#tag' => 'link',
      '#attributes' => array(
        'hreflang' => $language_object->prefix,
        'rel' => 'alternate',
        'href' => urldecode($url),
      ),
    );

    drupal_add_html_head($element, sprintf('hreflang_%s_%s', $t_node->nid, $t_node->language));
  }
}

/**
 * Implement hook_preprocess_panels_pane().
 * @param string $vars
 */
function v2_mumm_preprocess_panels_pane(&$vars) {
  $content = &$vars['content'];
  if (isset($content['node'])) {
    $node = $content['node'];
    if (isset($node['#sorted'])) {
      unset($node['#sorted']);
      foreach ($node as $key => $value) {
        if (isset($value['#node']) && $value['#node']->type == 'modular_page') {
          if (isset($value['#node']->field_modular_page_template['und'][0]['value'])) {
            $template = $value['#node']->field_modular_page_template['und'][0]['value'];
            if ($template == 'default') {
                $vars['content']['node'][$key]['#theme'] = array('node__modular_page__full');
            }
          }
        }
      }
    }
  }
}
