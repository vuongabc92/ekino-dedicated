<?php

function thuraya_comment_post_forbidden($variables) {
  $node = $variables['node'];
  global $user;

  // Since this is expensive to compute, we cache it so that a page with many
  // comments only has to query the database once for all the links.
  $authenticated_post_comments = &drupal_static(__FUNCTION__, NULL);

  if (!$user->uid) {
    if (!isset($authenticated_post_comments)) {
      // We only output a link if we are certain that users will get permission
      // to post comments by logging in.
      $comment_roles = user_roles(TRUE, 'post comments');
      $authenticated_post_comments = isset($comment_roles[DRUPAL_AUTHENTICATED_RID]);
    }

    if ($authenticated_post_comments) {
      // We cannot use drupal_get_destination() because these links
      // sometimes appear on /node and taxonomy listing pages.
      if (variable_get('comment_form_location_' . $node->type, COMMENT_FORM_BELOW) == COMMENT_FORM_SEPARATE_PAGE) {
        $destination = array('destination' => "comment/reply/$node->nid#comment-form");
      }
      else {
        $destination = array('destination' => "node/$node->nid#comment-form");
      }

      if (variable_get('user_register', USER_REGISTER_VISITORS_ADMINISTRATIVE_APPROVAL)) {
        // Users can register themselves.
        return t('<a href="@login">Log in</a> or <a href="@register">register</a> to Apply', array('@login' => url('user/login', array('query' => $destination)), '@register' => url('user/register', array('query' => $destination))));
      }
      else {
        // Only admins can add new users, no public registration.
        return t('<a href="@login">Log in</a> to Apply', array('@login' => url('user/login', array('query' => $destination))));
      }
    }
  }
}



function thuraya_form_element($variables) {
  $element = &$variables['element'];
  // This is also used in the installer, pre-database setup.
  $t = get_t();

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
  );

  // Add element #id for #type 'item'.
  if (isset($element['#markup']) && !empty($element['#id'])) {
    $attributes['id'] = $element['#id'];
  }
  // Add element's #type and #name as class to aid with JS/CSS selectors.
  $attributes['class'] = array('form-item');
  /*if (!empty($element['#type'])) {
    $attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');
  }*/

  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'form-disabled';
  }
 if($element['#type'] !='checkbox'){
	   $output = '<div' . drupal_attributes($attributes) . '>' . "\n";
 }else {
  $output = '<li' . drupal_attributes($attributes) . '>';
 }

  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }
  $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';
  $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;

    case 'after':
      $output .= ' ' . $prefix . $element['#children'] . $suffix;
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
  }

  if (!empty($element['#description'])) {
    $output .= '<div class="description">' . $element['#description'] . "</div>\n";
  }
 if($element['#type'] !='checkbox'){

  $output .= "</div>\n";
 } else {
  $output .= "</li>";

 }

  return $output;
}

function thuraya_form_element_label($variables) {
  $element = $variables['element'];
  // This is also used in the installer, pre-database setup.
  $t = get_t();

  // If title and required marker are both empty, output no label.
  if ((!isset($element['#title']) || $element['#title'] === '') && empty($element['#required'])) {
    return '';
  }

  // If the element is required, a required marker is appended to the label.
  $required = !empty($element['#required']) ? theme('form_required_marker', array('element' => $element)) : '';

  $title = filter_xss_admin($element['#title']);

  $attributes = array();
  // Style the label as class option to display inline with the element.
  if ($element['#title_display'] == 'after') {
    $attributes['class'] = 'option';
  }
  // Show label only to screen readers to avoid disruption in visual flows.
  elseif ($element['#title_display'] == 'invisible') {
    $attributes['class'] = 'element-invisible';
  }

  if (!empty($element['#id'])) {
    $attributes['for'] = $element['#id'];
  }

  // The leading whitespace helps visually separate fields from inline labels.
  return ' <label' . drupal_attributes($attributes) . '>' . $t('!title !required', array('!title' => $title, '!required' => $required)) . "</label>\n";
}

function thuraya_checkboxes($variables) {
  $element = $variables['element'];
  $attributes = array();
  if (isset($element['#id'])) {
    $attributes['id'] = $element['#id'];
  }
/*$attributes['class'][] = 'form-checkboxes';
  if (!empty($element['#attributes']['class'])) {
    $attributes['class'] = array_merge($attributes['class'], $element['#attributes']['class']);
  }*/
  if (isset($element['#attributes']['title'])) {
   // $attributes['title'] = $element['#attributes']['title'];
  }
  return '<ul>' . (!empty($element['#children']) ? $element['#children'] : '') . '</ul>';
}

