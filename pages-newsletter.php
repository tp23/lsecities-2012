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

?>
<?php
// Set up the objects needed
$sections = get_pages(array(
  'parent' => $post->ID,
  'post_type' => 'page',
  'sort_column'  => 'menu_order',
  'hierarchical' => 0
));
$section_featured_items = array();

foreach($sections as $section) {
  $section_featured_items[] = get_pages(array(
    'parent' => $section->ID,
    'post_type' => 'page',
    'sort_column'  => 'menu_order',
    'meta_key' => 'toc_title',
    'hierarchical' => 0
  ));
}

// create array containing section info and section's featured items for each section
$newsletter_sections = array_map(null, $sections, $section_featured_items);

?>
<?php
define('WP_USE_THEMES', false);
set_query_var('newsletter_sections', $newsletter_sections);
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
