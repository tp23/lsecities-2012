<?php
namespace LSECitiesWPTheme\event_programme;

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

function pods_prepare_event_programme($pod_slug) {
  $pod = new \Pod('event_programme', $pod_slug);
  
  $obj = array();
  
  $obj['pod_title'] = $pod->get_field('name');
  $obj['pod_subtitle'] = $pod->get_field('programme_subtitle');
  $subsession_slugs = $pod->get_field('sessions.slug');
  if(count($subsession_slugs) == 1) { $subsession_slugs = array(0 => $subsession_slugs); }
  
  /**
   * If we use special fields from the speakers objects to generate
   * speaker blurb and affiliation information for the programme.
   * The following field will be set and contain the prefix for the
   * fields to use in the people pod.
   * e.g. if the special_ec2012 prefix is provided, we expect to
   * fetch speaker blurb and affiliation from the following fields
   * in the people pod:
   * - special_ec2012_blurb
   * - special_ec2012_affiliation
  */
  $special_fields_prefix = $pod->get_field('special_author_fields');
  
  $for_conference = $pod->get_field('for_conference.slug');
  $for_event = $pod->get_field('for_event.slug');
  $obj['page_title'] = !empty($for_conference) ? "Conference programme" : "Event programme";
  
  foreach($subsession_slugs as $session_slug) {
    $obj['sessions'][] = process_session($session_slug, $special_fields_prefix);
  }
  
  return $obj;
}

function process_session($session_slug) {
  global $TRACE_ENABLED;
  global $special_fields_prefix;
  var_trace($special_fields_prefix, 'special_fields_prefix');
  $ALLOWED_TAGS_IN_BLURBS = '<strong><em>';
  
  $pod = new \Pod('event_session', $session_slug);
  $session_speakers = $pod->get_field('speakers');
  $session_chairs = $pod->get_field('chairs');
  $session_respondents = $pod->get_field('respondents');
  $session_start_datetime = new \DateTime($pod->get_field('start'));
  $session_end_datetime = $pod->get_field('end') === '0000-00-00 00:00:00' ? null : new \DateTime($pod->get_field('end'));
  $session_type = $pod->get_field('session_type.slug');
  if($session_type != 'session') { $session_type = "session $session_type"; }

  // get link to PDF of slides: try pick field of file type first
  $session_slides = wp_get_attachment_url($pod->get_field('media_items.slides_pdf.ID'));
  // if no file is linked, try the plain text field for an URI
  if(!$session_slides and $pod->get_field('media_items.slides_uri')) {
    $session_slides = 'http://downloads0.cloud.lsecities.net/' . $pod->get_field('media_items.slides_uri');
  }
  
  /**
   * Recursively process subsessions. HSL.
   */
  $sessions = $pod->get_field('sessions.slug', 'sequence ASC');
  if($sessions and count($sessions) === 1) { $sessions = array(0 => $sessions); }
  if($TRACE_ENABLED) { error_log($TRACE_PREFIX . 'session count: ' . count($subsessions)); }
  if($TRACE_ENABLED) { error_log($TRACE_PREFIX . 'sessions: ' . var_export($subsessions, true)); }
  if($sessions) {
    foreach($sessions as $session) {
      $sessions_data[] = process_session($session);
    }
  }
  
  $obj = array(  
    'id' => $pod->get_field('slug'),
    'title' => $pod->get_field('name'),
    'subtitle' => $pod->get_field('sub_title'),
    'blurb' => $pod->get_field('extra_session_blurb'),
    'show_times' => $pod->get_field('show_times'),
    'start_datetime' => $session_start_datetime->format('H:i'),
    'end_datetime' => is_null($session_end_datetime) ? '' : $session_end_datetime->format('H:i'),
    'hide_title' => $pod->get_field('hide_title'),
    'type' => $session_type,
    'speakers_blurb' => generate_session_people_blurb($pod, 'speakers_blurb', $special_fields_prefix, $session_speakers),
    'chairs_label' => count($session_chairs) > 1 ? "Chairs" : "Chair",
    'chairs_blurb' => generate_session_people_blurb($pod, 'chairs_blurb', $special_fields_prefix, $session_chairs),
    'respondents_label' => count($session_respondents) > 1 ? "Respondents" : "Respondent",
    'respondents_blurb' => generate_session_people_blurb($pod, 'respondents_blurb', $special_fields_prefix, $session_respondents),
    'youtube_video' => $pod->get_field('media_items.youtube_uri'),
    'slides' => $session_slides,
    'sessions' => $sessions_data
  );

  return $obj;
}

function process_session_templates($sessions) {
  foreach($sessions as $session) {
    include(lc_data('theme_filesystem_abspath') . '/templates/pods/event-programme/event-programme-session.php');
  }
}
