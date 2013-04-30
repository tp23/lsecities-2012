<?php
/**
 * Various utility functions used across the theme
 */

/**
 * Show WordPress' 404 page
 * (credits: https://wordpress.org/support/topic/display-wordpress-404-from-my-script#post-1180851)
 *
 */
if(!defined('redirect_to_404')) {
  function redirect_to_404() {
    status_header(404);
    nocache_headers();
    include(get_404_template());
    exit;
  }
} 

/**
 * output requested class if this is the last item in a N-items row
 *
 * @param
 */
function class_if_last_item($class, $items_per_row, $current_item_index) {
  if($current_item_index % $items_per_row != 0) {
    return $class;
  }
}