function thuraya_checkbox($variables) {
  $element = $variables['element'];
  $t = get_t();
  $element['#attributes']['type'] = 'checkbox';
  element_set_attributes($element, array('id', 'name','#return_value' => 'value'));

  // Unchecked checkbox has #value of integer 0.
  if (!empty($element['#checked'])) {
    $element['#attributes']['checked'] = 'checked';
  }
  _form_set_class($element, array('form-checkbox'));

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}

function thuraya_fieldset($variables) {
  $element = $variables['element'];
  element_set_attributes($element, array('id'));
  _form_set_class($element, array('form-wrapper'));


  $output .= '<div class="fieldset-wrapper">';
  if (!empty($element['#description'])) {
    $output .= '<div class="fieldset-description">' . $element['#description'] . '</div>';
  }
  $output .= $element['#children'];
  if (isset($element['#value'])) {
    $output .= $element['#value'];
  }
  $output .= '</div>';
  return $output;
}

function thuraya_theme($existing, $type, $theme, $path){
  $hooks['user_register_form']=array(
    'render element'=>'form',
    'template' =>'templates/user-register',
  );
   $hooks['user_profile_form']=array(
    'template' =>'templates/user-profile-edit',
	 'render element'=>'form',
  );
  $hooks['user_login'] = array(
    'template' => 'templates/user_login',
    'render element' => 'form',
  );
return $hooks;
}

/*function thuraya_preprocess_user_login(&$variables) {
  $variables['intro_text'] = t('Already registered? Please enter your user details below:');
  $variables['rendered'] = drupal_render_children($variables['form']);
}*/

