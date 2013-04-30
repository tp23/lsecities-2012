<?php
/**
 * Template Name: Full newsletter
 * Description: The template used for quarterly newsletters
 *
 * @package LSECities2012
 */
?><?php
/**
 * Dispatch to template based on whether the HTTP GET parameter
 * 'channel' is set to 'email' or not
 */
if($_GET['channel'] === 'email') {
  locate_template('templates/newsletter/newsletter-email.php', true, true);
} else {
  locate_template('templates/newsletter/newsletter-web.php', true, true);
}

