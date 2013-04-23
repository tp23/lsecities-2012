<?php
/**
 * Template for LSE Cities newsletters (email channel)
 * 
 *
 * @package LSECities2012
 */
?><?php
// Set up the objects needed
$all_sections_query = new WP_Query(array('post_type' => 'page', 'orderby' => 'menu_order'));

var_trace(var_export($post->ID, true));
var_trace(var_export($all_sections_query, true));
// Find sections
$sections = get_page_children( $post->ID, $all_sections_query );

var_trace(var_export($sections, true));

foreach($sections as $section) {
  $featured_items_query = new WP_Query(array('post_type' => 'page', 'meta_key' => 'toc_title', 'orderby' => 'menu_order'));
  $featured_items = get_page_children($section->ID, $featured_items_query);
  var_trace(var_export($featured_items, true));
  include('header-section-email.php');
}
?>
