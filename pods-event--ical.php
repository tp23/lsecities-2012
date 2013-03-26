<?php
/**
 * Template Name: Pods - Event iCalendar
 * Description: iCalendar (.ics) data of an event
 *
 * see http://stackoverflow.com/a/1464355
 * 
 * @package LSECities2012
 *
 * Pods initialization
 * URI: /media/objects/events/[id]/ical
 */
$TRACE_ENABLED = is_user_logged_in();
$TRACE_PREFIX = 'pods-event--ical';

$obj = pods_prepare_event(pods_url_variable(3));

$ical = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//lsecities.net/wpcal//NONSGML v1.0//EN
BEGIN:VEVENT
UID:" . sha1($obj['slug'], false) . "@lsecities.net
DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z
DTSTART:".$obj['dtstart']."
DTEND:".$obj['dtend']."
SUMMARY:".$obj['title']."
URI:".$obj['event_page_uri']."\n";
if($obj['event_location']) {
  $ical .= "LOCATION:".$obj['event_location']."\n";
}
$ical .= "END:VEVENT
END:VCALENDAR";

//set correct content-type-header
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename=lsecities_event_'.$obj['slug'].'.ics');
echo $ical;
exit;
?>
