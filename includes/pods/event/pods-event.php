<?php

function people_list($people, $heading_singular, $heading_plural) {
  $output = '';
  $people_count = 0;
  $people_with_blurb_count = 0;
  
  if(is_array($people)) {
    if(count($people) > 1) {
      $output .= "<dt>$heading_plural</dt>\n";
    } else {
      $output .= "<dt>$heading_singular</dt>\n";
    }
    $output .= "<dd>\n";
    
    foreach($people as $person) {
      var_trace($person, 'people_list:$person', $TRACE_ENABLED);
      $people_count++;
      if($person['profile_text']) {
        $output .= '<a href="#person-profile-' . $person['slug'] . '">' . $person['name'] . ' ' . $person['family_name'] . "</a>, \n";
        $people_with_blurb_count++;
      } else {
        $output .= $person['name'] . '  ' . $person['family_name'] . ", \n";
      }
    }
    $output = substr($output, 0, -3);
    $output .= "</dd>\n";
  }
  
  return array('count' => $people_count, 'with_blurb' => $people_with_blurb_count, 'output' => $output, 'trace' => var_export($people, true));
}

function orgs_list($organizations) {
  $output = '';
  $org_count = count($organizations);
  
  end($organizations);
  $last_item = each($organizations);
  reset($organizations);
  
  foreach($organizations as $key => $org) {
    if($key == $last_item['key'] and $org_count > 1) {
      $output = substr($output, 0, -3);
      $output .= " and \n";
    }
    if($org['web_uri']) {
      $output .= '<a href=' . $org['web_uri'] . '>';
    }
    $output .= $org['name'];
    if($org['web_uri']) {
      $output .= '</a>';
    }
    $output .= ", \n";
  }
  $output = substr($output, 0, -3);
  
  return $output;
}

