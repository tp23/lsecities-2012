<?php
/**
 * Template Name: Newsletter
 * Description: The template used for Newsletters
 * 
 * @package LSECities2012
 */
$TRACE_ENABLED = is_user_logged_in();

$our_permalink = preg_replace('/^https/', 'http', get_permalink($id));

// read post meta newsletter_title_meta and check if we should hide title or add extra classes
$newsletter_title_meta = strtolower(get_post_meta(get_the_ID(), 'newsletter_title_meta', true));

switch($newsletter_title_meta) {
  case 'hidden':
    $hide_newsletter_title = true;
    break;
  case 'class-detached':
    $newsletter_title_extra_classes = 'detached';
    break;
}

// read post meta theme_skin to check if we need to apply custom styles
$theme_skin = strtolower(get_post_meta(get_the_ID(), 'theme_skin', true));

if($TRACE_ENABLED) {
  error_log('post_permalink: ' . get_permalink($id));
  error_log('our_permalink: ' . $our_permalink);
}

?><?php
define('WP_USE_THEMES', false);
locate_template('templates/newsletter/newsletter-email.php', true, true);
?>
