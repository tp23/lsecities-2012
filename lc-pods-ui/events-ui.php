<?php
/*
Plugin Name: LSE Cities Events Pods UI
Plugin URI: http://lsecities.net/labs/
Description: Customized Pods UI for Events
Version: 0.2.1
Author: Andrea Rota
Author URI: http://lsecities.net/
*/

function pods_ui_events() {
  $icon = '';
  add_object_page('Events', 'Events', 'read', 'events', '', $icon);
  add_submenu_page('pods-events', 'Events', 'Events', 'read', 'events', 'event_page');
}

function event_page() {
  $object = new Pod('event');
  $object->ui = array(
    'title'   => 'Event',
    'columns' => array(
      'name'       => 'Title',
      'date_start' => 'Date',
      'venue'      => 'Venue',
      'speakers'   => 'Speakers',
      'created'    => 'Date Created',
      'modified'   => 'Last Modified'
    ),
  );
  pods_ui_manage($object);
}

add_action('admin_menu','pods_ui_events');

?>
