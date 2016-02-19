<?php

define('TWITTER_HEIGHT', 251);
define('TWITTER_WITH', 435);

/**
 * Implements hook_preprocess_html().
 */
function babybel_preprocess_html(&$vars) {
  $arg = arg();
  if ($arg && isset($arg[0])) {
    babybel_config_meta_tag($arg[0]);
  }
  $vars['head_title'] = drupal_get_title();
}

/**
 *  Implements hook_preprocess_page().
 */
function babybel_preprocess_page(&$vars, $hook) {
  global $user, $language;
  $url = $GLOBALS['base_url'];
  $arg = arg();
  if ($vars && isset($vars)) {
    $access_lang = variable_get('access_lang_' . $language->language, '');
    if (is_array($access_lang) && $access_lang[1] == "1") {
      if (!user_is_logged_in()) {
        if ($GLOBALS['_GET']['q'] != "user") {
          if ($GLOBALS['_GET']['q'] != "welcome") {
            header('Location: ' . $url);
          }
        }
      }
      if (array_key_exists(4, $user->roles) && $user->language != $language->language) {
        drupal_goto($url);
      }
    }
  }
  // Set title page.
  if ($arg && isset($arg[0])) {
    $params_meta = babybel_config_meta_tag($arg[0]);
    if ($params_meta['title']) {
      drupal_set_title($params_meta['title']);
    }
    else {
      drupal_set_title($params_meta['title_page']);
    }
  }


  // Hook change suggestion theme for dispatch.
  $dispatch_page = variable_get('language_selection_page_path', 'language_selection');
  if ($arg[0] == $dispatch_page) {
    $vars['theme_hook_suggestions'][] = 'page__dispatch_page';
  }
  babybel_unset_context_link($vars); // Unset contextual link.
  $common_css = array(
    'main.html',
    'style'
  );
  $common_js = array(
    'libs',
    'script',
  );
  babybel_include_asset($common_css, 'css');
  babybel_include_common_js($common_js);
  // Homepage.
  $js = $css = array();
  if ($vars['is_front']) {
    
  }
}

/**
 * Implement include css/js for each page.
 */
function babybel_include_asset($variable, $type) {
  $path = drupal_get_path('theme', 'babybel');
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
  // add css Shariff Social Media Buttons
  $path = libraries_get_path('shariff-master');
  drupal_add_css($path . '/build/shariff.complete.css', array(
        'group' => CSS_THEME,
        'type' => 'file',
        'media' => 'screen',
        'preprocess' => FALSE,
        'every_page' => FALSE,
        'group' => CSS_THEME,
      ));
}

/**
 * Implement include js common in footer for every page.
 */
function babybel_include_common_js($variable) {
  $path = drupal_get_path('theme', 'babybel');
  foreach ($variable as $item) {
    drupal_add_js($path . '/js/' . $item . '.js', array(
      'type' => 'file',
      'scope' => 'footer',
      'group' => JS_THEME,
      'every_page' => TRUE,
      'weight' => -1,
    ));
  }
  // add js Shariff Social Media Buttons
  $path = libraries_get_path('shariff-master');
   drupal_add_js($path . '/build/shariff.complete.js', array(
      'type' => 'file',
      'scope' => 'footer',
      'group' => JS_THEME,
      'every_page' => TRUE,
      'weight' => -1,
    ));
}


/**
 * Get the direction path from a theme.
 */
function baybel_get_path($dir_name = NULL, $theme_name = NULL) {
  if (empty($dir_name)) {
    return NULL;
  }
  global $base_url, $theme;
  $theme_name = (empty($theme_name)) ? $theme : $theme_name;
  return $base_url . '/' . drupal_get_path('theme', $theme_name) . '/' . $dir_name . '/';
}

