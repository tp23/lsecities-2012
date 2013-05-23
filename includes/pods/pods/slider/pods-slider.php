<?php
function pods_prepare_slider($pod_slug) {  
  $pod = new Pod('slider', $pod_slug);

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

  $obj['news_categories'] = news_categories($pod->get_field('news_category'));
  $obj['jquery_options'] = $pod->get_field('jquery_options');
  $obj['slides'] = $pod->get_field('slides', 'displayorder ASC');
  $obj['linked_events'] = $pod->get_field('linked_events', 'date_start DESC');
  
  return $obj;
}

function get_tile_classes($tile_layout) {
  $element_classes = '';
  
  $xcount = substr($tile_layout, 0, 1);
  $ycount = substr($tile_layout, -1);
  
  switch($xcount) {
    case '1':
      $element_classes .= 'onetile';
      break;
    case '2':
      $element_classes .= 'twotiles';
      break;
    case '3':
      $element_classes .= 'threetiles';
      break;
    case '4':
      $element_classes .= 'fourtiles';
      break;
    case '5':
      $element_classes .= 'fivetiles';
      break;
  }
  
  switch($ycount) {
    case '2':
      $element_classes .= ' tall';
      break;
  }
  
  return $element_classes;
}

function compose_slide($column_spans, $tiles) {
  $TILES_PER_COLUMN = lc_data('TILES_PER_COLUMN');
  
  var_trace(var_export($tiles, true), 'compose_slide|tiles');

  $slide_content = array('columns' => array());
  $tile_index = 0;
  $total_tiles = count($tiles); 
  
  var_trace('column_spans: ' . var_export($column_spans, true), $TRACE_PREFIX);
  
  foreach($column_spans as $key => $column_span) {
    $tile_count = $column_span * $TILES_PER_COLUMN;
    
    // add .last class if this is the last column
    if($key == (count($column_spans) - 1)) { $last_class = ' last'; }
    
    $slide_column = array('layout' => 'col' . $column_span . $last_class, 'tiles' => array());
    while($tile_count > 0 and $tile_index <= $total_tiles) {
      var_trace(var_export($tiles[$tile_index]['slug'], true), 'tile[slug]');
      $tile = new Pod('tile', $tiles[$tile_index++]['slug']);
      $tile_layout = $tile->get_field('tile_layout.name');
      var_trace(var_export($tile_layout, true), 'tile[layout]');
      $this_tile_count = preg_replace('/x/', '*', $tile_layout);
      var_trace(var_export($this_tile_count, true), 'this_tile_count');
      eval('$this_tile_count = ' . $this_tile_count . ';');
      $tile_count -= $this_tile_count;
      var_trace(var_export($tile_count, true), 'tile_countdown');

      unset($target_event_month, $target_event_day, $target_uri);
      
      if($tile->get_field('target_event.date_start')) {
        $target_event_date = new DateTime($tile->get_field('target_event.date_start'));
        var_trace('target_event_date: ' . var_export($target_event_date, true), $TRACE_PREFIX);
        $target_event_month = $target_event_date->format('M');
        $target_event_day = $target_event_date->format('j');
        $target_event_slug = $tile->get_field('target_event.slug');
      }
      
      if($tile->get_field('target_event.slug')) {
        $target_uri = PODS_BASEURI_EVENTS . '/' . $tile->get_field('target_event.slug');
      } elseif($tile->get_field('target_research_project')) {
        $target_uri = PODS_BASEURI_RESEARCH_PROJECTS . '/' . $tile->get_field('target_research_project.slug');
      } elseif($tile->get_field('target_uri')) {
        $target_uri = $tile->get_field('target_uri');
      } elseif($tile->get_field('target_page.ID')) {
        $target_uri = get_permalink($tile->get_field('target_page.ID'));
      } elseif($tile->get_field('target_post.ID')) {
        $target_uri = get_permalink($tile->get_field('target_post.ID'));
      } else {
        $target_uri = null;
      }
      
      /**
       * Add image attribution metadata if present in media item
       */
      $image_attribution = format_media_attribution($tile->get_field('image.ID'));
      
      array_push($slide_column['tiles'],
        array(
          'id' => $tile->get_field('slug'),
          'element_class' => rtrim(get_tile_classes($tile_layout) . ' ' . $tile->get_field('class'), ' '),
          'title' => $tile->get_field('name'),
          'display_title' => $tile->get_field('display_title'),
          'subtitle' => $tile->get_field('tagline'),
          'blurb' => $tile->get_field('blurb'),
          'plain_content' => $tile->get_field('plain_content'),
          'posts_category' => $tile->get_field('posts_category.term_id'),
          'target_uri' => $target_uri,
          'image' => wp_get_attachment_url($tile->get_field('image.ID')),
          'image_attribution' => $image_attribution,
          'target_event' => array(
            'month' => $target_event_month,
            'day' => $target_event_day
          )
        )
      );
      push_media_attribution($tile->get_field('image.ID'));
    }
    array_push($slide_content['columns'], $slide_column);
  }
  return $slide_content;
}
