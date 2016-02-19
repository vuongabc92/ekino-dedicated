<?php

function v2_age_gate_form($form, &$form_state) {
  global $language;

  if ($form_state['submitted']) {
    //Handle the form submit result action with Javascript.
    if ($form_state['#changed_language']) {
      // We need to redirect the parent to another country.
      $redirect_path = call_user_func_array('url', $form_state['redirect']);

      drupal_add_js('jQuery(document).ready(function () {window.parent.location.href = "' . $redirect_path . '" });', 'inline');
    }
    else {
      // We stay on the same page. Just close the overlayer on the current page.
      drupal_add_js('jQuery(document).ready(function () {console.log("debug 123"); window.parent.jQuery(document.body).foundation("reveal", "close"); });', 'inline');
    }
    //Return an empty page.
    return array(
      '#theme' => 'v2_age_gate_noop',
    );
  }

  $country_vocabulary = taxonomy_vocabulary_machine_name_load('countries');
  $country_terms = taxonomy_get_tree($country_vocabulary->vid, 0, NULL, TRUE);
  $country_options = $country_ages = $country_full_birthday = $country_date_formats = $legal_drinking_age = $country_option_language = array();

  foreach ($country_terms as $country_term) {
    $wrapper = entity_metadata_wrapper('taxonomy_term', $country_term);
    $country_code = strtolower($wrapper->field_country_code->value());
    $region_term_id = '';
    if ($country_term->field_region_selection && count($country_term->field_region_selection)) {
      $region_term_id = $country_term->field_region_selection[LANGUAGE_NONE][0]['tid'];
    }
    $region_name = $region_term_id ? taxonomy_term_load($region_term_id)->name : t('OTHER COUNTRIES');
    $country_option_language[$country_code] = $country_term->name;
    $country_options[$region_name][$country_code] = $country_term->tid;
    $legal_drinking_age[$region_name][$country_code] = $country_term->field_legal_drinking_age[LANGUAGE_NONE][0]['value'];
    $country_ages[$country_code] = $wrapper->field_legal_drinking_age->value();
  }
  $region_vocabulary = taxonomy_vocabulary_machine_name_load('regions');
  $region_terms = taxonomy_get_tree($region_vocabulary->vid, 0, NULL, TRUE);
  $region_country = array();
  foreach ($region_terms as $terms) {
    if ($country_options[$terms->name]) {
      $region_country[$terms->name] = $country_options[$terms->name];
    }
  }
  $region_country['OTHER COUNTRIES'] = $country_options['OTHER COUNTRIES'];

  $form['#id'] = 'age-gate-wrapper';
  $default_language = language_default();
  if (isset($form_state['input']['country'])) {
    // A country was previously selected.
    $default_country = $form_state['input']['country'];
  }
  elseif (($curr_country_code = mumm_country_code_from_locale($language)) && $curr_country_code !== $default_language && array_key_exists($curr_country_code, $country_option_language)) {
    // The page is displayed in another page then the default language. Use that country.
    $default_country = $curr_country_code;
  }
  elseif (($ip_country_code = mumm_country_get_code_from_ip()) && array_key_exists($ip_country_code, $country_option_language)) {
    // A match of country by ip was found.
    $default_country = $ip_country_code;
  }
  else {
    // Default to the preferred country.
    $default_country = variable_get('v2_age_gate_preferred_country_code', 'uk');
  }

  $form['country'] = array(
    '#type' => 'select',
    '#options' => $region_country,
    '#default_value' => $default_country,
    '#attributes' => array(
      'data-custom-select' => "data-custom-select",
      'data-linking' => "#country",
      'data-tracking '=> '',
      'data-track-type'=> 'event',
      'data-track-category' => 'age_gate-version1',
      'data-track-action'=> 'switch-country',
      'data-track-label' => '',
      'data-track-value' => '',
      'data-track-non-interaction' =>'true',
      'data-dropdown-title' => trim(_hs_resource_get('select_country','plain', FALSE, FALSE, FALSE, 'Select your country')),
      'id' => "country",
      'class' => array("form-control")
    ),
  );

  $form['birthdate'] = array(
    '#type' => 'container',
    '#attributes' => array(
      'class' => array('group-input'),
      'data-hide-label' => 'data-hide-label',
      'data-name' => "#country",
      'data-tracking '=> '',
      'data-track-type'=> 'event',
      'data-track-category' => 'age_gate-version1',
      'data-track-action'=> 'error',
      'data-track-label' => '',
      'data-track-value' => '',
      'data-track-non-interaction' =>'true',
    ),
  );

  $form['birthdate']['day'] = array(
    '#type' => 'textfield',
    '#field_type' => 'text',
    '#default_value' => isset($form_state['input']['day']) ? $form_state['input']['day'] : NULL,
    '#maxlength' => 2,
    '#id' => 'date',
    '#prefix' => '<div class="input-element date"><label for="date">'.t('DD').'</label>',
    '#suffix' => '</div>',
    '#attributes' => array(
      'size' => 2,
      'class' => array('input-1'),
      'autocomplete' => "off",
      'data-tracking '=> '',
      'data-track-type'=> 'event',
      'data-track-category' => 'age_gate-version1',
      'data-track-action'=> 'fill_date',
      'data-track-label' => '',
      'data-track-value' => '',
      'data-track-non-interaction' =>'true'
    ),
  );

  $form['birthdate']['month'] = array(
    '#type' => 'textfield',
    '#field_type' => 'text',
    '#default_value' => isset($form_state['input']['month']) ? $form_state['input']['month'] : NULL,
    '#maxlength' => 2,
    '#prefix' => '<div class="input-element month"><label for="month">'.t('MM').'</label>',
    '#suffix' => '</div>',
    '#id' => 'month',
    '#attributes' => array(
      'size' => 2,
      'class' => array('input-1'),
      'autocomplete' => "off",
      'data-tracking '=> '',
      'data-track-type'=> 'event',
      'data-track-category' => 'age_gate-version1',
      'data-track-action'=> 'fill_month',
      'data-track-label' => '',
      'data-track-value' => '',
      'data-track-non-interaction' =>'true'
    ),
  );

  $form['birthdate']['year'] = array(
    '#type' => 'textfield',
    '#field_type' => 'text',
    '#required' => FALSE,
    '#id' => 'year',
    '#prefix' => '<div class="input-element year"><label for="year">'.t('YYYY').'</label>',
    '#suffix' => '</div>',
    '#default_value' => isset($form_state['values']['year']) ? $form_state['values']['year'] : NULL,
    '#maxlength' => 4,
    '#attributes' => array(
      'size' => 4,
      'class' => array('input-1'),
      'autocomplete' => "off",
      'data-tracking '=> '',
      'data-track-type'=> 'event',
      'data-track-category' => 'age_gate-version1',
      'data-track-action'=> 'fill_year',
      'data-track-label' => '',
      'data-track-value' => '',
      'data-track-non-interaction' =>'true'
    ),
  );

  $terms_conditions_nid = variable_get('v2_age_gate_terms_conditions_page', -1);
  $form['#terms_conditions_link'] = $terms_conditions_nid > 0 ? drupal_get_path_alias(sprintf('node/%d', $terms_conditions_nid)) : '#';

  $form['submit'] = array(
    '#type' => 'submit',
    '#prefix' => '<div class="form-group">',
    '#suffix' => '</div>',
    '#attributes' => array(
      'class' => array('btn', 'red-btn'),
    ),
    '#value' => _hs_resource_get('Enter','plain', FALSE, FALSE, FALSE, 'Enter'),
  );

  $form['#attributes'] = array(
    'class' => array('age-form'),
    'id' => 'age-form',
    'data-validator data-form-tracking' => '',
  );
  $form['country-hidden'] = array(
    '#type' => 'hidden',
  );
  return $form;
}