function thuraya_preprocess_page(&$variables, $hook) {

$variables['mobile_content'] = theme('mobile_page',array('mobile'=>$variables));
$variables['mod_header'] = theme('mobile_header',array('mobile'=>$variables));
$variables['mod_footer'] = theme('mobile_footer',array('mobile'=>$variables));

  $views_page = views_get_page_view();
  //print "view name   :  ".$views_page->name;
  //exit();
  if ($views_page != "" && $views_page->name === "sector") {
      $variables['theme_hook_suggestions'][] = 'page__views__sector';
  } elseif ($views_page != "" && $views_page->name === "products_list") {
      $variables['theme_hook_suggestions'][] = 'page__views__products';
  } elseif ($views_page != "" && ($views_page->name === "clone_of_where_to_buy")) {
		//$variables['theme_hook_suggestions'][] = 'page__views__where2buy';
		//$variables['theme_hook_suggestions'][] = 'page__views__wheretobuy';
  } elseif ($views_page != "" && ($views_page->name === "service_partners")) {
      $variables['theme_hook_suggestions'][] = 'page__views__wheretobuyatoz';
  } elseif ($views_page != "" && $views_page->name === "press_list") {
	$variables['theme_hook_suggestions'][] = 'page__views__presslist';
  } elseif($views_page != "" && $views_page->name === "blog_list") {
	$variables['theme_hook_suggestions'][] = 'page__views__bloglist';
 } elseif($views_page != "" && $views_page->name === "faq_products") {
	$variables['theme_hook_suggestions'][] = 'page__views__faqs';
 } elseif($views_page != "" && $views_page->name === "product_faqs") {
	$variables['theme_hook_suggestions'][] = 'page__views__faqlist';
 } elseif ($views_page != "" && $views_page->name === "article_list") {
	$variables['theme_hook_suggestions'][] = 'page__views__articlelist';
  } elseif ($views_page != "" && $views_page->name === "media_gallery") {
	$variables['theme_hook_suggestions'][] = 'page__views__mediagallery';
  } elseif ($views_page != "" && $views_page->name === "product_category") {
      $variables['theme_hook_suggestions'][] = 'page__views__product__category';
  } elseif ($views_page != "" && $views_page->name === "product_upgrades") {
      $variables['theme_hook_suggestions'][] = 'page__views__product__upgrades';
  } elseif($views_page != "" && $views_page->name === "product_upgrade_details") {
	$variables['theme_hook_suggestions'][] = 'page__views__upgrade__details';
  } elseif ($views_page != "" && $views_page->name === "job_posting" ||
	  $views_page->name === "job_applications") {
      $variables['theme_hook_suggestions'][] = 'page__user';
  } elseif ($views_page != "" && $views_page->name === "albums_list") {
	$variables['theme_hook_suggestions'][] = 'page__views__albums';
  } elseif ($views_page != "" && $views_page->name === "where_to_buy_spiderify") {
	//$variables['theme_hook_suggestions'][] = 'page__views__where2buy';
  }


  if (arg(0)=='search' && arg(1) && arg(2)) {
    $variables['theme_hook_suggestions'][] = 'page__type__coveredmap';
  }

  if(isset($variables['node'])){
	if($variables['node']->type == 'sector' || $variables['node']->type == 'solution'){
		$variables['theme_hook_suggestions'][] = 'page__type__sector';
	} elseif($variables['node']->type == 'product'){
		$variables['theme_hook_suggestions'][] = 'page__type__product';
    } elseif($variables['node']->type == 'page' && $variables['node']->nid == 35){
		//Custom page for Contact Us page to disable left menu
		$variables['theme_hook_suggestions'][] = 'page__type__contactus';
	} elseif($variables['node']->type == 'page' && $variables['node']->nid == 875){
		//Custom page for Covered Map page to disable left menu
		$variables['theme_hook_suggestions'][] = 'page__type__coveredmap';
	}  elseif($variables['node']->type == 'job_posting'){
		$variables['theme_hook_suggestions'][] = 'page__type__postings';
    }

	//Activate Menu Items in subpages
	switch ($variables['node']->type) {
		case 'product':
			menu_set_active_item('products-list');
			break;
		case 'press_article':
			menu_set_active_item('press-list');
			break;
		case 'sector':
		case 'solution':
			menu_set_active_item('sector');
			break;
	}
  }
  //Customize the node type when page category is none in Basicpage content type.
  if(isset($variables['node']->field_page_category)){
  	 $pageCategoryType = $variables['node']->field_page_category;
  	 if($pageCategoryType == array() && $pageCategory['und'] == ''){
  	 	$variables['theme_hook_suggestions'][] = 'page__type__generic';
  	 }
    if(is_object($pageCategoryType['und'][0]['taxonomy_term'])){
  	  	$taxonomy_termObj = $pageCategoryType['und'][0]['taxonomy_term'];
  	  	if($taxonomy_termObj->name == 'Campaigns-SingleColumn'){
  	  		$variables['theme_hook_suggestions'][] = 'page__type__campaign';
  	  	}
  	 }
  }
 }

// Customize menu li & links
function thuraya_preprocess_menu_link($variables)
{
    //print_r($variables); exit;
	$element    = $variables['element'];
    $sub_menu   = '';

    if ($element['#below']) {
        $sub_menu = drupal_render($element['#below']);
    }

    // Enable this to use html in title, eg img, span or something else...
    $element['#localized_options']['html'] = true;

	$link = l('<span>' . $element['#title'] . '</span>', $element['#href'], $element['#localized_options']);

    return '<li' . drupal_attributes($element['#attributes']) . '>' . $link . $sub_menu . "</li>n";
}

function thuraya_menu_link__menu_block(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . " <span class='ui-icon left-arrow'></span></li>\n";
}

function thuraya_tagadelic_weighted(array $vars) {
	$terms = $vars['terms'];
	$output = '';
  $i=1;
	foreach ($terms as $term) {
 if($i<=12){

 $result_obj = db_query('SELECT tid FROM taxonomy_term_hierarchy where tid= :tid', array(':tid'=>$term->tid));
 $result = $result_obj->fetchAll();
if(!empty($result)){
	  $output .= l($term->name, 'article-list/' . $term->tid,
		array(
		  'attributes' => array(
			'class' => array("tagadelic", "level" . $term->weight),
			'rel' => 'tag',
			'title'  => $term->description,
		  )
		)
	  ) . " \n";
	  $i++;
	}
	}
	}
	return $output;
}

