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
  include(__FILE__ . '/header-ec2012.php');
} else {
  include(__FILE__ . '/header-default.php');
}
?>