/**
 * Form validate.
 * @param type $form
 * @param type $form_state
 * @return type
 */
function v2_age_gate_form_validate(&$form, &$form_state) {
  $age_in_years = v2_age_gate_form_age($form, $form_state);
  if (FALSE === $age_in_years) {
    form_set_error('birthdate');
    return;
  }

  $minimum_age = v2_age_gate_form_minimum_age($form, $form_state);
  if ($minimum_age <= 0) {
    form_set_error('birthdate');
    return;
  }

  if ($age_in_years < $minimum_age) {
    form_set_error('birthdate');
    return;
  }
}

function v2_age_gate_form_submit($form, &$form_state) {

  global $language;

  // Get the language object for the selected country, or the default language if none exists.
  $country_code = $form_state['values']['country-hidden'];
  // Get language associated to taxonomy countries.
  $country_associated = get_language_associated($country_code);

  if ($country_associated) {
    $coutry_details = taxonomy_term_load($country_associated);
    $language_associated = $coutry_details->field_language_associated[LANGUAGE_NONE][0]['value'];
  }

  if ($language_associated) {
    $country_language = v2_menu_get_language_object($language_associated);
  }
  else {
    $country_language = _mumm_country_get_language_object($country_code, NULL, FALSE);
  }

  $form_state['#country_language'] = $country_language;

  // Generate birthdate string from form submission.
  $birthdate = _v2_age_gate_get_birthdate($form_state['values']);
  
  $cookie_expriration = strtotime(variable_get('mumm_age_gate_remember_cookie_expiration'));
  // Set the age gate cookie.
  $expire = isset($cookie_expriration) ? $cookie_expriration : 0;

  $country_languages = mumm_country_get_languages($country_language);

  foreach ($country_languages as $lang_code => $country_language_candidate) {
    // Set the age gate cookie for all country languages.
    // Unused cookie path language.
    // $cookie_path = _mumm_age_gate_get_cookie_path($country_language_candidate);
    $cookie_path = '/';
    v2_age_gate_set_cookie(V2_MUMM_AGE_GATE_COOKIE_NAME, TRUE, $expire, $cookie_path);

    // User age and country for all country languages.
    v2_age_gate_set_cookie(V2_MUMM_USER_AGE_COOKIE_NAME, $birthdate, $expire, $cookie_path);
    v2_age_gate_set_cookie(V2_MUMM_USER_COUNTRY_COOKIE_NAME, $country_code, $expire, $cookie_path);

// Set cookie language.
    if ($language_associated) {
      $language_associated = $language_associated;
    }
    else {
      $language_associated = $country_language_candidate->language;
    }
    v2_age_gate_set_cookie(V2_MUMM_USER_LANGUAGE_COOKIE_NAME, $language_associated, $expire, $cookie_path);
  }

  // Set the redirection path
  $path = '<front>';
  $url_options = array();

  // - check if the default frontpage destination is overridden
  if (isset($_GET['destination'])) {
    $path = drupal_get_normal_path($_GET['destination']);
    unset($_GET['destination']);
  }

  // - check if we have to change countries
  $changed_language = (mumm_country_code_from_locale($language) !== mumm_country_code_from_locale($country_language));
  if ($changed_language) {
    // Force change of language prefix on redirect.
    $url_options['language'] = $country_language;

    // Maybe there is a localized version of the current node path?
    $nid = mumm_helpers_get_nid_from_path($path);
    if (is_numeric($nid) && ($node = node_load($nid)) && ($translated_node = mumm_helpers_get_translated_node($node, $country_language->language))
    ) {
      $path = $translated_node->nid !== $node->nid ? sprintf('node/%d', $translated_node->nid)  // Seems like we have a translation.
          : '<front>';                                 // Content is not translated. Go to the frontpage.
    }
  }

  $form_state['redirect'] = array($path, $url_options);
  $form_state['#changed_language'] = TRUE;

  // Rebuild the form, adding some JS for the overlay to be closed.
  if (v2_age_gate_is_overlay()) {
    // Prevent HTTP redirection, and handle it with Javascript in the form on rebuild.
    $form_state['rebuild'] = TRUE;
    return;
  }


  // If you reach this point, Drupal will redirect you to $path.
}

