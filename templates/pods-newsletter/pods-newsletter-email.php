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
$sections = get_pages(array(
  'parent' => $post->ID,
  'post_type' => 'page',
  'sort_column'  => 'menu_order',
  'hierarchical' => 0
));

var_trace(var_export($post->ID, true));
var_trace(var_export($sections, true));

foreach($sections as $section) {
  $featured_items = get_pages(array(
    'parent' => $section->ID,
    'post_type' => 'page',
    'sort_column'  => 'menu_order',
    'meta_key' => 'toc_title',
    'hierarchical' => 0
  ));
  var_trace(var_export($featured_items, true));
  include('header-section-email.php');
}
?>
