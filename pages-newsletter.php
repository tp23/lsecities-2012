<?php
/**
 * Template Name: Newsletter
 * Description: The template used for Newsletters
 * 
 * @package LSECities2012
 */
$TRACE_ENABLED = is_user_logged_in();

/**
 * Replace https with http, if source for email campaign is accessed via an https link
 */
$our_permalink = preg_replace('/^https/', 'http', get_permalink($id));
/**
 * And remove any GET parameters such as channel=email
 */
$our_permalink = preg_replace('/\?.*$/', '', $our_permalink);

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

/**
 * Initialize empty array for newsletter sections
 */
$newsletter_sections = array();

/**
 * Set up the objects needed
 */
$sections = get_pages(array(
  'parent' => $post->ID,
  'post_type' => 'page',
  'sort_column'  => 'menu_order',
  'hierarchical' => 0
));

foreach($sections as $key => $section) {
  /**
   * If the news_category custom field is set, treat this section
   * as a news list section, which will be populated with the
   * news items belonging to the category set here.
   */
  $news_category = get_post_meta($section->ID, 'news_category', true);

  if($news_category) {
    /**
     * Look up related news, to be used as section items
     */
    $item_objects = get_posts(array(
      'category_name' => $news_category,
      'post_type' => 'post',
      'nopaging'  => true,
      'posts_per_page' => -1
    ));
    var_trace(var_export($item_objects, true), 'news items in category ' . $news_category);
  } else {
    /**
     * Look up children pages, to be used as section items
     */
    $item_objects = get_pages(array(
      'parent' => $section->ID,
      'post_type' => 'page',
      'sort_column'  => 'menu_order',
      'hierarchical' => 0
    ));
  }
  
  /**
   * All the featured items for this category
   */
  $featured_items = array();
  
  /**
   * All the items (featured or not) for this category
   */
  $items = array();
  
  /**
   * Add all the children pages to the list of items
   */
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
    
    /**
     * Add the current items to the items list for this section
     */
    $items[] = $item;
    
    /**
     * If a toc_title has been set, this is a featured item: add it to
     * the featured items list for this section with the title
     * to use in the table of contents
     */
    if($item_toc_title) {
      $item['toc_title'] = $item_toc_title;
      $featured_items[] = $item;
    }
  }

  $newsletter_section = array(
    'ID' => $section->ID,
    'title' => $section->post_title,
    'thumbnail' => get_the_post_thumbnail($section->ID, $POST_THUMBNAIL_SIZE),
    'featured_items' => $featured_items,
    'items' => $items,
    'is_news_section' => $news_category ? true : false
  );
  
  /** 
   * Do not even bother including any content from the post object's
   * content field in the data structure unless this is the fifth (or
   * successive) section, in which case editors are supposed to
   * actually be using the section page's content box rather than
   * subpages for content.
   * This avoids lazy shortcuts which miss completely the point
   * of having structured data in a CMS :)
   */
  if($key > 3) {
    $newsletter_section['content'] = $section->post_content;
  }
  
  /**
   * Set flag to enable displaying first four section in table of
   * contents; this field is only used in the web channel template
   * as the email channel template uses its own logic to display the
   * first five sections as we want to display an image credits section
   * there as well, if in use.
   */
  if($key < 4) {
    $newsletter_section['show_in_toc'] = true;
  }
  
  /**
   * Add just-processed section to list of sections
   */
  $newsletter_sections[] = $newsletter_section;
}

$newsletter = array(
  'title' => get_the_title(),
  'permalink' => get_permalink($post->ID),
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
