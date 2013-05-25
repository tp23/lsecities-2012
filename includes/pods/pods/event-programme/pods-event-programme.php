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
  $all_speakers = array();
  
  $obj['page_title'] = !empty($for_conference) ? "Conference programme" : "Event programme";
  
  foreach($subsession_slugs as $session_slug) {
    $obj['sessions'][] = process_session($session_slug, $special_fields_prefix, $all_speakers);
  }
  
  // sort speakers by family name
  $family_names = array();
  foreach ($all_speakers as $key => $row) {
    $family_names[$key]  = $row['family_name'];
  }
  array_multisort($family_names, SORT_ASC, $all_speakers);
  $obj['all_speakers'] = $all_speakers;
  
  return $obj;
}

function process_session($session_slug, $special_fields_prefix, &$all_speakers) {
  global $TRACE_ENABLED;
  
  $pod = new \Pod('event_session', $session_slug);
  $session_id = $pod->get_field('slug');
  $session_title = $pod->get_field('name');
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
  
  if(is_array($session_speakers)) {
    $all_speakers = add_speakers_to_stash($special_fields_prefix, $all_speakers, $session_speakers, $session_id, $session_title);
  }
  if(is_array($session_chairs)) {
    $all_speakers = add_speakers_to_stash($special_fields_prefix, $all_speakers, $session_chairs, $session_id, $session_title);
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
      $sessions_data[] = process_session($session, $special_fields_prefix, $all_speakers);
    }
  }
  
  $obj = array(  
    'id' => $session_id,
    'title' => $session_title,
    'subtitle' => $pod->get_field('sub_title'),
    'blurb' => $pod->get_field('extra_session_blurb'),
    'show_times' => $pod->get_field('show_times'),
    'start_datetime' => $session_start_datetime->format('H:i'),
    'end_datetime' => is_null($session_end_datetime) ? NULL : $session_end_datetime->format('H:i'),
    'hide_title' => $pod->get_field('hide_title'),
    'type' => $session_type,
    'speakers_blurb' => !is_array($session_speakers) ? NULL : generate_session_people_blurb($pod, 'speakers_blurb', $special_fields_prefix, $session_speakers),
    'chairs_label' => count($session_chairs) > 1 ? "Chairs" : "Chair",
    'chairs_blurb' => !is_array($session_chairs) ? NULL : generate_session_people_blurb($pod, 'chairs_blurb', $special_fields_prefix, $session_chairs),
    'respondents_label' => count($session_respondents) > 1 ? "Respondents" : "Respondent",
    'respondents_blurb' => !is_array($session_respondents) ? NULL : generate_session_people_blurb($pod, 'respondents_blurb', $special_fields_prefix, $session_respondents),
    'youtube_video' => $pod->get_field('media_items.youtube_uri'),
    'slides' => $session_slides,
    'sessions' => $sessions_data
  );

  return $obj;
}

function process_session_templates($sessions) {
  if(!is_array($sessions)) return false;
  foreach($sessions as $session) {
    include(lc_data('theme_filesystem_abspath') . '/templates/pods/event-programme/event-programme-session.php');
  }
}

function generate_session_people_blurb($pod, $blurb_field, $special_fields_prefix, $session_people) {
  $ALLOWED_TAGS_IN_BLURBS = '<strong><em>';
  
  if(!isset($pod)) {
    error_log('No pod objet provided');
    return;
  }
  if(!isset($blurb_field)) {
    error_log('No blurb field name provided');
    return;
  }
  if(!is_array($session_people) or count($session_people) === 0) {
    error_log('No people list provided');
    return;
  }
  
  $session_people_blurb = '';

  /* If we have event-specific author info, use this */
  if($special_fields_prefix) {
    foreach($session_people as $this_person) {
      $affiliation = '';
      $session_people_blurb .= '<strong>' . $this_person['name'] . ' ' . $this_person['family_name'] . '</strong>';
      $affiliation = $this_person[$special_fields_prefix . '_affiliation'];
      
      /* if no event-specific blurb is available for person, fetch
       * generic person role and affiliation information from their
       * record */
      if(!$affiliation) { 
        $this_person_role = $this_person['role'];
        $this_person_organization = $this_person['organization'];
        var_trace($this_person_role, 'this_person_role');
        var_trace($this_person_organization, 'this_person_organization');
        if($this_person_role and $this_person_organization) {
          $affiliation = $this_person_role . ', ' . $this_person_organization;
        } elseif($this_person_organization) {
          $affiliation = $this_person_organization;
        }
      }
      
      /* if any blurb is available, add it to the session people blurb */
      if($affiliation) {
        $session_people_blurb .= ', ' . $affiliation;
      }
      
      /* add separator semicolon */
      $session_people_blurb .= '; ';
    }
    
    /* remove trailing semicolon */
    $session_people_blurb = preg_replace('/; $/', '', $session_people_blurb);
  } elseif($pod->get_field($blurb_field)) { /* otherwise, if per-session blurb is available, use this */
    $session_people_blurb = strip_tags($pod->get_field($blurb_field), $ALLOWED_TAGS_IN_BLURBS);
  }
  
  return $session_people_blurb;
}

function add_speakers_to_stash($special_fields_prefix, $all_speakers, $session_speakers, $session_id, $session_title) {
  if(!is_array($session_speakers)) return $all_speakers;
  
  foreach($session_speakers as $session_speaker) {
    // don't process speaker if already in all_speakers list
    if(is_array($all_speakers[$session_speaker['slug']])) continue;
    
    // otherwise, fetch speaker info and add it to all_speakers
    $this_speaker = new \Pod('authors', $session_speaker['slug']);
    $speaker_blurb_and_affiliation = generate_speaker_card_data($special_fields_prefix, $session_speaker['slug']);

    $all_speakers[$session_speaker['slug']]['name'] = $session_speaker['name'];
    $all_speakers[$session_speaker['slug']]['family_name'] = $session_speaker['family_name'];
    $all_speakers[$session_speaker['slug']]['blurb'] = $speaker_blurb_and_affiliation['blurb'];
    if($this_speaker->get_field('photo')) {
      $all_speakers[$session_speaker['slug']]['photo_uri'] = wp_get_attachment_url($this_speaker->get_field('photo.ID'));
    } elseif($session_speaker['photo_legacy']) {
      $all_speakers[$session_speaker['slug']]['photo_uri'] = 'http://v0.urban-age.net' . $session_speaker['photo_legacy'];
    }
    $all_speakers[$session_speaker['slug']]['affiliation'] = $speaker_blurb_and_affiliation['affiliation'];
    $all_speakers[$session_speaker['slug']]['speaker_in'][] = array($session_id, $session_title);
  }
  
  return $all_speakers;
}

function generate_speaker_card_data($special_fields_prefix, $person_slug) {
  $pod = new \Pod('authors', $person_slug);
  
  if($special_fields_prefix) {
    $affiliation = $pod->get_field($special_fields_prefix . '_affiliation');
    $blurb = $pod->get_field($special_fields_prefix . '_blurb');
  } else {
    $role = $pod->get_field('role');
    $organization = $pod->get_field('organization');
    
    if($role and $organization) {
      $affiliation = $role . ', ' . $organization;
    } elseif($organization) {
      $affiliation = $organization;
    }
    $blurb = $pod->get_field('profile_text');
  }
  
  return array(
    'blurb' => $blurb,
    'affiliation' => $affiliation
  );
}
