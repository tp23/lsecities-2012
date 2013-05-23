<?php
/**
 * Template Name: Newsletter
 * Description: The template used for Newsletters
 * 
 * @package LSECities2012
 */
$TRACE_ENABLED = is_user_logged_in();
define('WP_USE_THEMES', false);

/**
 * Initialize data
 */
$newsletter = pages_prepare_newsletter($post->ID);

var_trace(var_export($newsletter, true));

set_query_var('newsletter', $newsletter);

/**
 * Dispatch to template based on whether the HTTP GET parameter
 * 'channel' is set to 'email' or not
 * Also dispatch to email template if no 'email' channel is specified but
 * page is not a quarterly newsletter (i.e. it doesn't have subsections)
 */
if($_GET['channel'] === 'email' or (is_array($sections) and count($sections) == 0)) {
  locate_template('templates/newsletter/newsletter-email.php', true, true);
} else {
  locate_template('templates/newsletter/newsletter-web.php', true, true);
}
?>
