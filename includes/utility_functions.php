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
  function return_404() {
    status_header(404);
    nocache_headers();
    include( get_404_template() );
    exit;
  }
} 
