<?php
/**
 * Functions for the LSE Cities 2012 WordPress+Pods theme
 * 
 * @package LSECities2012
 */

/* LSE Cities Twenty Twelve functions and constant definitions */
define('PODS_BASEURI_ARTICLES', '/media/objects/articles');
define('PODS_BASEURI_CONFERENCES', '/media/objects/conferences');
define('PODS_BASEURI_EVENTS', '/media/objects/events');
define('PODS_BASEURI_RESEARCH_PROJECTS', '/objects/research-projects');
define('TRACE_ENABLED', is_user_logged_in());
define('TRACE_PREFIX', __FILE__);

// log php errors
define('LSECITIES2012_LOG_FILE', '/srv/web/wordpress/www/tmp/lsecities-2012.log');

if(is_user_logged_in()) {
  @ini_set('log_errors', 'On'); // enable or disable php error logging (use 'On' or 'Off')
  @ini_set('display_errors', 'Off'); // enable or disable public display of errors (use 'On' or 'Off')
  @ini_set('error_log', LSECITIES2012_LOG_FILE); // path to server-writable log file
}

/**
 * tracing/debugging output
 * 
 * This function can either return a formatted dump of the variable to
 * debug, or send the dump to the defined error_log. Ideally this
 * should be coupled with PHP INI settings to enable error log, to
 * disable error output on pages and to send logs to a specific
 * file instead
 * 
 * @param mixed $var The variable to dump
 * @param string $prefix Text to prepend to the variable to be dumped
 * @param bool $enabled Only if true will the function do anything
 * @param string $destination Whether to return a string ('page') or to
 *        send output to error_log ('error_log')
 * @return bool the tracing output if $destination == 'page' or the
 *         return value of error_log() if $destination == 'error_log'
 */
function var_trace($var, $prefix = 'pods', $enabled = TRACE_ENABLED, $destination = 'error_log') {
  if($enabled) {
    $output_string = "tracing $prefix : " . var_export($var, true) . "\n\n";
    
    if($destination == 'page') {
      return "<!-- $output_string -->";
    } elseif($destination == 'error_log') {
      return error_log($output_string);
    }
  }
}
// global scope variables
$META_media_attr = array();

// define assets to load
$json_assets =
'[{
  "jquery.cookiecuttr": {
    "load": [ "logged-in": true, "not-logged-in": false, "admin-area": false ]
  }
}]';
include_once('inc/asset_pipeline.php');
$asset_pipeline = new LC\AssetPipeline(json_decode($json_assets));

/* deal with WP's insane URI (mis)management - example from
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/wp_get_attachment_url */
add_filter('wp_get_attachment_url', 'honor_ssl_for_attachments');
add_filter('the_content', 'honor_ssl_for_attachments' );
function honor_ssl_for_attachments($url) {
	$http = site_url(FALSE, 'http');
	$https = site_url(FALSE, 'https');
	if($_SERVER['HTTPS'] == 'on') {
    return str_ireplace($http, $https, $url);
  }
  else {
    return str_ireplace($https, $http, $url);
  }
}

add_filter('lc_do_shortcode', 'honor_ssl_for_attachments');

function do_https_shortcode($content) {
  $content = apply_filters('lc_do_shortcode', do_shortcode($content));
  return $content;
}



function check_parent_conference($post_id) {
  global $post;
  $current_post_id = $post->ID;
  var_trace('current_post_id: ' . $current_post_id, TRACE_PREFIX, TRACE_ENABLED);
  if($current_post_id == $post_id or in_array($post_id, get_post_ancestors($current_post_id))) {
    return true;
  } else {
    return false;
  }
}

/*  Returns the first $wordsreturned out of $string.  If string
contains fewer words than $wordsreturned, the entire string
is returned.
*/

function shorten_string($string, $wordsreturned) {
  $retval = $string;      //  Just in case of a problem
  $array = explode(" ", $string);
  if (count($array)<=$wordsreturned) { // Already short enough, return the whole thing
    $retval = $string;
  } else { //  Need to chop some words
    array_splice($array, $wordsreturned);
    $retval = implode(" ", $array);
  }
  return $retval;
}