function v2_age_gate_redirect() {
  global $language;

  $cookie_path = sprintf('/%s', $language->prefix);
  v2_age_gate_set_cookie(V2_MUMM_AGE_GATE_COOKIE_NAME, TRUE, 0, $cookie_path);

  drupal_goto();
}

function v2_mumm_page_age_gate() {
  return theme('v2_mumm_page_age_gate');
}

function v2_age_gate_manage($form, &$form_state) {
  $settings_language = mumm_helpers_get_settings_language();

  if (!$form_state['rebuild']) {
    mummm_helpers_set_language_warning_message($settings_language);
  }

  $settings_links = mumm_helpers_settings_language_switcher();
  $form = array();
  $form['settings_links'] = array(
    '#markup' => $settings_links
  );

  $form['age_gate_info'] = array(
    '#type' => 'fieldset',
    '#title' => t('General texts'),
    '#collapsible' => TRUE,
  );


  $form['age_gate_info']['logo_' . $settings_language] = array(
    '#type' => 'managed_file',
    '#title' => 'Logo',
    '#default_value' => v2_age_gate_variable_get('age_gate_logo_' . $settings_language),
    '#element_validate' => array('v2_age_gate_file_managed_file_validate'),
    '#upload_location' => 's3://',
  );

  $form['age_gate_info']['background_image_' . $settings_language] = array(
    '#type' => 'managed_file',
    '#title' => 'Background image',
    '#default_value' => variable_get('age_gate_background_image_' . $settings_language),
    '#element_validate' => array('v2_age_gate_file_managed_file_validate'),
    '#upload_location' => 's3://',
  );

  $form['age_gate_info']['background_mobile_' . $settings_language] = array(
    '#type' => 'managed_file',
    '#title' => 'Background image - mobile',
    '#default_value' => variable_get('age_gate_background_mobile_' . $settings_language),
    '#element_validate' => array('v2_age_gate_file_managed_file_validate'),
    '#upload_location' => 's3://',
  );

  $title_slug = v2_age_gate_variable_slug('title', $settings_language);
  $form['age_gate_info'][$title_slug] = array(
    '#type' => 'textfield',
    '#title' => 'Welcome message',
    '#size' => 120,
    '#maxlength' => 255,
    '#default_value' => v2_age_gate_variable_get('title', $settings_language),
  );

  $instructions_slug = v2_age_gate_variable_slug('instructions', $settings_language);
  $form['age_gate_info'][$instructions_slug] = array(
    '#type' => 'textfield',
    '#title' => 'Instructions',
    '#size' => 120,
    '#maxlength' => 255,
    '#default_value' => v2_age_gate_variable_get('instructions', $settings_language),
  );

  $conditions_slug = v2_age_gate_variable_slug('conditions', $settings_language);
  $conditions_data = v2_age_gate_variable_get('conditions', $settings_language);
  $form['age_gate_info'][$conditions_slug] = array(
    '#type' => 'text_format',
    '#title' => t('Legal Notice'),
    '#format' => $conditions_data['format'],
    '#default_value' => $conditions_data['value'],
  );

  $mention_health = v2_age_gate_variable_slug('mention_health', $settings_language);
  $form['age_gate_info'][$mention_health] = array(
    '#type' => 'textfield',
    '#title' => 'Responible Drinking legal mention',
    '#size' => 120,
    '#maxlength' => 255,
    '#default_value' => v2_age_gate_variable_get('mention_health', $settings_language),
  );

  $mention_cookies_slug = v2_age_gate_variable_slug('mention_cookies', $settings_language);
  $mention_cookies_data = v2_age_gate_variable_get('mention_cookies', $settings_language);
  $form['age_gate_info'][$mention_cookies_slug] = array(
    '#type' => 'text_format',
    '#title' => t('Mention Cookies'),
    '#format' => $mention_cookies_data['format'],
    '#default_value' => $mention_cookies_data['value'],
  );

  $form['age_gate_error_messages'] = array(
    '#type' => 'fieldset',
    '#title' => t('Error messages'),
    '#collapsible' => TRUE
  );

  $mandatory_fields_slug = v2_age_gate_variable_slug('error_mandatory_fields', $settings_language);
  $form['age_gate_error_messages'][$mandatory_fields_slug] = array(
    '#type' => 'textfield',
    '#title' => 'Mandatory fields',
    '#size' => 120,
    '#maxlength' => 255,
    '#default_value' => v2_age_gate_variable_get('error_mandatory_fields', $settings_language),
  );

  $underaged_slug = v2_age_gate_variable_slug('error_underaged', $settings_language);
  $form['age_gate_error_messages'][$underaged_slug] = array(
    '#type' => 'textfield',
    '#title' => 'Underaged',
    '#size' => 120,
    '#maxlength' => 255,
    '#default_value' => v2_age_gate_variable_get('error_underaged', $settings_language),
  );

  $no_legal_age_slug = v2_age_gate_variable_slug('error_no_legal_age', $settings_language);
  $form['age_gate_error_messages'][$no_legal_age_slug] = array(
    '#type' => 'textfield',
    '#title' => 'No legal age',
    '#size' => 120,
    '#maxlength' => 255,
    '#default_value' => v2_age_gate_variable_get('error_no_legal_age', $settings_language),
  );
  
  $form['mumm_age_gate_remember_cookie_expiration'] = array(
    '#type' => 'fieldset',
    '#title' => t('Remember cookie expiration'),
    '#collapsible' => TRUE
  );

  $form['mumm_age_gate_remember_cookie_expiration']['time'] = array(
    '#type' => 'textfield',
    '#title' => 'Remember cookie expiration',    
    '#description' => 'Example: 1 month',
    '#default_value' => variable_get('mumm_age_gate_remember_cookie_expiration')
  );

  $form['actions']['#type'] = 'actions';
  $form['actions']['submit'] = array('#type' => 'submit', '#value' => t('Save configuration'));

  if (!empty($_POST) && form_get_errors()) {
    drupal_set_message(t('The settings have not been saved because of the errors.'), 'error');
  }
  $form['#submit'][] = 'v2_age_gate_manage_submit';
  // By default, render the form using theme_system_settings_form().
  if (!isset($form['#theme'])) {
    $form['#theme'] = 'system_settings_form';
  }
  return $form;
}

