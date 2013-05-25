<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Theme configuration variables
 * 
 * Please avoid scattering configuration data across local or global
 * variables in PHP files - use the One True Global Variable below
 * through the getter/setter function lc_data.
 * Please avoid global variables altogether when possible, and surely
 * avoid more than one global variable (use the One True Global Variable
 * for any globals needed).
 * 
 * This setup is an improved version of the 'Working with the variable'
 * example here: http://betterwp.net/8-using-global-variables-in-wordpress/
 */

/**
 * The One True Global Variable
 * 
 * Please don't access this directly - use the getter/setter function
 * lc_data() instead.
 */
$LSECITIES_CONFIGURATION_DATA = array();

/**
 * get or set items from global configuration variable
 * 
 * 
 * If called with the $key parameter only works as getter,
 * if called with both $key and $value parameters works as setter
 * 
 * @param string $key The item's key
 * @param mixed $value The item's new value
 * @return mixed The value of the item requested (getter) or updated/set
 *         (setter)
 */
function lc_data($key, $value = false) {
  global $LSECITIES_CONFIGURATION_DATA;
  if($value !== false) {
    $LSECITIES_CONFIGURATION_DATA[$key] = $value;
  }
  return $LSECITIES_CONFIGURATION_DATA[$key];
}

/**
 * add configuration constants here
 */
 
/**
 * Filename for the template used for conference frontpage WP Pages.
 * This is used in id_of_parent_conference(). If the name of the
 * template file is changed, update the following constant.
 * We throw a warning in any case if a file with this name is not found
 * at this stage, but someone will have to notice that warning :)
 */
lc_data('pods_conference__wp_page_template', 'pods-conference-frontpage.php');
if('' === locate_template(array(lc_data('pods_conference__wp_page_template')))) {
  trigger_error('pods_conference__wp_page_template set to ' . lc_data('pods_conference__wp_page_template') . ' but no such template file exists in theme. Please set pods_conference__wp_page_template to new name of Conference page template', E_USER_WARNING);
}

/**
 * meta description
 */
lc_data('meta_description', 'LSE Cities is an international centre at the London School of Economics and Political Science that studies how people and cities interact in a rapidly urbanising world, focussing on how the design of cities impacts on society, culture and the environment. Through research, conferences, teaching and projects, the centre aims to shape new thinking and practice on how to make cities fairer and more sustainable for the next generation of urban dwellers, who will make up some 70 per cent of the global population by 2050.');
/**
 * (protocol-relative) base URI of theme and absolute filesystem path
 */
lc_data('theme_base_path', '//' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/lsecities-2012');
lc_data('theme_filesystem_abspath', ABSPATH . '/wp-content/themes/lsecities-2012');
