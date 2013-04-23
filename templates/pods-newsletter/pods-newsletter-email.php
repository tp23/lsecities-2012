<?php
/**
 * Template for LSE Cities newsletters (email channel)
 * 
 *
 * @package LSECities2012
 */
?><?php
// Set up the objects needed
//$sections = new WP_Query(array('post_type' => 'page', 'orderby' => 'menu_order', 'post_parent'=>$post->ID));
$sections = wp_list_pages(array(
  'echo' => false,
  'child_of' => $post->ID,
  'sort_column'  => 'menu_order'
));

var_trace(var_export($post->ID, true));
var_trace(var_export($sections, true));

foreach($sections as $section) {
  $featured_items = new WP_Query(array('post_type' => 'page', 'meta_key' => 'toc_title', 'orderby' => 'menu_order', 'post_parent' => $section->ID));
  var_trace(var_export($featured_items, true));
  include('header-section-email.php');
}
?>