/**
 * Form submission handler for v2_age_gate_manage().
 *
 * If you want node type configure style handling of your checkboxes,
 * add an array_filter value to your form.
 */
function v2_age_gate_manage_submit($form, &$form_state) {
  $settings_language = mumm_helpers_get_settings_language();
  variable_set('mention_health_' . $settings_language, $form_state['input']['values']['mention_health_' . $settings_language]);
  variable_set('age_gate_logo_' . $settings_language, $form_state['input']['logo_' . $settings_language]['fid']);
  variable_set('age_gate_background_image_' . $settings_language, $form_state['input']['background_image_' . $settings_language]['fid']);
  variable_set('age_gate_background_mobile_' . $settings_language, $form_state['input']['background_mobile_' . $settings_language]['fid']);

  $logo = file_load($form_state['input']['logo_' . $settings_language]['fid']);
  if ($logo) {
    $logo->status = FILE_STATUS_PERMANENT;
    file_save($logo);
  }

  $background_image = file_load($form_state['input']['background_image_' . $settings_language]['fid']);
  if ($background_image) {
    $background_image->status = FILE_STATUS_PERMANENT;
    file_save($background_image);
  }

  $background_mobile = file_load($form_state['input']['background_mobile_' . $settings_language]['fid']);
  if ($background_mobile) {
    $background_mobile->status = FILE_STATUS_PERMANENT;
    file_save($background_mobile);
  }

  // Exclude unnecessary elements.
  form_state_values_clean($form_state);

  foreach ($form_state['values'] as $key => $value) {
    if (is_array($value) && isset($form_state['values']['array_filter'])) {
      $value = array_keys(array_filter($value));
    }
    variable_set($key, $value);
  }
  
  variable_set('mumm_age_gate_remember_cookie_expiration', $form_state['values']['time']);

  drupal_set_message(t('The configuration options have been saved.'));
}