function babybel_preprocess_node(&$vars) {
  if ($vars['view_mode'] == 'slider') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__slider';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__slider';
  }
  if ($vars['view_mode'] == 'video_player') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__video_player';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__video_player';
  }
  if ($vars['view_mode'] == 'product_home') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__product_home';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__product_home';
  }
  if ($vars['view_mode'] == 'product_products') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__product_products';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__product_products';
  }
  if ($vars['view_mode'] == 'product_detail_products') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__product_detail_products';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__product_detail_products';
  }
  if ($vars['view_mode'] == 'tip_products') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__tip_products';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__tip_products';
  }
  if ($vars['view_mode'] == 'tip_detail_products') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__tip_detail_products';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__tip_detail_products';
  }
  if ($vars['view_mode'] == 'article_homepage') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__article_homepage';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__article_homepage';
  }
  if ($vars['view_mode'] == 'article_fun_stuff_first') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__article_fun_stuff_first';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__article_fun_stuff_first';
  }
  if ($vars['view_mode'] == 'article_fun_stuff_supercheese') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__article_fun_stuff_supercheese';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__article_fun_stuff_supercheese';
  }
  if ($vars['view_mode'] == 'article_our_secret') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__article_our_secret';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__article_our_secret';
  }
  if ($vars['view_mode'] == 'article_milk_origins') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__article_milk_origins';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__article_milk_origins';
  }
  if ($vars['view_mode'] == 'cheese_steps') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__cheese_steps';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__cheese_steps';
  }
  if ($vars['view_mode'] == 'fun_stuff') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__fun_stuff';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__fun_stuff';
  }
  if ($vars['view_mode'] == 'news') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__news';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__news';
  }
  if ($vars['view_mode'] == 'iframe') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__iframe';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__iframe';
  }
  if ($vars['view_mode'] == 'article_cherity') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__article_cherity';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__article_cherity';
  }
  if ($vars['view_mode'] == 'video_player_charity') {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type . '__video_player_charity';
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->nid . '__video_player_charity';
  }
}

/**
 * Implement unset contextual link.
 */
function babybel_unset_context_link(&$vars) {
  // Unset contextual_links header.
  if ($vars['page']['header']['babybel_common_babybel_header']['#contextual_links']) {
    unset($vars['page']['header']['babybel_common_babybel_header']['#contextual_links']);
  }
  // Unset contextual_links footer.
  if ($vars['page']['footer']['babybel_common_babybel_footer']['#contextual_links']) {
    unset($vars['page']['footer']['babybel_common_babybel_footer']['#contextual_links']);
  }
  return $vars;
}

/*
  function babybel_preprocess_region(&$vars,$hook) {
  //  kpr($vars['content']);
  }
 */
/*
  function babybel_preprocess_block(&$vars, $hook) {
  //  kpr($vars['content']);

  //lets look for unique block in a region $region-$blockcreator-$delta
  $block =
  $vars['elements']['#block']->region .'-'.
  $vars['elements']['#block']->module .'-'.
  $vars['elements']['#block']->delta;

  // print $block .' ';
  switch ($block) {
  case 'header-menu_block-2':
  $vars['classes_array'][] = '';
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
 */
/*
  function babybel_preprocess_node(&$vars,$hook) {
  //  kpr($vars['content']);

  // add a nodeblock
  // in .info define a region : regions[block_in_a_node] = block_in_a_node
  // in node.tpl  <?php if($noderegion){ ?> <?php print render($noderegion); ?><?php } ?>
  //$vars['block_in_a_node'] = block_get_blocks_by_region('block_in_a_node');
  }
 */
/*
  function babybel_preprocess_comment(&$vars,$hook) {
  //  kpr($vars['content']);
  }
 */
/*
  function babybel_preprocess_field(&$vars,$hook) {
  //  kpr($vars['content']);
  //add class to a specific field
  switch ($vars['element']['#field_name']) {
  case 'field_ROCK':
  $vars['classes_array'][] = 'classname1';
  case 'field_ROLL':
  $vars['classes_array'][] = 'classname1';
  $vars['classes_array'][] = 'classname2';
  $vars['classes_array'][] = 'classname1';
  case 'field_FOO':
  $vars['classes_array'][] = 'classname1';
  case 'field_BAR':
  $vars['classes_array'][] = 'classname1';
  default:
  break;
  }

  }
 */
/*
  function babybel_preprocess_maintenance_page(){
  //  kpr($vars['content']);
  }
 */
/*
  function babybel_form_alter(&$form, &$form_state, $form_id) {
  //if ($form_id == '') {
  //....
  //}
  }
 */

