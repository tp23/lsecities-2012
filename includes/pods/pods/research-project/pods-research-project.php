<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

function pods_prepare_research_project($pod_slug) {
  $pod = new Pod('research_project');
  $pod->findRecords(array('where' => "t.slug = '" . $pod_slug . "'"));

  if(!$pod->getTotalRows()) {
    redirect_to_404();
  }

  $pod->fetchRecord();

  // for menus etc.
  global $this_pod;
  $this_pod = new LC\PodObject($pod, 'Research');

  // prepare array for return data structure
  $obj = array();

  lc_data('META_last_modified', $pod->get_field('modified'));

  var_trace('pod_slug: ' . $pod_slug, $TRACE_PREFIX, $TRACE_ENABLED);

  $obj['title'] = $pod->get_field('name');
  $obj['events_blurb'] = $pod->get_field('events_blurb');
  
  return $obj;
}
