<?php
/**
 * Template Name: Pods - Conference livestream page
 * Description: The template used for Conference Livestream
 *
 * @package LSECities2012
 */
?>
<?php
/**
 * Pods initialization
 */
global $pods;
$TRACE_ENABLED = is_user_logged_in();
$TRACE_PREFIX = 'pods-conference-livestream';

$pod_slug = get_post_meta($post->ID, 'pod_slug', true);
$pod = new Pod('conference', $pod_slug);

var_trace('pod_slug: ' . $pod_slug, $TRACE_PREFIX, $TRACE_ENABLED);

$live_streaming_video_embedcode = $pod->get_field('live_streaming_video_embedcode');
$live_twitter_querystring = $pod->get_field('live_twitter_querystring');

$live_storify_stories_uris = preg_replace('/^https?:\/\//', '', explode("\n", $pod->get_field('live_storify_stories')));

foreach($live_storify_stories_uris as $story_uri) {
  $live_storify_stories .= '<script src="//' . $story_uri . '.js?template=slideshow"></script>
  <noscript>[<a href="//' . $story_uri . '" target="_blank">View the story on Storify</a>]</noscript>
  ';
}
?>

<?php get_header(); ?>

<div role="main">

<?php if ( have_posts() ) : the_post(); endif; ?>

<div id="post-<?php the_ID(); ?>" <?php post_class('lc-article lc-conference-live-page'); ?>>


          <div class='twelvecol last' id='contentarea'>
            <div class='top-content clearfix'>
              <article class="wireframe">
              <div class='wireframe eightcol'>
                <div class='livestream-box'>
                  <?php
                  if($live_streaming_video_embedcode) {
                    echo $live_streaming_video_embedcode;
                  } ?>
                </div>
                <div class='storify-box'>
                  <?php
                  if($live_storify_stories) {
                    echo $live_storify_stories;
                  }
                  ?>
                </div>
              </div>
              <aside class='wireframe fourcol last tweetfeed-box'>
                <?php
                if($live_streaming_video_embedcode): ?>
               <a class="twitter-timeline" data-dnt=true href="https://twitter.com/search?q=<?php echo urlencode($live_twitter_querystring); ?>" data-widget-id="275652040124932096">Tweets about "<?php echo $live_twitter_querystring; ?>"</a>
               <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                <?php endif; //($live_streaming_video_embedcode) ?>
              </aside><!-- .tweetfeed-box -->
              </article><!-- .wireframe -->
            </div><!-- .top-content -->
          </div><!-- #contentarea -->

</div><!-- #post-<?php the_ID(); ?> -->
</div>

<?php get_footer(); ?>
