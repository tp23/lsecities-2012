<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

function pods_prepare_conference($pod_slug) {
  $pod = new Pod('conference', $pod_slug);
  $is_conference = true;

  $obj['conference_title'] = $pod->get_field('name');
  $obj['conference_tagline'] = $pod->get_field('tagline');
  $obj['event_programme_pdf'] = wp_get_attachment_url($pod->get_field('programme_pdf.ID'));
  $obj['event_info'] = $pod->get_field('info');
  
  $obj['event_hashtag'] = ltrim($pod->get_field('hashtag'), '#');

  $obj['event_blurb'] = do_shortcode($pod->get_field('abstract'));

  $slider = $pod->get_field('slider');
  if(!$slider) {
    $obj['featured_image_uri'] = get_the_post_thumbnail(get_the_ID(), array(960,367));
  }

  /* process list of partners */
  $obj['partners'] = array();
  $conference_partners_slugs = (array) $pod->get_field('partners.slug');
  // MONKEYPATCH_BEGIN: sort by slug
  asort($conference_partners_slugs);
  // MONKEYPATCH_END

  foreach($conference_partners_slugs as $conference_partners_slug) {
    $organization_pod = new Pod('organization', $conference_partners_slug);
    
    // MONKEYPATCH_BEGIN
    if($_GET["siteid"] == 'ec2012') {
      $logo_uri = wp_get_attachment_url($organization_pod->get_field('logo_white_raster.ID'));
    } else {
      $logo_uri = wp_get_attachment_url($organization_pod->get_field('logo.ID'));
    }
    // MONKEYPATCH_END
    
    array_push($obj['partners'], array(
        'id' => $organization_pod->get_field('slug'),
        'name' => $organization_pod->get_field('name'),
        'logo_uri' => $logo_uri,
        'web_uri' => $organization_pod->get_field('web_uri')
    ));
  }

  $obj['conference_publication_blurb'] = $pod->get_field('conference_newspaper.blurb');
  $obj['conference_publication_cover'] = wp_get_attachment_url($pod->get_field('conference_newspaper.snapshot.ID'));
  $obj['conference_publication_wp_page'] = get_permalink($pod->get_field('conference_newspaper.publication_web_page.ID'));
  $obj['conference_publication_pdf'] = $pod->get_field('conference_newspaper.publication_pdf_uri');
  $obj['conference_publication_issuu'] = $pod->get_field('conference_newspaper.issuu_uri');

  $obj['research_summary_title'] = $pod->get_field('research_summary.name');
  $obj['research_summary_blurb'] = $pod->get_field('research_summary.blurb');

  // tiles is a multi-select pick field so in theory we could have more
  // than one tile to display here, however initially we only process the
  // first one and ignore the rest - later on we should deal with more
  // complex cases (e.g. as a slider or so)
  var_trace('tiles: ' . var_export($pod->get_field('research_summary.visualization_tiles'), true), $TRACE_PREFIX, $TRACE_ENABLED);
  $visualization_tiles = $pod->get_field('research_summary.visualization_tiles');
  $tile_pod = new Pod('tile', $visualization_tiles[0]['slug']);
  var_trace('tile_image: ' . var_export($tile_pod->get_field('image'), true), $TRACE_PREFIX, $TRACE_ENABLED);
  $obj['research_summary_tile_image'] = wp_get_attachment_url($tile_pod->get_field('image.ID'));
  $obj['research_summary_pdf_uri'] = $pod->get_field('research_summary.data_section_pdf_uri');

  // generate list of items for conference menu (used in nav partial)
  $button_links = $pod->get_field('links') ? $pod->get_field('links') : array();
  $conference_menu = array();
  if(count($button_links)) {
    // sort by menu_order of linked items
    foreach($button_links as $sort_key => $sort_value) {
      $conference_menu[$sort_key] = $sort_value['menu_order'];
    }
    array_multisort($conference_menu, SORT_ASC, $button_links);
  }
  // add the conference homepage itself
  array_unshift($button_links, array('post_title' => $obj['conference_title'], 'guid' => '/ua/conferences/' . $pod_slug));
  $obj['button_links'] = $button_links;
  
  $conference_list = new Pod('list', 'urban-age-conferences');
  $pod_type = $conference_list->get_field('pod_type.slug');
  $pod_list = $conference_list->get_field('list_pages', 'menu_order DESC');

  $obj['conferences_menu_items'] = array();
  
  if(count($pod_list)) {
    foreach($pod_list as $key => $item) {
      $item_pod = new Pod($pod_type, get_post_meta($item['ID'], 'pod_slug', true));
      $menu_conference_title = $item_pod->get_field('conference_title');
      $menu_conference_city_year = $item_pod->get_field('city') . ' | ' . $item_pod->get_field('year');
      $obj['conferences_menu_items'][] = array(
        'permalink' => get_permalink($item['ID']),
        'title' => ($menu_conference_title and $item_pod->get_field('show_title_in_navigation')) ? $menu_conference_title . '<br/>' . $menu_conference_city_year : $menu_conference_city_year
      );
    }
  }
  
  $obj['gallery'] = array(
   'picasa_gallery_id' => $pod->get_field('photo_gallery'),
   'slug' => $pod->get_field('slug')
  );

  return $obj;
}

/**
 * Given a post id, check if this is a child page of a given conference
 * frontpage and if so returns the parent conference's page ID.
 * At the moment we only use subpages of a parent conference page (i.e.
 * only a single level down), but just in case, we check all the
 * ancestry line in case nested page structures are used in the future.
 */
function parent_conference_page($post_id) {
  // get IDs of ancestor pages
  $ancestor_pages = get_post_ancestors($post_id);
  
  // include current page in array (we need to check current page as well)
  array_push($ancestor_pages, $post_id);
  
  foreach($ancestor_pages as $page_id) {
    if(lc_data('pods_conference__wp_page_template') === get_post_meta($page_id, '_wp_page_template', true)) {
      $post_obj = get_post($page_id, ARRAY_A);
      return array('id' => $page_id, 'slug' => $post_obj['post_name']);
    }
  }
  
  // If no ancestor page with template set to conference template,
  // return false.
  return false;
}
