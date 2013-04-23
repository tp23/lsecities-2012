<?php
/**
 * Template Name: Pods - Full newsletter
 * Description: The template used for LSE Cities newsletters
 *
 * @package LSECities2012
 */
?><?php
/**
 * Dispatch to template based on whether the HTTP GET parameter
 * 'channel' is set to 'email' or not
 */
if($_GET['channel'] === 'email') {
  locate_template('templates/pods-newsletter/pods-newsletter-email.php', true, true);
} else {
  locate_template('templates/pods-newsletter/pods-newsletter-web.php', true, true);
}