/**
 * Config for page second param not exist.
 */
function babybel_config_meta_tag($param) {
  global $language;
  $arg = arg();
  $open_graph_protocol = array();
  $fid = 0;
  switch ($arg[0]):
    case 'products':
      $open_graph_protocol['title_page'] = variable_get('babybel_variable_page_title_products_' . $language->language . '');
      $open_graph_protocol['title'] = variable_get('babybel_variable_meta_title_products_' . $language->language . '');
      $open_graph_protocol['description'] = variable_get('babybel_variable_meta_desc_products_' . $language->language . '');
      $fid = variable_get('babybel_variable_meta_images_products_' . $language->language . '');
      break;
    case 'our-secret':
      $open_graph_protocol['title_page'] = variable_get('babybel_variable_page_title_our_secret_' . $language->language . '');
      $open_graph_protocol['title'] = variable_get('babybel_variable_meta_title_our_secret_' . $language->language . '');
      $open_graph_protocol['description'] = variable_get('babybel_variable_meta_desc_our_secret_' . $language->language . '');
      $fid = variable_get('meta_images_our_secret_' . $language->language . '');
      break;
    case 'fun-stuff':
      $open_graph_protocol['title_page'] = variable_get('babybel_variable_page_title_funstuff_' . $language->language . '');
      $open_graph_protocol['title'] = variable_get('babybel_variable_meta_title_funstuff_' . $language->language . '');
      $open_graph_protocol['description'] = variable_get('babybel_variable_meta_desc_funstuff_' . $language->language . '');
      $fid = variable_get('meta_images_funstuff_' . $language->language . '');
      break;
    case 'news':
      $open_graph_protocol['title_page'] = variable_get('babybel_variable_page_title_news_' . $language->language . '');
      $open_graph_protocol['title'] = variable_get('babybel_variable_meta_title_news_' . $language->language . '');
      $open_graph_protocol['description'] = variable_get('babybel_variable_meta_desc_news_' . $language->language . '');
      $fid = variable_get('babybel_variable_meta_images_news_' . $language->language . '');
      break;
    case 'charity':
      $open_graph_protocol['title_page'] = variable_get('babybel_variable_page_title_charity_' . $language->language . '');
      $open_graph_protocol['title'] = variable_get('babybel_variable_meta_title_charity_' . $language->language . '');
      $open_graph_protocol['description'] = variable_get('babybel_variable_meta_desc_charity_' . $language->language . '');
      $fid = variable_get('babybel_variable_meta_images_charity_' . $language->language . '');
      break;
    case 'node':
      $alias_path = drupal_get_path_alias('node/' . $arg[1]);
      switch ($alias_path):
        case 'privacy':
          $open_graph_protocol['title_page'] = variable_get('babybel_variable_page_title_privacy_' . $language->language . '');
          $open_graph_protocol['title'] = variable_get('babybel_variable_meta_title_privacy_' . $language->language . '');
          $open_graph_protocol['description'] = variable_get('babybel_variable_meta_desc_privacy_' . $language->language . '');
          $fid = variable_get('babybel_variable_meta_images_privacy_' . $language->language . '');
          break;
        case 'terms-conditions':
          $open_graph_protocol['title_page'] = variable_get('babybel_variable_page_title_termconditions_' . $language->language . '');
          $open_graph_protocol['title'] = variable_get('babybel_variable_meta_title_termconditions_' . $language->language . '');
          $open_graph_protocol['description'] = variable_get('babybel_variable_meta_desc_termconditions_' . $language->language . '');
          $fid = variable_get('babybel_variable_meta_images_termconditions_' . $language->language . '');
          break;
      endswitch;
      break;
    default :
      $open_graph_protocol['title'] = variable_get('babybel_variable_meta_title_default_' . $language->language . '');
      $open_graph_protocol['description'] = variable_get('babybel_variable_meta_desc_default_' . $language->language . '');
  endswitch;
  if (drupal_is_front_page()) {
    $open_graph_protocol['title_page'] = variable_get('babybel_variable_page_title_homepage_' . $language->language . '');
    $open_graph_protocol['title'] = variable_get('babybel_variable_meta_title_homepage_' . $language->language . '');
    $open_graph_protocol['description'] = variable_get('babybel_variable_meta_desc_homepage_' . $language->language . '');
    $fid = variable_get('babybel_variable_meta_images_homepage_' . $language->language . '');
  }
  $dispatch_page = variable_get('language_selection_page_path', 'language_selection');
  if ($arg[0] == $dispatch_page) {
    $open_graph_protocol['title_page'] = variable_get('babybel_variable_meta_page_dispatch_' . $language->language . '');
    $open_graph_protocol['title'] = variable_get('babybel_variable_meta_title_dispatch_' . $language->language . '');
    $open_graph_protocol['description'] = variable_get('babybel_variable_meta_desc_dispatch_' . $language->language . '');
    $fid = variable_get('babybel_variable_meta_images_dispatch_' . $language->language . '');
  }
  if ($fid != 0) {
    $file = file_load($fid);
    if (!empty($file)) {
      $open_graph_protocol['image'] = file_create_url($file->uri);
    }
  }
  else {
    $open_graph_protocol['image'] = '';
  }
  babybel_add_meta_tag($open_graph_protocol);

  return $open_graph_protocol;
}

