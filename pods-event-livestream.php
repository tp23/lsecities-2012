<?php
/**
 * Template Name: Pods - Conference livestream page
 * Description: The template used for Conference Livestream
 *
 * Note - this template has been developed for the live time of the
 * Electric City conference and needs to be tested and adapted to
 * any new conferences' live time before being used in production.
 * 
 * @package LSECities2012
 */

/**
 * Pods initialization
 */
$obj = pods_prepare_conference_live(get_post_meta($post->ID, 'pod_slug', true));

?><?php get_header(); ?>

<div role="main">
<?php if ( have_posts() ) : the_post(); endif; ?>
  <div id="post-<?php the_ID(); ?>" <?php post_class('lc-article lc-conference-live-page'); ?>>
    <div class='twelvecol last' id='contentarea'>
      <div class='top-content clearfix'>
        <article class="wireframe">
        <div class='wireframe eightcol'>
          <div class='livestream-box'>
            <?php
            if($obj['live_streaming_video_embedcode']) {
              echo $obj['live_streaming_video_embedcode'];
            } ?>
          </div>
          <div class='livestream-notice'>
            <?php
            if($obj['live_streaming_notice']) {
              echo $obj['live_streaming_notice'];
            } ?>
          </div>
          <div class='storify-box'>
            <?php
            if($obj['live_storify_stories']) {
              echo $obj['live_storify_stories'];
            }
            ?>
          </div>
        </div>
        <aside class='wireframe fourcol last tweetfeed-box'>
          <?php
          if($obj['live_streaming_video_embedcode']): ?>
         <a class="twitter-timeline" data-dnt=true href="https://twitter.com/search?q=<?php echo urlencode($obj['live_twitter_querystring']); ?>" data-widget-id="275652040124932096">Tweets about "<?php echo $obj['live_twitter_querystring']; ?>"</a>
         <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
          <?php endif; //($live_streaming_video_embedcode) ?>
        </aside><!-- .tweetfeed-box -->
        </article><!-- .wireframe -->
      </div><!-- .top-content -->
    </div><!-- #contentarea -->
  </div><!-- #post-<?php the_ID(); ?> -->
</div>

<?php get_footer(); ?>
