<?php
/**
 * @file
 * mumm_doormat.features.menu_custom.inc
 */

/**
 * Implements hook_menu_default_menu_custom().
 */
function mumm_doormat_menu_default_menu_custom() {
  $menus = array();

  // Exported menu: menu-doormat.
  $menus['menu-doormat'] = array(
    'menu_name' => 'menu-doormat',
    'title' => 'Doormat',
    'description' => 'Menu placed on the bottom of the page.',
    'language' => 'und',
    'i18n_mode' => 5,
  );
  // Translatables
  // Included for use with string extractors like potx.
  t('Doormat');
  t('Menu placed on the bottom of the page.');


  return $menus;
}
