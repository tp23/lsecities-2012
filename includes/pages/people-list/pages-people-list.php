<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * @return array A two-item array with the full and the summary people
 * list; these are both HTML fragments - this needs to be rewritten
 * to separate data from html.
 */
function pages_prepare_people_list($people_list_slug) {
  define('MODE_FULL_LIST', 'full_list');
  define('MODE_SUMMARY',  'summary');
  
  // save here all the people whose profile has already been added to output
  $people_in_output_full = array();
  $people_in_output_summary = array();

  lc_data('staff_groups', array(
    'lsecities-staff' => array(
      array('slug' => 'lsecities-staff-mgmt', 'label' => 'Executive'),
      array('slug' => 'lsecities-staff', 'label' => 'Centre staff')
    ),
    'lsecities-advisory-board' => array(
      array('slug' => 'lsecities-advisory-board-chair', 'label' => 'Chair'),
      array('slug' => 'lsecities-advisory-board', 'label' => 'Advisors')
    ),
    'lsecities-executive-group' => array(
      array('slug' => 'lsecities-executive-group-director', 'label' => 'Director'),
      array('slug' => 'lsecities-executive-group-executive-director', 'label' => 'Executive director'),
      array('slug' => 'lsecities-executive-group-academic-director', 'label' => 'Academic director')
    ),
    'lsecities-governing-board' => array(
      array('slug' => 'lsecities-governing-board-chair', 'label' => 'Chair'),
      array('slug' => 'lsecities-governing-board', 'label' => 'Board members')
    )
  ));
  
  $people_list = array(
    'full_list' => people_list_generate_list($people_list_slug, $people_in_output_full, 'full_list'),
    'summary' => people_list_generate_list($people_list_slug, $people_in_output_summary, 'summary')
  );

  var_trace(var_export($people_list, true), 'PEOPLE_LIST');
  
  return $people_list;
}

function people_list_generate_list($list_id, $check_list, $mode = 'full_list') {
  $lists = lc_data('staff_groups');

  // Some lists of people need segmentation into sub-lists:
  // for each sub-list, generate the corresponding section
  if(count($lists[$list_id])) {
    $output = implode(array_map(function($section) use (&$check_list, $mode) {
      return people_list_generate_section($section['slug'], $check_list, $section['label'], $mode);
    }, $lists[$list_id]));
  }

  // If no special segmenting of profiles is needed, just generate
  // one single list
  else {
    $output .= people_list_generate_section($list_id, $check_list, false, $mode);
  }
  
  return $output;
}

function people_list_generate_section($section_slug, &$check_list, $section_heading = false, $mode = 'full_list') {
  $pod = new Pod('people_group', $section_slug);
  $people = (array)$pod->get_field('members', 'family_name ASC');
  // global $people_in_output_full, $people_in_output_summary;
  var_trace(var_export($people, true), $TRACE_PREFIX . ' - group_members');
  $output = "<section class='people-list $section_slug'>";
  if($section_heading) {
    $output .= "<h1>$section_heading</h1>";
  }
  $output .= "<ul>";
  foreach($people as $person) {
    $display_after = new DateTime($person['display_after'] . 'T00:00:00.0');
    $display_until = new DateTime($person['display_until'] . 'T23:59:59.0');
    $datetime_now = new DateTime('now');
    var_trace(var_export($display_after, true), 'display_after');
    var_trace(var_export($display_until, true), 'display_until');
    var_trace(var_export($datetime_now, true), 'datetime_now');
    if($display_after <= $datetime_now and $datetime_now <= $display_until) {
      if($mode === 'full_list') {
        if(!in_array($person['slug'], $check_list)) {
          array_push($check_list, $person['slug']);
          $output .= people_list_generate_person_profile($person['slug'], false, 'full_list');
        }
      } elseif ($mode === 'summary') {
        if(!in_array($person['slug'], $check_list)) {
          array_push($check_list, $person['slug']);
          $output .= people_list_generate_person_profile($person['slug'], false, 'summary');
        }
      }
    }
  }
  var_trace(var_export($check_list, true), $TRACE_PREFIX . ' - people_in_output_' . $mode);
  $output .= " </ul>";
  $output .= "</section>";
  return $output;
}

