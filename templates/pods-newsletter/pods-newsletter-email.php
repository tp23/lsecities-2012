<?php
/**
 * Template for LSE Cities newsletters (email channel)
 * 
 *
 * @package LSECities2012
 */
?><?php
// Set up the objects needed
$my_wp_query = new WP_Query();
$all_wp_pages = $my_wp_query->query(array('post_type' => 'page'));

// Filter through all pages and find Portfolio's children
$sections = get_page_children( $post->ID, $all_wp_pages );

// echo what we get back from WP to the browser
echo '<pre>' . print_r( $sections, true ) . '</pre>';
?>
