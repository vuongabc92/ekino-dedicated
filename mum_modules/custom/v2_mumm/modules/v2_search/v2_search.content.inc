<?php

/**
 * @file
 * to provide function for search module.
 */

/**
 * Search callback for custom search page.
 */
function v2_search_page() {
  $parameters = drupal_get_query_parameters();
  $key_word = isset($parameters['keyword']) ? $parameters['keyword'] : '';
  $product_champagnes = v2_search_content($key_word, array('product_champagne'),V2_SEARCH_MORE_PRODUCT);  
  $articles = v2_search_content($key_word, array('article'),V2_SEARCH_MORE_ARTICLE);  
  $total = count($articles['total']) + count($product_champagnes['total']);
  
  $html = theme('heading_content', array('key_word' => $key_word, 'total' => $total));
  $html .= theme('v2_search_product_champagne_wrapper', array(
    'nodes' => $product_champagnes['nodes'],
    'total' => $product_champagnes['total'],
    'key_word' => $key_word,
    'number_item' => V2_SEARCH_MORE_PRODUCT,
      )
  );

  $html .= theme('v2_search_article_wrapper', array(
    'nodes' => $articles['nodes'],
    'total' => $articles['total'],
    'key_word' => $key_word,
    'number_item' => V2_SEARCH_MORE_ARTICLE,
      )
  );
  

  return isset($html) ? $html : '';
}

/**
 * Callback for loading more content on search page.
 *
 * @param string $key_word
 *   key_word is used to search.
 *
 * @param string $type
 *   Type of content is need to loaded more.
 *
 * @param int $total
 *   Total of content have been searched.
 */
function v2_search_load_more($key_word, $type) {
  
  $types = array(
    'article' => V2_SEARCH_MORE_ARTICLE,
    'product_champagne' => V2_SEARCH_MORE_PRODUCT,
    
  );
 
  $results = v2_search_content($key_word, array($type), $types[$type]);  
  
  $content = '';
  $nodes = $results['nodes'];
  $page = $_GET['page'];
  $remain = count($nodes);
  if ($page == ($results['max_page'] - 1)) {
    $remain = 0;
  }
  if ($nodes) :
    $content[] = trim(theme('v2_search_' . $type . '_item', array('nodes' => $nodes)));
  endif;
  
  $json = array(
    'status' => "ok",
    'remain' => $remain,
    'content' => $content,
  );
  
  return drupal_json_output($json);
  die;
}