function people_list_generate_person_profile($slug, $extra_title, $mode = 'full_list') {
  $LEGACY_PHOTO_URI_PREFIX = 'http://v0.urban-age.net';
  $pod = new Pod('authors', $slug);
  $fullname = $pod->get_field('name') . ' ' . $pod->get_field('family_name');
  $fullname = trim($fullname);
  $title = $pod->get_field('title');
  
  $fullname_for_heading = $fullname;
  if($title) {
    $fullname_for_heading .= " ($title)";
  }
  if($extra_title) {
    $fullname_for_heading .= ' ' . $extra_title;
  }
  
  $qualifications_list = array_map(function($string) { return trim($string); }, explode("\n", $pod->get_field('qualifications')));
  
  // get photo and related attribution, push attribution to attribution list
  if($photo_id = $pod->get_field('photo.ID')) {
    // $photo_id = $pod->get_field('photo.ID');
    $profile_photo_uri = wp_get_attachment_url($photo_id);
    $profile_photo_attribution = get_post_meta($photo_id, '_attribution_name', true);
    push_media_attribution($photo_id);
  }

  // if no media library photo is associated to this person,
  // and legacy photo URI is set, use this  
  if(!$profile_photo_uri and $pod->get_field('photo_legacy')) {
    $profile_photo_uri = $LEGACY_PHOTO_URI_PREFIX . $pod->get_field('photo_legacy');
  }

  $email_address = $pod->get_field('email_address');
  $blurb = $pod->get_field('staff_pages_blurb');
  $organization = '<span class=\'org\'>' . $pod->get_field('organization') . '</span>';
  $role = '<span class=\'role\'>' . $pod->get_field('role') . '</span>';
  if($role and $organization) {
    $affiliation = $role . ', ' . $organization;
  } elseif(!$role and $organization) {
    $affiliation = $organization;
  } elseif($role and !$organization) {
    $affiliation = $role;
  }
  
  $additional_affiliations = $pod->get_field('additional_affiliations');
  if($additional_affiliations) {
    $additional_affiliations = explode('\n', $additional_affiliations);
    foreach($additional_affiliations as $additional_affiliation) {
      $affiliation .= "<br />\n" . $additional_affiliation;
    }
  }
  
  if($mode === 'full_list') {
    $output = "<li class='person row vcard' id='p-$slug'>";
    $output .= "  <div class='fourcol profile-photo'>";
    if($profile_photo_uri and $profile_photo_attribution) {
      $output .= "    <img class='photo' src='$profile_photo_uri' alt='$fullname - photo' title='Photo credits: $profile_photo_attribution'/>";
    } elseif($profile_photo_uri) {
      $output .= "    <img class='photo' src='$profile_photo_uri' alt='$fullname - photo'/>";
    } else {
      $output .= "&nbsp;";
    }
    $output .= "  </div>";
    $output .= "  <div class='eightcol last'>";
    $output .= "    <h1 class='fn'>$fullname_for_heading</h1>";
    if($qualifications_list) {
      $output .= "<div class='qualifications'>";
      foreach($qualifications_list as $qualification) {
        $output .= "<span>$qualification</span> ";
      }
      $output = rtrim($output, ' ');
      $output .= "</div>";
    }  
    if($affiliation) {
      $output .= "  <p>$affiliation</p>";
    }
    if($email_address) {
      $output .= "  <p class='email'>$email_address</p>";
    }
    if($blurb) {
      $output .= "  $blurb";
    }
    // project involvement (i.e. list of projects this person is involved in as coordinator or researcher), if applicable
    $projects_list = array();
    if($pod->get_field('projects_coordinated') and $pod->get_field('research_projects') {
    	$projects_list = array_unique(array_merge($pod->get_field('projects_coordinated'), $pod->get_field('research_projects')));
    } elseif($pod->get_field('research_projects')) {
    	$projects_list = $pod->get_field('research_projects');
    } elseif($pod->get_field('projects_coordinated')) {
    	$projects_list = $pod->get_field('projects_coordinated');
    }
    $projects_list_count = count($projects_list);
    if($projects_list_count > 0) {
    	$output .= "  <p>";
    	$cnt = 0;
    	foreach($projects_list as $project) {
    		$cnt ++;
    		if ($project['slug']) {
    			$output .= '<a href="http://lsecities.net/objects/research-projects/' . $project['slug'] . '">';
    		}
    		$output .=  $project['name'];
    		if ($project['slug']) {
    			$output .=  '</a>';
    		}  			
			if ($cnt < $projects_list_count) {
				$output .= ', ';
			}
    	}
    	$output .= "  </p>";
    }
    $output .= "  </div>";
    $output .= "</li>";
  } elseif($mode === 'summary') {
    $output = "<li class='person row' id='p-$slug-link'>";
    $output .= "<a href='#p-$slug'>$fullname</a>";
    $output .= "</li>";
  }
  
  return $output;
}