/**
 * Add meta tag for new page.
 */
function babybel_add_meta_tag($open_graph_protocol) {
  global $base_root;
  $elements = array();

  $elements[] = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'property' => 'og:title',
      'content' => $open_graph_protocol['title'],
    ),
  );
  if (arg(0) == 'news') {
    $elements[] = array(
      '#type' => 'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'og:url',
        'content' => $base_root . url($_GET['q']) . '#article-' . $_GET['id'],
      ),
    );
  }
  else {
    $elements[] = array(
      '#type' => 'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'og:url',
        'content' => $base_root . url($_GET['q']),
      ),
    );
  }

  $elements[] = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'property' => 'og:image',
      'content' => $open_graph_protocol['image'],
    ),
  );
  if (!empty($open_graph_protocol['description'])) {
    $elements[] = array(
      '#type' => 'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'og:description',
        'content' => htmlspecialchars_decode($open_graph_protocol['description'], ENT_QUOTES),
      ),
    );
  }
  $elements[] = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'property' => 'description',
      'content' => htmlspecialchars_decode($open_graph_protocol['description'], ENT_QUOTES),
    ),
  );
  $elements[] = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'property' => 'og:image:width',
      'content' => '200',
    ),
  );
  $elements[] = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'property' => 'og:image:height',
      'content' => '200',
    ),
  );

  // Twitter
  $elements[] = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'property' => 'twitter:title',
      'content' => $open_graph_protocol['title'],
    ),
  );
  if (!empty($open_graph_protocol['description'])) {
    $elements[] = array(
      '#type' => 'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'twitter:description',
        'content' => htmlspecialchars_decode($open_graph_protocol['description'], ENT_QUOTES),
      ),
    );
  }
  $elements[] = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'property' => 'twitter:image',
      'content' => $open_graph_protocol['image'],
    ),
  );
  $elements[] = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'property' => 'twitter:player:width',
      'content' => TWITTER_WITH,
    ),
  );
  $elements[] = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'property' => 'twitter:player:height',
      'content' => TWITTER_HEIGHT,
    ),
  );
  $i = 0;
  foreach ($elements as $element) {
    drupal_add_html_head($element, 'open_graph_protocol_' . $i++);
  }
}

// Custom Email template for webform.
function babybel_webform_element_text($variables) {
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

/**
 * Theme function for a CAPTCHA element.
 *
 * Remove title CAPTCHA when render google re-captcha.
 */
function babybel_captcha($variables) {
  $element = $variables['element'];
  if (!empty($element['#description']) && isset($element['captcha_widgets'])) {
    $fieldset = array(
      '#type' => 'fieldset',
      '#title' => t(''),
      '#description' => $element['#description'],
      '#children' => drupal_render_children($element),
      '#attributes' => array('class' => array('captcha')),
    );
    return theme('fieldset', array('element' => $fieldset));
  }
  else {
    return '<div class="captcha">' . drupal_render_children($element) . '</div>';
  }
}
