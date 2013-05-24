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

$obj = pods_prepare_slider(get_post_meta($post->ID, 'pod_slug', true));

?><?php get_header(); ?>

<div role="main">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('lc-article lc-slider-page'); ?>>
	<div class="entry-content">

    <div class='row' id='core'>
      <div class='twelvecol' id="contentarea">
<div class="flexslider">
              <ul class="slides">
                <?php foreach($obj['slides'] as $slide_content): ?>
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
      <div class="extra-content<?php if(count($obj['linked_events']) > 0): ?> multi-section<?php endif; ?>">
      <?php
        component_news($obj['news_categories'], '', $obj['linked_events']);
      ?>
      </div><!-- .extra-content -->
<?php include_once('templates/partials/page-meta.php'); ?>
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