/* 
 * Set wp_title according to current Pod content
 */
include_once('inc/pods/class.podobject.inc.php');
function set_pod_page_title($title, $sep, $seplocation) {
  global $this_pod;
  var_trace($this_pod, 'this_pod', is_user_logged_in());
  if(isset($this_pod) and $this_pod->page_title){
    $title = $this_pod->page_title;
    
    if($this_pod->page_section){
      $title .= " $sep " . $this_pod->page_section;
    }
    
    $title .= " $sep ";
    
    var_trace($title, 'page_title', is_user_logged_in());
  }
  
  return $title;
}
add_filter('wp_title', 'set_pod_page_title', 5, 3);

// from http://webcheatsheet.com/php/get_current_page_url.php
function get_current_page_URI() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

/* attribution and license metadata support for media library
 * thanks to jvelez (http://stackoverflow.com/questions/11475741/word-press-saving-custom-field-to-database)
 * 
 * To learn more: 
 * http://net.tutsplus.com/tutorials/wordpress/creating-custom-fields-for-attachments-in-wordpress/
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/attachment_fields_to_save
 * 
 * Weird Wordpress convention : Fields prefixed with an underscore 
 * (_RevisionDate) will not be listed in the drop down of available custom fields on the post/page screen;
 * We only need the custom fields in the media library page
 */
function get_media_library_item_custom_form_fields($form_fields, $post) {
  $form_fields['attribution_name'] = array(
    'label' => 'Author',
    'input' => 'text',
    'value' => get_post_meta($post->ID, '_attribution_name', true),
    'helps' => 'Media author (or rights holder)'
  );
  
  $form_fields['attribution_uri'] = array(
    'label' => 'URI of original work',
    'input' => 'text',
    'value' => get_post_meta($post->ID, '_attribution_uri', true),
    'helps' => 'Link to original work for attribution purposes'
  );
  
  return $form_fields;
}

add_filter('attachment_fields_to_edit', "get_media_library_item_custom_form_fields", null, 2);  

function save_media_library_item_custom_form_fields($post, $attachment) {
  if(isset($attachment['attribution_name'])) {
    update_post_meta($post['ID'], '_attribution_name', $attachment['attribution_name']);  
  }
  if(isset($attachment['attribution_uri'])) {
    update_post_meta($post['ID'], '_attribution_uri', $attachment['attribution_uri']);  
  }
  
  return $post;
}

add_filter('attachment_fields_to_save','save_media_library_item_custom_form_fields', 8, 2);

function push_media_attribution($attachment_ID) {
  global $META_media_attr;
  $attachment_metadata = wp_get_attachment_metadata($attachment_ID);
  var_trace($attachment_metadata, $TRACE_PREFIX . ': attachment_metadata', $TRACE_ENABLED);
  $attribution_uri = get_post_meta($attachment_ID, '_attribution_uri', true);
  $attribution_name = get_post_meta($attachment_ID, '_attribution_name', true);
  // array_push($GLOBALS['META_media_attributions'], array(
  array_push($META_media_attr, array(
    'title' => get_the_title($attachment_ID),
    'attribution_uri' => $attribution_uri,
    'author' => $attribution_name,
  ));
}

function galleria_prepare($pod, $extra_classes='', $gallery_field='gallery') {
  define(GALLERY_MAX_SLIDES_COUNT, 12);
  
  $gallery = array(
    'slug' => $pod->get_field($gallery_field . '.slug'),
    'extra_classes' => $extra_classes,
    'slides' => array()
  );

  // if picasa_gallery_id is set, add this to the object
  if($pod->get_field($gallery_field . '.picasa_gallery_id')) {
    $gallery['picasa_gallery_id'] = $pod->get_field($gallery_field . '.picasa_gallery_id');
  }
  // otherwise build the slides list
  else {
    for($i = 1; $i < (GALLERY_MAX_SLIDES_COUNT + 1); $i++) {
      $slide_id = $pod->get_field($gallery_field . '.' . sprintf('slide%02d', $i) . '.ID');
      var_trace($slide_id);
      if($slide_id) {
        array_push($gallery['slides'], array_shift(get_posts(array('post_type'=>'attachment', 'numberposts'=>1, 'p' => $slide_id))));
      }
    }
  }
  var_trace($gallery, 'gallery');
  
  return $gallery;
}