function v2_age_gate_is_overlay() {
  $params = drupal_get_query_parameters();
  return isset($params['overlay']) && $params['overlay'];
}

function v2_age_gate_form_minimum_age($form, $form_state) {
  if (!isset($form_state['values']['country'])) {
    return NULL;
  }

  $country_code = $form_state['values']['country'];

  $query = new EntityFieldQuery();
  $query->entityCondition('entity_type', 'taxonomy_term')
      ->fieldCondition('field_country_code', 'value', $country_code);

  $result = $query->execute();
  $country_term = isset($result['taxonomy_term']) ? reset($result['taxonomy_term']) : NULL;

  $legal_age = v2_age_gate_get_legal_drinking_age($country_term);
  return $legal_age;
}

function v2_age_gate_form_age($form, $form_state) {
  if (!isset($form_state['values']['year']) ||
      (!empty($form_state['values']['year']) && !is_numeric($form_state['values']['year'])) ||
      (!empty($form_state['values']['month']) && !is_numeric($form_state['values']['month'])) ||
      (!empty($form_state['values']['day']) && !is_numeric($form_state['values']['day']))) {
    return FALSE;
  }

  $year = $form_state['values']['year'];

  if (is_numeric($form_state['values']['month'])) {
    $month = isset($form_state['values']['month']) && !empty($form_state['values']['month']) ? $form_state['values']['month'] : NULL;
  }

  if (is_numeric($form_state['values']['day'])) {
    $day = isset($form_state['values']['day']) && !empty($form_state['values']['day']) ? $form_state['values']['day'] : NULL;
  }

  $age = v2_age_gate_calculate_age($year, $month, $day);
  return $age;
}

