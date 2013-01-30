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
  if($value) {
    $LSECITIES_CONFIGURATION_DATA[$key] = $value;
  }
  return $LSECITIES_CONFIGURATION_DATA[$key];
}
