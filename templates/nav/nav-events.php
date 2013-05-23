<?php
$TRACE_ENABLED = is_user_logged_in();
$TRACE_PREFIX = 'nav-events';
$current_post_id = $post->ID;

global $IN_CONTENT_AREA;
global $HIDE_UPCOMING_EVENTS, $HIDE_PAST_EVENTS;
global $pod_slug;
$BASE_URI = PODS_BASEURI_EVENTS;

var_trace('HIDE_UPCOMING_EVENTS: '. $HIDE_UPCOMING_EVENTS, $TRACE_PREFIX, $TRACE_ENABLED);
var_trace('HIDE_PAST_EVENTS: '. $HIDE_PAST_EVENTS, $TRACE_PREFIX, $TRACE_ENABLED);

var_trace('post ID: ' . $current_post_id, $TRACE_PREFIX, $TRACE_ENABLED);
var_trace(var_export($pod, true), $TRACE_PREFIX, $TRACE_ENABLED);

$events_pod = new Pod('event');
$datetime_now = new DateTime('now');
var_trace('datetime_now: ' . $datetime_now->format(DATE_ATOM), $TRACE_PREFIX, $TRACE_ENABLED);

// prepare array with list of upcoming events
$upcoming_events = Array();
$events_pod->findRecords(array(
  'where' => 't.date_end > NOW() AND t.hide IS NOT TRUE',
  'orderby' => 't.date_start ASC',
  'limit' => -1
));
while($events_pod->fetchRecord()) {
  array_push($upcoming_events, array(
    'slug' => $events_pod->get_field('slug'),
    'name' => $events_pod->get_field('name'),
    'date' => date('d F', strtotime($events_pod->get_field('date_start')))
  ));
}

// prepare array with list of past events, split by year
$events = Array();
$current_year = date("Y");
$active_year = $current_year; // used to set initial active section for jQuery UI accordion

for($year = 2005; $year <= $current_year; $year++) {
  $events_pod->findRecords(array(
    'where' => 'YEAR(t.date_start) = ' . $year . ' AND t.date_end < NOW() AND t.hide IS NOT TRUE',
    'orderby' => 'date_start DESC',
    'limit' => -1
  ));
  var_trace($events_pod->getTotalRows(), $TRACE_PREFIX . " - event records found for year $year", $TRACE_ENABLED);
  while($events_pod->fetchRecord()) {
    // if event is past, add it to array
    if($events_pod->get_field['date_end'] < $datetime_now) {
      if($pod_slug == $events_pod->get_field('slug')) {
        $active_year = $year;
      }
      $events[$year][] = Array(
        'slug' => $events_pod->get_field('slug'),
        'name' => $events_pod->get_field('name'),
        'date' => date('j F', strtotime($events_pod->get_field('date_start')))
      );
    }
  }
}

var_trace('events array: ' . var_export($events, true), $TRACE_PREFIX, $TRACE_ENABLED);

// sort by year, backwards from current year
krsort($events);
?>

<nav>
  <dl>
  <?php 
    if($IN_CONTENT_AREA) {
      if(!$HIDE_UPCOMING_EVENTS) {
        include 'nav-events-upcoming.php';
      }
      if(!$HIDE_PAST_EVENTS) {
        include 'nav-events-past.php';
      }
    } else {
      if(!$HIDE_PAST_EVENTS) {
        include 'nav-events-upcoming.php';
      }
      if(!$HIDE_UPCOMING_EVENTS) {
        include 'nav-events-past.php';
      }
    }
  ?>
  </dl>
</nav>