function _v2_age_gate_get_birthdate($values) {
  $birthdate = $values['year'];

  if (isset($values['month']) && !empty($values['month'])) {
    $birthdate .= '-' . $values['month'];
  }
  else {
    return $birthdate;
  }

  if (isset($values['day']) && !empty($values['day'])) {
    $birthdate .= '-' . $values['day'];
    return $birthdate;
  }
  else {
    return $birthdate;
  }
}

function v2_age_gate_browser() {
  return '';
}

/**
 * Implement function v2_age_gate_file_managed_file_validate
 * @param type $element
 * @param type $form_state
 */
function v2_age_gate_file_managed_file_validate(&$element, &$form_state) {
  $clicked_button = end($form_state['triggering_element']['#parents']);
  if ($clicked_button != 'remove_button' && !empty($element['fid']['#value'])) {
    if ($file = file_load($element['fid']['#value'])) {

    }
    else {
      form_error($element, check_plain('The file referenced by the !name field does not exist.'), array('!name' => $element['#title']));
    }
  }

  // Check required property based on the FID.
  if ($element['#required'] && empty($element['fid']['#value']) && !in_array($clicked_button, array('upload_button', 'remove_button'))) {
    form_error($element['upload'], check_plain('!name field is required.'), array('!name' => $element['#title']));
  }

  // Consolidate the array value of this field to a single FID.
  if (!$element['#extended']) {
    form_set_value($element, $element['fid']['#value'], $form_state);
  }
}

/**
 * Implement function get language associated taxonymo Countries/.
 * @param type $country_code
 * @return type
 */
function get_language_associated($country_code) {
  $query = new EntityFieldQuery();
  $query->entityCondition('entity_type', 'taxonomy_term')
      ->fieldCondition('field_country_code', 'value', $country_code);

  $result = $query->execute();
  if ($result) {
    $term_id = isset($result['taxonomy_term']) ? reset($result['taxonomy_term']) : NULL;
  }

  return $term_id->tid;
}

/**
 * Implements hook_settings_form().
 */
function v2_manage_acount_tagging($form, &$form_state){
  $form['vars_tab'] = array(
    '#type' => 'vertical_tabs',
  );
  $form['tagging'] = array(
    '#type' => 'fieldset',
    '#title' => t('Configure tracking'),
    '#group' => 'vars_tab',
  );

  $form['tagging']['config_tagging_acount'] = array(
    '#type' => 'textfield',
    '#title' => t('Google Analytics Account ID'),
    '#description' => t('GA account example: UA-XXXXXXX-X'),
    '#default_value' => variable_get('config_tagging_acount'),
    '#required' => TRUE,
  );

  return system_settings_form($form);
}
