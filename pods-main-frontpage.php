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

lc_data('TILES_PER_COLUMN', 2);

$pod_slug = get_post_meta($post->ID, 'pod_slug', true);
$obj = pods_prepare_slider($pod_slug);

$news_categories = $obj['news_categories'];
$jquery_options = $obj['jquery_options'];
$slides = $obj['slides'];
$linked_events = $obj['linked_events'];

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
                  // $tiles = $current_slide_pod->get_field('tiles', 'displayorder ASC');
                  $tiles = array();
                  foreach(array(0, 1, 2, 3, 4, 5, 6, 7) as $tile_counter) {
                    $this_tile_slug = $current_slide_pod->get_field('tile_' . sprintf('%02d', $tile_counter) . '.slug');
                    array_push($tiles, array('slug' => $this_tile_slug));
                  }
                  
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
        component_news($news_categories, '', $linked_events);
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
