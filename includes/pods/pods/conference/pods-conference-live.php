<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

function pods_prepare_conference_live($pod_slug) {
  $pod = new Pod('conference', $pod_slug);
  
  $obj = array();
  
  $obj['live_streaming_video_embedcode'] = $pod->get_field('live_streaming_video_embedcode');
  $obj['live_streaming_notice'] = $pod->get_field('live_streaming_notice');
  $obj['live_twitter_querystring'] = $pod->get_field('live_twitter_querystring');

  $live_storify_stories_uris = preg_replace('/^https?:\/\//', '', explode("\n", $pod->get_field('live_storify_stories')));

  foreach($live_storify_stories_uris as $story_uri) {
    $obj['live_storify_stories'] .= '<script src="//' . $story_uri . '.js?template=slideshow"></script>
    <noscript>[<a href="//' . $story_uri . '" target="_blank">View the story on Storify</a>]</noscript>
    ';
  }
  
  return $obj;
}
