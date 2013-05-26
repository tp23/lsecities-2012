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
 * @param string $class The class string to add (can be multiple space-separated classes if needed, no leading or trailing spaces)
 * @param int $current_item_index The index of the current item
 * @param int $items_per_row How many items fit in a row
 * @return string The requested class string if this is the last item in a row
 */
function class_if_last_item($class, $current_item_index, $items_per_row) {
  if($current_item_index % $items_per_row == 0) {
    return $class;
  }
}

/**
 * Hide lsecities.net page hierarchy in links if we are in labs subsite
 * This is of course a bit simplistic as there might be links that need
 * to be kept as they are, but for the current use cases this works fine.
 * 
 * @param string $string_blob The chunk of text on which to run the regexp
 * @return string The input text with links stripped
 */
function hide_lsecities_page_hierarchy_in_labs_links($string_blob) {
  return preg_replace('/https?:\/\/lsecities\.net\/labs/', '', $string_blob);
}

/**
 * Wrapper around PHP's stock include(), making sure every path is
 * always relative to the theme's root.
 */
function lc_include($file) {
  var_trace(lc_data('theme_filesystem_abspath') . '/' . $file, 'LC_INCLUDE');
  include lc_data('theme_filesystem_abspath') . '/' . $file;
}
