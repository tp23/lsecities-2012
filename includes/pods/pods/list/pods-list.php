<?php
namespace LSECitiesWPTheme\pods_list;

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * @param array $pod_slugs list of slugs of pod list objects
 */
function pods_prepare_list($pod_slugs) {
  
  // Initialize arrays
  $obj = array();
  $lists = array();
  
  // For each list pod, add the list of its items to the main $list array
  foreach($pod_slugs as $slug) {
    // This is the list pod
    $this_pod = new \Pod('list', $slug);
    // Set sort order for the items included in this list
    $sort_order = $this_pod->get_field('sort_descending') ? 'DESC' : 'ASC';
    
    // If the list_research_output_category field is set, we get all the
    // research_output pods tagged with the given category, sorted by
    // date (DESC or ASC according to the sort_descending flag
    if($this_pod->get_field('list_research_output_category')) {
      $items_pod = new \Pod('research_output', array(
        'where' => 'category.slug = "' . $this_pod->get_field('list_research_output_category.slug' ) . '"',
        'sort' => 'date ' . $sort_order
      ));
      
      $items = array();
      
      while($items_pod->fetchRecord()) {
        $items[] = array(
          'uri' => $items_pod->get_field('uri'),
          'citation' => $items_pod->get_field('citation')
        );
      }
            
      array_push($lists, array(
        'type' => $this_pod->get_field('pod_type.slug'),
        'title' => $this_pod->get_field('name'),
        'sort_order' => $sort_order,
        'items' => $items
      ));
    } else {
      // Otherwise, we get all the pages selected in the list_pages multi-select pick field
      $item_pages = $this_pod->get_field('list_pages', 'menu_order ' . $sort_order);
      
      $items = array();
      
      foreach($item_pages as $item) {
        $item_pod = new \Pod($this_pod->get_field('pod_type.slug'), get_post_meta($item['ID'], 'pod_slug', true));
        var_trace(var_export($item_pod, true), 'ITEM_POD');
        
        $items[] = array(
          'title' => $item_pod->get_field('name'),
          'permalink' => get_permalink($item['ID']),
          'pod_featured_image_uri' => wp_get_attachment_url($item_pod->get_field('snapshot.ID'))
        );
      }

      array_push($lists, array(
        'type' => $this_pod->get_field('pod_type.slug'),
        'title' => $this_pod->get_field('name'),
        'page_id' => $this_pod->get_field('featured_item.ID'),
        'sort_order' => $sort_order,
        'items' => $items
      ));
    }
    
  }
  
  if(false) {
    $pod_slug = get_post_meta($post->ID, 'pod_slug', true);
    $pod = new Pod('list', $pod_slug);
    $pod_type = $pod->get_field('pod_type.slug');
    var_trace('fetching list Pod with slug: ' . $pod_slug . " and pod_type: " . $pod_type, $TRACE_PREFIX, $TRACE_ENABLED);
    $pod_title = $pod->get_field('name');
    $page_id = $pod->get_field('featured_item.ID');
    var_trace('slug for featured item: ' . get_post_meta($page_id, 'pod_slug', true), $TRACE_PREFIX, $TRACE_ENABLED);
    $pod_featured_item_thumbnail = get_the_post_thumbnail($page_id, array(960,367));
    if(!$pod_featured_item_thumbnail) { $pod_featured_item_thumbnail = '<img src="' . wp_get_attachment_url($pod->get_field('featured_item_image.ID')) . '" />'; }
    $pod_featured_item_permalink = get_permalink($page_id);
    $pod_featured_item_pod = new Pod($pod_type, get_post_meta($pod->get_field('featured_item.ID'), 'pod_slug', true));
    $sort_order = $pod->get_field('sort_descending') ? 'DESC' : 'ASC';
    $pod_list = $pod->get_field('list_pages', 'menu_order ' . $sort_order);
  }
  
  $obj['lists'] = $lists;
  
  return $obj;
}
