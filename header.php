<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package LSECities2012
 */
?><?php

if($_GET["siteid"] == 'ec2012') {
  if(is_user_logged_in()) {
    get_header('ec2012');
  } else {
    wp_redirect(home_url());
    exit;
  }
} else {
  get_header('default');
}
?>
