<?php
/**
 * Template Name: Newsletter
 * Description: The template used for Newsletters
 * 
 * @package LSECities2012
 */
$TRACE_ENABLED = is_user_logged_in();

$our_permalink = preg_replace('/^https/', 'http', get_permalink($id));
$POST_THUMBNAIL_SIZE = array(600,294);

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

$newsletter_sections = array();

// Set up the objects needed
$sections = get_pages(array(
  'parent' => $post->ID,
  'post_type' => 'page',
  'sort_column'  => 'menu_order',
  'hierarchical' => 0
));

foreach($sections as $section) {
  $item_objects = get_pages(array(
    'parent' => $section->ID,
    'post_type' => 'page',
    'sort_column'  => 'menu_order',
    'hierarchical' => 0
  ));
  
  $featured_items = array();
  $items = array();
  
  foreach($item_objects as $item_object) {
    $item_toc_title = get_post_meta($item_object->ID, 'toc_title', true);
    $item =
     array(
      'ID' => $item_object->ID,
      'title' => $item_object->post_title,
      'content' => $item_object->post_content,
      'thumbnail' => get_the_post_thumbnail($item_object->ID, $POST_THUMBNAIL_SIZE),
      'layout' => strtolower(get_post_meta($item_object->ID, 'layout', true))
    );
    
    // add the current items to the items list for this section
    $items[] = $item;
    
    // if a toc_title has been set, this is a featured item: add it to the
    // featured items list for this section
    if($item_toc_title) {
      $item['toc_title'] = $item_toc_title;
      $featured_items[] = $item;
    }
  }

  $newsletter_sections[] = array(
    'ID' => $section->ID,
    'title' => $section->post_title,
    'thumbnail' => get_the_post_thumbnail($section->ID, $POST_THUMBNAIL_SIZE),
    'featured_items' => $featured_items,
    'items' => $items
  );
}

$newsletter = array(
  'title' => get_the_title(),
  'teaser' => get_post_meta(get_the_ID(), "campaign_teaser_text", true),
  'heading_link' => get_post_meta(get_the_ID(), "campaign_heading_link", true),
  'heading_thumbnail' => get_the_post_thumbnail(),
  'sections' => $newsletter_sections
);

?>
<?php
var_trace(var_export($newsletter, true));
define('WP_USE_THEMES', false);
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