function thuraya_pager($variables) {
  $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
 // $quantity = $variables['quantity'];
  $quantity = 5;
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.


  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  //$li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('� first')), 'element' => $element, 'parameters' => $parameters));
  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('� previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('next �')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  //$li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t('last �')), 'element' => $element, 'parameters' => $parameters));

  if ($pager_total[$element] > 1) {
    /*if ($li_first) {
      $items[] = array(
        'class' => array('pager-first'),
        'data' => $li_first,
      );
    }*/
    if ($li_previous) {
      $items[] = array(
        //'class' => array('pager-previous'),
		'class' => array('ui-icon prev-act'),
        'data' => $li_previous,
      );
    } else {
		$items[] = array(
        //'class' => array('pager-previous'),
		'class' => array('ui-icon prev'),
        'data' => 'first',
      );
	}

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      /*if ($i > 1) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '�',
        );
      }*/
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array('pager-current'),
            'data' => $i,
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
          );
        }
      }

      if ($i <= $pager_max) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => theme('pager_next', array('text' => '.. '.$pager_max, 'element' => $element, 'interval' => ($pager_max - $pager_current), 'parameters' => $parameters)),
        );
      }
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
       // 'class' => array('pager-next'),
		'class' => array('ui-icon next-act'),
        'data' => $li_next,
      );
    } else {
		$items[] = array(
        //'class' => array('pager-next'),
		'class' => array('ui-icon next'),
        'data' => 'end',
      );
	}
    /*if ($li_last) {
      $items[] = array(
        'class' => array('pager-last'),
        'data' => $li_last,
      );
    }*/
    return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
      'items' => $items,
      'attributes' => array('class' => array('paging')),
    ));
  }
}


function thuraya_links($variables) {
  $links = $variables['links'];
  $attributes = $variables['attributes'];
  $heading = $variables['heading'];
  global $language_url;
  $output = '';

  if (count($links) > 0) {
    $output = '';

    // Treat the heading first if it is present to prepend it to the
    // list of links.
    if (!empty($heading)) {
      if (is_string($heading)) {
        // Prepare the array that will be used when the passed heading
        // is a string.
        $heading = array(
          'text' => $heading,
          // Set the default level of the heading.
          'level' => 'h2',
        );
      }
      $output .= '<' . $heading['level'];
      if (!empty($heading['class'])) {
        $output .= drupal_attributes(array('class' => $heading['class']));
      }
      $output .= '>' . check_plain($heading['text']) . '</' . $heading['level'] . '>';
    }

    $output .= '<ul' . drupal_attributes($attributes) . '>';

    $num_links = count($links);
    $i = 1;

    foreach ($links as $key => $link) {
      $class = array($key);

      // Add first, last and active classes to the list of links to help out themers.
      if ($i == 1) {
        $class[] = 'first';
      }
      if ($i == $num_links) {
        $class[] = 'last';
      }
      if (isset($link['href']) && ($link['href'] == $_GET['q'] || ($link['href'] == '<front>' && drupal_is_front_page()))
           && (empty($link['language']) || $link['language']->language == $language_url->language)) {
        $class[] = 'active';
      }
      $output .= '<li' . drupal_attributes(array('class' => $class)) . '>';

      if (isset($link['href'])) {
        // Pass in $link as $options, they share the same keys.
        $output .= l($link['title'], $link['href'], $link);
      }
      elseif (!empty($link['title'])) {
        // Some links are actually not links, but we wrap these in <span> for adding title and class attributes.
        if (empty($link['html'])) {
          $link['title'] = check_plain($link['title']);
        }
        $span_attributes = '';
        if (isset($link['attributes'])) {
          $span_attributes = drupal_attributes($link['attributes']);
        }
        $output .= '<div' . $span_attributes . '>' . $link['title'] . '</div>';
      }

      $i++;
      $output .= "</li>\n";
    }

    $output .= '</ul>';
  }

  return $output;
}

function thuraya_form_alter(&$form, $form_state, $form_id) {
//print_r($form_id); exit;
  if ($form_id == "webform_client_form_54") {
		$form['submitted']['comments']['#default_value']="Requesting information for: ".drupal_get_title()."\n";
  }
  if ($form_id == 'search_form'){
      $form['basic']['keys']['#title'] = '';
      //$form['basic']['submit']['#value'] = 'Test';
    //  dsm($form); // Use for debugging
  }
  /*if ($form_id == "webform_client_form_949") {
  	//print_r($form["submitted"]);
	 foreach ($form["submitted"] as $key => $value) {
          if (in_array($value["#type"], array("textfield", "webform_email", "textarea"))) {
              $form["submitted"][$key]['#attributes']["placeholder"] = '';
             // $form["submitted"][$key]['#title_display'] = 'invisible';
          }
      }
  }
*/
}

