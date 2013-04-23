<?php
/**
 * Template for LSE Cities newsletters (email channel)
 * 
 *
 * @package LSECities2012
 */
?><?php
// Set up the objects needed
$my_query = new WP_Query();
$all_sections_query = $my_query->query(array('post_type' => 'page', 'orderby' => 'menu_order'));

// Filter through all pages and find Portfolio's children
$sections = get_page_children( $post->ID, $all_sections_query );

var_trace(var_export($sections));

foreach($sections as $section) {
  $featured_items_query = $my_query->query(array('post_type' => 'page', 'meta_key' => 'toc_title', 'orderby' => 'menu_order'));
  $featured_items = get_page_children($section->ID, $featured_items_query);
  var_trace(var_export($featured_items));
  include('header-section-email.php');
}
?>
