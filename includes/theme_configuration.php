<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

// main global array
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