function pods_prepare_event($pod_slug) {
  $pod = new Pod('event');
  $pod->findRecords(array('where' => "t.slug = '" . $pod_slug . "'"));

  if(!$pod->getTotalRows()) {
    redirect_to_404();
  }

  $pod->fetchRecord();

  // for menus etc.
  global $this_pod;
  $this_pod = new LC\PodObject($pod, 'Events');

  // prepare array for return data structure
  $obj = array();

  lc_data('META_last_modified', $pod->get_field('modified'));

  var_trace('pod_slug: ' . $pod_slug, $TRACE_PREFIX, $TRACE_ENABLED);
  
  $obj['slug'] = $pod_slug;
  $obj['title'] = $pod->get_field('name');
  
  $event_speakers = $pod->get_field('speakers', 'family_name ASC');
  $event_respondents = $pod->get_field('respondents', 'family_name ASC');
  $event_chairs = $pod->get_field('chairs', 'family_name ASC');
  $event_moderators = $pod->get_field('moderators', 'family_name ASC');
  $obj['event_all_the_people'] = array_merge((array)$event_speakers, (array)$event_respondents, (array)$event_chairs, (array)$event_moderators);
  var_trace($event_all_the_people, $TRACE_PREFIX, $TRACE_ENABLED);
  $obj['event_hashtag'] = ltrim($pod->get_field('hashtag'), '#');
  $obj['event_story_id'] = $pod->get_field('storify_id');

  $obj['speakers_output'] = people_list($event_speakers, "Speaker", "Speakers");
  $obj['respondents_output'] = people_list($event_respondents, "Respondent", "Respondents");
  $obj['chairs_output'] = people_list($event_chairs, "Chair", "Chairs");
  $obj['moderators_output'] = people_list($event_moderators, "Moderator", "Moderators");

  $obj['people_with_blurb'] = $obj['speakers_output']['with_blurb'] + $obj['respondents_output']['with_blurb'] + $obj['chairs_output']['with_blurb'] + $obj['moderators_output']['with_blurb'];

  $obj['event_blurb'] = do_https_shortcode($pod->get_field('blurb'));
  $obj['event_blurb_after_event'] = do_https_shortcode($pod->get_field('blurb_after_event'));
  var_trace($obj['event_blurb_after_event'], $TRACE_PREFIX . 'blurb_after_event', $TRACE_ENABLED);
  $obj['event_contact_info'] = do_shortcode($pod->get_field('contact_info'));

  $event_media_items = $pod->get_field('media_attachments');
  
  foreach($event_media_items as $item) {
    $item_pod = new Pod('media_item_v0', $item->id);
    $slides_pdf_id = $item_pod->get_field('slides_pdf.ID');
    if($slides_pdf_id) {
      $item['slides_uri'] = wp_get_attachment_url($slides_pdf_id);
    }
    $obj['event_media'][] = $item;
  }
  
  $obj['slider'] = $pod->get_field('slider');
  if(!$obj['slider']) {
    $obj['featured_image_uri'] = get_the_post_thumbnail(get_the_ID(), array(960,367));
  }

  // grab the image URI from the Pod
  $attachment_ID = $pod->get_field('heading_image.ID');
  $obj['featured_image_uri'] = wp_get_attachment_url($attachment_ID);
  push_media_attribution($attachment_ID);

  $event_date_start = new DateTime($pod->get_field('date_start'));
  $event_date_end = new DateTime($pod->get_field('date_end'));
  $event_dtstart = $event_date_start->format(DATE_ISO8601);
  $event_dtend = $event_date_end->format(DATE_ISO8601);

  $obj['event_dtstart'] = $event_date_start->format('Ymd').'T'.$event_date_start->format('His').'Z';
  $obj['event_dtend'] = $event_date_end->format('Ymd').'T'.$event_date_end->format('His').'Z';
  // $event_date_string = $pod->get_field('date_freeform');
  $obj['event_date_string'] = $event_date_start->format("l j F Y | ");
  $obj['event_date_string'] .= '<time class="dt-start dtstart" itemprop="startDate" datetime="' . $event_dtstart . '">' . $event_date_start->format("H:i") . '</time>';
  $obj['event_date_string'] .=  '-' . '<time class="dt-end dtend" itemprop="endDate" datetime="' . $event_dtend . '">' . $event_date_end->format("H:i") . '</time>';
  $datetime_now = new DateTime('now');
  $obj['is_future_event'] = ($event_date_start > $datetime_now) ? true : false;

  $obj['event_location'] = $pod->get_field('venue.name');

  $event_type = $pod->get_field('event_type.name');
  $event_series = $pod->get_field('event_series.name');
  $event_host_organizations = orgs_list((array) $pod->get_field('hosted_by'));
  $event_partner_organizations = orgs_list((array) $pod->get_field('partners'));

  $obj['event_info'] = '';
  if($event_type) {
    $event_info .= '<em>' . ucfirst($event_type) . '</em> ';
  } else {
    $event_info .= 'An event ';
  }
  if($event_series) {
    $event_info .= 'of the <em>' . $event_series . '</em> event series ';
  }
  if($event_host_organizations) {
    $event_info .= 'hosted by ' . $event_host_organizations . ' ';
  } else {
    $event_info .= 'hosted by LSE Cities ';
  }
  if($event_partner_organizations) {
    $event_info .= 'in partnership with ' . $event_partner_organizations;
  }

  $poster_pdf = $pod->get_field('poster_pdf');
  $obj['poster_pdf'] = wp_get_attachment_url($poster_pdf[0]['ID']);
  
  $obj['event_page_uri'] = $_SERVER['SERVER_NAME'].PODS_BASEURI_EVENTS."/".$obj['slug'];
  
    // AddToCalendar URIs
  $obj['addtocal_uri_google'] = 'http://www.google.com/calendar/event?action=TEMPLATE&text='.
    $obj['title']
    .'&dates='.$obj['event_dtstart'].'/'.$obj['event_dtend']
    .'&details=&'
    .'location='.$obj['event_location']
    .'&trp=false&'
    .'sprop='.urlencode($obj['event_page_uri']).'&sprop=name:';
    
  return $obj;
}