function drop_down_menus(){
 return "<form><select onchange='window.location.href=this.form.URL.options[this.form.URL.selectedIndex].value' name='URL' id='mob-menu' class='device-menu' >
 <option value='/' >Home</option><optgroup label='About Us'>
 <option value='/who-we-are'>Who We Are</option>
 <option value='/our-vision-mission-values'>Vision, Mission & Values</option>
 <option value='/shareholders'>Shareholders</option>
 <option value='/board-of-directors'>Board of Directors</option>
 <option value='/executive-team'>Executive Team</option>
 <option value='/corporate-milestones'>Milestones</option>
 <option value='/network-coverage'>Network Coverage</option>
 <option value='/corporate-social-responsibility'>Corporate Social Responsibility</option>
 <option value='/contact-us'>Contact Us</option></optgroup>
 <optgroup label='Sectors'>
 <option value='/sector' >Sectors</option>
 <option value='/government-comms' >GovernmentComms</option>
 <option value='/energy-comms' >EnergyComms</option>
 <option value='/enterprise-comms' >EnterpriseComms</option>
 <option value='/leisure-comms' >LeisureComms</option>
 <option value='/media-comms' >MediaComms</option>
 <option value='/marine-comms' >MarineComms</option>
 <option value='/relief-comms' >ReliefComms</option>
 </optgroup>
 <optgroup label='Products'>
 <option value='/products-list' >Products</option>
 <option value='/products/2' >Land Voice</option>
 <option value='/products/1' >Land Data</option>
 <option value='/products/29' >Marine</option>
 </optgroup>
  <optgroup label='Services'>
 <option value='/capacity-leasing'>Capacity Leasing</option>
 <option value='/value-added-services'>Value Added Services</option>
 </optgroup>
  <optgroup label='Where To Buy'>
 <option value='/where-to-buy' >Services Partners Map</option>
 <option value='/service-partners' >Services Partners A-Z</option>
 <option value='/pricing-plans'>Pricing</option>
 <option value='/become-a-partner' >Become a Partner</option>
  </optgroup>
  <optgroup label='Support'>
 <option value='/contact-us' >Contact Us</option>
 <option value='/support'>Support</option>
 <option value='/technology-explained' >Technology  Explained</option>
 <option value='/faq' >Knowledge Center</option>
 <option value='/upgrades' >Upgrades</option>
 <option value='http://www.thurayarecharge.com/' >Phone Recharge</option>
 </optgroup>
  <optgroup label='Press Center'>
 <option value='/press-list' >Press Releases </option>
 <option value='/press-packs' >Press Packs </option>
 <option value='/media-gallery' >Media Gallery </option>
 <option value='/content/thuraya-events-calendar' >Events </option>
 <option value='/blog' >Blogs </option>
 </optgroup>
 </select></form>";
}

function share_icons(){
$html = '<ul class="sn" id="snMenuItems">
	<li><a class="ui-icon rss" href="javascript:void(0)">&nbsp;</a>
	<ul id="submMenu">
		<li class="rss_plus_blog"><a href="/blog/rss.xml" target="_blank">Blog RSS</a></li>
		<li class="rss_plus_press"><a href="/press/rss.xml" target="_blank">Press release RSS</a></li>
	</ul>
	</li>
	<li><a class="ui-icon in" href="http://in.linkedin.com/company/thuraya" target="_blank">&nbsp;</a></li>
	<li><a class="ui-icon yt" href="http://www.youtube.com/user/ThurayaTelecom" target="_blank">&nbsp;</a></li>
	<li><a class="ui-icon fb" href="https://www.facebook.com/ThurayaTelecommunications" target="_blank">&nbsp;</a></li>
	<li><a class="ui-icon tw" href="https://twitter.com/ThurayaTelecom" target="_blank">&nbsp;</a></li>
</ul>';
return $html;
}

function mobile_footer(){

$html = '<ul>
<li class="borderR"><div class="tp-login"><a href="http://connect.thuraya.com/" target="_blank"><span class="tui-icon i-login"></span>Partner Login</a></div></li>
	<li><a href="/network-coverage">Network Coverage</a></li>
	<li class="borderR borderT"><a href="/careers">Careers</a></li>
	<li class="borderT"><a href="/contact-us">Contact us</a></li>
</ul>';
return $html;
}