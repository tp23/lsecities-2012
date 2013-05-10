<?php
/**
 * Template Name: Pods - Main frontpages
 * Description: The template used for LSE Cities main frontpage and Urban Age sub-site frontpage
 *
 * @package LSECities2012
 */
?><?php
/**
 * Pods initialization
 * URI: TBD
 */

$TRACE_PREFIX = 'pods-main-frontpage';

$TILES_PER_COLUMN = 2;

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
  global $TILES_PER_COLUMN;
  
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
      $image_attribution_name = get_post_meta($post->ID, '_attribution_name', true);
      $image_attribution_uri = get_post_meta($post->ID, '_attribution_uri', true);
      if($image_attribution_name and $image_attribution_uri) {
        $image_attribution = 'Photo credits: ' . $image_attribution_name . ' - ' . $image_attribution_uri;
      } elseif($image_attribution_name or $image_attribution_uri) {
        // if either meta field is provided, just join both as only one will be output
        $image_attribution = 'Photo credits: ' . $image_attribution_name . $image_attribution_uri;
      }
      
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

$pod_slug = get_post_meta($post->ID, 'pod_slug', true);
var_trace('pod_slug: ' . $pod_slug, $TRACE_PREFIX);
$pod = new Pod('slider', $pod_slug);

$news_categories = news_categories($pod->get_field('news_category'));
$jquery_options = $pod->get_field('jquery_options');

$slides = $pod->get_field('slides', 'displayorder ASC');
$linked_events = $pod->get_field('linked_events', 'date_start DESC');
var_trace($linked_events, 'linked_events');
?><?php get_header(); ?>

<div role="main">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('lc-article lc-slider-page'); ?>>
	<div class="entry-content">

    <div class='row' id='core'>
      <div class='twelvecol' id="contentarea">
<div class="flexslider">
  <?php var_trace(var_export($slides, true), $TRACE_PREFIX, $TRACE_ENABLED); ?>
              <ul class="slides">
                <?php foreach($slides as $current_slide): ?>
                <?php
                  $current_slide_pod = new Pod('slide', $current_slide['slug']);
                  $slide_layout = $current_slide_pod->get_field('slide_layout.slug');
                  $tiles = $current_slide_pod->get_field('tiles', 'displayorder ASC');
                  
                  var_trace('tiles: ' . var_export($tiles, true), $TRACE_PREFIX, $TRACE_ENABLED);
                  var_trace('slide_layout: ' . var_export($slide_layout, true), $TRACE_PREFIX, $TRACE_ENABLED);
                  
                  switch($slide_layout) {
                    case 'two-two-one':
                      $slide_content = compose_slide(array(2, 2, 1), $tiles);
                      var_trace(var_export($slide_content, true), 'slide_content_array');
                      break;
                    case 'four-one':
                      $slide_content = compose_slide(array(4, 1), $tiles);
                      var_trace(var_export($slide_content, true), 'slide_content_array');
                      break;
                    case 'five':
                      $slide_content = compose_slide(array(5), $tiles);
                      var_trace(var_export($slide_content, true), 'slide_content_array');
                      break;
                    default:
                      break;
                  }
                ?>
                <li>
                  <div class="slide-inner row">
                    <?php foreach($slide_content['columns'] as $slide_column): ?>
                      <div class="<?php echo $slide_column['layout']; ?> column">
                        <?php foreach($slide_column['tiles'] as $tile): ?>
                        
                          <div class="tile <?php echo $tile['element_class']; ?>" id="slidetile-<?php echo $tile['id']; ?>">
                            <?php if($tile['target_uri']): ?><a href="<?php echo $tile['target_uri']; ?>"><?php endif; ?>
                            <?php if($tile['image']): ?>
                              <div class="crop">
                                  <img src="<?php echo $tile['image']; ?>"<?php if($tile['image_attribution']): ?> title="<?php echo $tile['image_attribution']; ?>"<?php endif; ?> />
                              </div>
                            <?php endif; ?>
                            <?php if($tile['plain_content']): ?>
                              <div class="<?php echo $tile['element_class']; ?>">
                                <div class="inner-box">
                                  <?php if($tile['display_title']): ?><h1><?php echo $tile['title']; ?></h1><?php endif; ?>
                                  <?php echo $tile['plain_content']; ?>
                                </div>
                              </div>
                            <?php elseif($tile['posts_category']): ?>
                              <div class="<?php echo ltrim($tile['element_class'] . ' categoryarchive', ' '); ?>">
                                <!-- <em>Recent news go here</em> -->
                              </div>
                            <?php elseif($tile['title'] or $tile['subtitle'] or $tile['blurb']): ?>
                              <div class="feature-info<?php if(!$tile['blurb']): ?> noblurb<?php endif; ?>">
                                <?php if($tile['title'] or $tile['subtitle']): ?>
                                <div class="feature-key-info">
                                  <?php if($tile['target_event']['month'] and $tile['target_event']['day']): ?>
                                  <div class="feature-date">
                                    <div class="month"><?php echo $tile['target_event']['month']; ?></div>
                                    <div class="day"><?php echo $tile['target_event']['day']; ?></div>
                                  </div>
                                  <?php endif; // ($tile['target_event']['month'] and $tile['target_event']['day']) ?>
                                  <header>
                                    <?php if($tile['title']): ?><div class='feature-title'><?php echo $tile['title']; ?></div><?php endif; ?>
                                    <?php if($tile['subtitle']): ?><div class='feature-caption'><?php echo $tile['subtitle']; ?></div><?php endif; ?>
                                  </header>
                                </div>
                                <?php endif; // ($tile['title'] or $tile['subtitle']) ?>
                                <?php if($tile['blurb']): ?><div class='feature-blurb'><?php echo $tile['blurb']; ?></div><?php endif; ?>
                              </div><!-- .feature-info -->
                            <?php endif; ?>
                            <?php if(isset($slide_column['target_uri'])): ?>
                            <?php endif; ?>
                            <?php if($tile['target_uri']): ?></a><?php endif; ?>
                          </div><!-- .tile#slidetile-<?php echo $tile['id']; ?> -->
                                                  
                        <?php endforeach; ?>
                      </div><!-- <?php echo $slide_column['layout']; ?> -->
                    <?php endforeach; ?>
                  </div><!-- .slide-inner.row -->
                </li>
                <?php endforeach; ?>
              </ul>
            </div>
      </div>      
      <div class="extra-content<?php if(count($linked_events) > 0): ?> multi-section<?php endif; ?>">
      <?php
        component_news($pod->get_field('news_category'), '', $linked_events);
      ?>
      </div><!-- .extra-content -->
<?php include_once('includes/snippets/page-meta.php'); ?>
    </div><!-- #core.row -->
    </div>        
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->

<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