function galleria_prepare_multi($pod, $extra_classes, $gallery_field='galleries') {
  define(GALLERY_MAX_SLIDES_COUNT, 12);
  $gallery_array = array();
  
  foreach($pod->get_field($gallery_field) as $key => $gallery) {
    
    $gallery_object = array(
      'slug' => $gallery['slug'],
      'extra_classes' => $extra_classes,
      'slides' => array()
    );
  
    // if picasa_gallery_id is set, add this to the object
    if($gallery['picasa_gallery_id']) {
      $gallery_object['picasa_gallery_id'] = $gallery['picasa_gallery_id'];
      var_trace($gallery_object, 'gallery_object__picasaweb');
      array_push($gallery_array, $gallery_object);
    }
    // otherwise build the slides list
    else {
      for($i = 1; $i < (GALLERY_MAX_SLIDES_COUNT + 1); $i++) {
        $slide_id = $gallery[sprintf('slide%02d', $i) . '.ID'];
        var_trace($slide_id);
        if($slide_id) {
          array_push($gallery_object['slides'], array_shift(get_posts(array('post_type'=>'attachment', 'numberposts'=>1, 'p' => $slide_id))));
        }
      }
      var_trace($gallery_object, 'gallery_object__slides');
      array_push($gallery_array, $gallery_object);
    }
    var_trace($gallery_array, 'gallery_array');
  }
  return $gallery_array;
}

function news_categories($pod_news_categories) {
  var_trace(var_export($pod_news_categories, true), 'news_category_ids');
  if($pod_news_categories) {
    $news_categories = '';
    foreach($pod_news_categories as $category) {
      $news_categories .= $category['term_id'] . ',';
    }
    $news_categories = '&cat='. rtrim($news_categories, ',');
    var_trace($news_categories, 'news_categories');
  }
  return $news_categories;
}

/* components */
define(COMPONENTS_ROOT, 'inc/components');

/**
 * News component
 * 
 * This function outputs a News section or a combined
 * News/Events/Highlights section as used on Slider frontpages and
 * Research project pages.
 * 
 * If only one or more news categories are provided, the template
 * used will be News only (three news items with title and blurb, up to
 * ten further news items with title only). If news/highlights are
 * passed in, the layout used will be combined News/Highlights.
 * 
 * @param array $news_categories_slugs The list of categories slugs
 * @param string $news_prefix Any text to be displayed in the News heading
 * @param array $linked_events An array of Events pods
 * @return string The generated HTML code
 */
function component_news($news_categories_slugs, $news_prefix = '', $linked_events = '') {
  $output = '';
  var_trace(var_export($news_categories_slugs, true), 'news_categories_slugs');
  if(!is_array($news_categories_slugs)) return $output;
  
  if(count($news_categories_slugs) > 0) {
    $news_categories = news_categories($news_categories_slugs);
  }

  var_trace(var_export($news_categories, true), 'news_categories');
  var_trace(count($news_categories_slug), 'count($news_categories_slugs)');
  var_trace($linked_events, 'linked_events');
  
  if(count($news_categories_slugs) > 0 and is_array($linked_events) and count($linked_events) >0) {
    $template = COMPONENTS_ROOT . '/news+highlights.inc.php';
  } elseif(count($news_categories_slugs) > 0) {
    $template = COMPONENTS_ROOT . '/news.inc.php';
  }
  if($template) {
    ob_start();
    include $template;
    $output = ob_end_flush();
  }
  return $output;
}
