<?php
/**
 * Template Name: Pods - Event
 * Description: The template used for Event Pods
 *
 * @package LSECities2012
 */
?>
<?php
/**
 * Pods initialization
 * URI: /media/objects/events/
 */
$TRACE_ENABLED = is_user_logged_in();
$TRACE_PREFIX = 'pods-events-frontpage';
lc_data('pods_toplevel_ancestor', 311);

$obj = pods_prepare_event(pods_url_variable(3));
$media_items_output_counter = 1;
?>

<?php get_header(); ?>

<div role="main">

<?php if ( have_posts() ) : the_post(); endif; ?>

<div id="post-<?php the_ID(); ?>" <?php post_class('lc-article lc-event h-event vevent'); ?>>
          <div class='ninecol' id='contentarea'>
            <div class='top-content'>
              <?php if($obj['featured_image_uri']) : ?>
              <header class='heading-image'>
                <div class='photospread wireframe'>
                  <?php if(false): ?>
                  <a href="https://www.youtube.com/watch?v=<?php echo $obj['event_media'][0]['youtube_uri'] ?>"><img src="<?php echo get_stylesheet_directory_uri() . '/stylesheets/mediaelement/bigplay.png'; ?>" style="background: url('<?php echo $obj['featured_image_uri']; ?>'); center center black" alt="event photo" /></a>
                  <?php else: ?>
                  <img src="<?php echo $obj['featured_image_uri']; ?>" alt="event photo" />
                  <?php endif; ?>
                </div>
              </header>
              <?php endif; ?>
              <article class='wireframe eightcol'>
                <header>
                  <h1 class="hentry-title p-name summary"><?php echo $obj['title']; ?></h1>
                  <p class="event-info"><?php echo $obj['event_info']; ?></p>
                </header>
                <?php if(false === $obj['is_future_event'] and $obj['event_blurb_after_event']): ?>
                  <div class="blurb after-event"><?php echo $obj['event_blurb_after_event']; ?></div>
                <?php else: ?>
                  <?php if($obj['event_blurb']): ?>
                  <div class="blurb description"><?php echo $obj['event_blurb']; ?></div>
                  <?php endif; ?>
                <?php endif; // $is_future_event ?>
                <?php if($obj['event_contact_info'] and $obj['is_future_event']): ?>
                  <aside class="booking-and-access"><?php echo $obj['event_contact_info']; ?></aside>
                <?php endif; ?>
              </article>
              <aside class='wireframe fourcol last' id='keyfacts'>
                <dl>
                    <?php echo $obj['speakers_output']['output'];
                          echo $obj['respondents_output']['output'];
                          echo $obj['chairs_output']['output'];
                          echo $obj['moderators_output']['output'];
                    ?>
                    <?php if($obj['event_date_string']): ?>
                      <dt>When</dt>
                      <dd class="date"><?php echo $obj['event_date_string']; ?> <span class="calendar-link">[add to calendar: <a href="<?php echo $obj['slug']; ?>/ical">ical</a> | <a href="<?php echo $obj['addtocal_uri_google']; ?>" target="_blank">google</a>]</span></dd>
                    <?php endif; ?>
                    <?php if($obj['event_location']): ?>
                      <dt>Where</dt>
                      <dd class="h-card vcard"><span class="p-location location"><?php echo $obj['event_location']; ?></span></dd>
                    <?php endif; ?>

                    <?php if($obj['poster_pdf'] || $obj['freakin_site_map']) : ?>
                      <dt>Downloads</dt>
                      <?php if($obj['poster_pdf']): ?>
                      <dd><a href="<?php echo $obj['poster_pdf']; ?>">Event poster</a> (PDF)</dd>
                      <?php endif; ?>
                      <?php if($obj['freakin_site_map']): ?>
                      <dd><a href="<?php echo $obj['freakin_site_map']; ?>">Site map</a> (PDF)</dd>
                      <?php endif; ?>
                    <?php endif; ?>

                    <?php if(!$obj['is_future_event'] and $obj['event_story_id']): ?>
                      <dt>Twitter archive</dt>
                      <dd><a href="https://storify.com/<?php echo $obj['event_story_id']; ?>">Read on Storify</a></dd>
                    <?php endif; ?>
                </dl>
                <?php if(($obj['is_future_event'] and $obj['event_hashtag']) or (!$obj['event_story_id'] and $obj['event_hashtag'])): ?>
                <div class='twitterbox'>
                  <a href="https://twitter.com/#!/search/<?php echo $obj['event_hashtag']; ?>">#<?php echo $obj['event_hashtag']; ?></a>
                </div>
                <?php endif; ?>
              </aside><!-- #keyfacts -->
            </div><!-- .top-content -->

            <div class='extra-content twelvecol'>
              <?php if(is_array($obj['event_media']) and count($obj['event_media'])): ?>
              <section class="event-materials clearfix">
                <header>
                  <h1>Event materials</h1>
                </header>
                <dl>
                <?php foreach($obj['event_media'] as $event_media_item): ?>
                  <?php if($event_media_item['youtube_uri']): ?>
                  <div class="fourcol<?php echo ' ' . class_if_last_item('last', $media_items_output_counter, 3); ?>">
                    <dt>Video</dt>
                    <dd>
                      <?php if(true) : ?>
                      <iframe
                       width="100%"
                       src="https://www.youtube.com/embed/<?php echo $event_media_item['youtube_uri']; ?>?rel=0"
                       frameborder="0"
                       allowfullscreen="allowfullscreen">
                       &#160;
                      </iframe>
                      <?php else : ?>
                      <video width="100%" id="youtube-<?php echo $event_media_item['youtube_uri']; ?>" preload="none">
                        <source type="video/youtube" src="http://www.youtube.com/watch?v=<?php echo $event_media_item['youtube_uri']; ?>" />
                      </video>
                      <?php $media_items_output_counter++; endif; ?>
                    </dd>
                  </div>
                  <?php endif; ?>
                  <?php if($event_media_item['audio_uri']): ?>
                  <div class="fourcol<?php echo ' ' . class_if_last_item('last', $media_items_output_counter, 3); ?>">
                    <dt>Audio</dt>
                    <dd>
                      <p>Listen to <a class="link mp3" href="<?php echo $event_media_item['audio_uri']; ?>">podcast</a>.</p>
                      <?php if(false) : ?><audio class='mediaelement' src='<?php echo $event_media_item['audio_uri']; ?>' preload='auto'></audio><?php endif; ?>
                    </dd>
                  </div>
                  <?php $media_items_output_counter++; endif; ?>
                  <?php if($event_media_item['slides_pdf'] or $event_media_item['slides_uri']): ?>
                  <div class="fourcol<?php echo ' ' . class_if_last_item('last', $media_items_output_counter, 3); ?>">
                    <dt><?php echo $event_media_item['name']; ?></dt>
                    <dd>
                      <p><a class="link pdf" href="<?php echo $event_media_item['slides_pdf'] ? wp_get_attachment_url($event_media_item['slides_pdf']['ID']) : $event_media_item['slides_uri']; ?>">Download</a> (PDF).</p>
                    </dd>
                  </div>
                  <?php $media_items_output_counter++; endif; ?>
                <?php endforeach; ?>
                </dl>
              </section>
              <?php endif; // ($obj['event_media']) ?>


              <?php if($obj['people_with_blurb']): ?>
              <section id='speaker-profiles' class='clearfix'>
                <header>
                  <h1>Profiles</h1>
                </header>
                <ul class='people-list'>
                <?php $index = 0;
                      foreach($obj['event_all_the_people'] as $key => $event_speaker):
                        if($event_speaker['profile_text']):
                ?>
                <?php if($index % 3 == 0 || $index == 0): ?>
                  <div class="twelvecol">
                <?php endif; ?>
                    <li id="person-profile-<?php echo $event_speaker['slug'] ?>" class="person fourcol<?php if((($index + 1) % 3) == 0) : ?> last<?php endif ; ?>">
                      <h1><?php echo $event_speaker['name'] ?> <?php echo $event_speaker['family_name'] ?></h1>
                      <?php echo $event_speaker['profile_text'] ?>
                      <?php if($event_speaker['homepage'] || $event_speaker['twitterhandle']): ?>
                      <ul class="personal-links">
                      <?php if($event_speaker['homepage']): ?>
                          <li><a href="<?php echo $event_speaker['homepage']; ?>"><?php echo $event_speaker['homepage']; ?></a></li>
                      <?php endif; ?>
                      <?php if($event_speaker['twitterhandle']): ?>
                          <li><a href="<?php echo $event_speaker['twitterhandle']; ?>"><?php echo $event_speaker['twitterhandle']; ?></a></li>
                      <?php endif; ?>
                      </ul>
                      <?php endif; ?>
                    </li>
                <?php if(($index + 1) % 3 == 0): ?>
                  </div>
                <?php endif;
                    $index++;
                  endif; // ($event_speaker['profile_text'])
                endforeach; // ($obj['event_all_the_people'] as $key => $event_speaker) ?>
                </ul><!-- .people-list -->
              </section><!-- #speaker-profiles -->
              <?php endif; // ($obj['people_with_blurb']) ?>
            </div><!-- .extra-content -->
<?php include_once('templates/partials/page-meta.php'); ?>
          </div>

          <?php get_template_part('nav'); ?>

<script type="text/javascript">
jQuery(function($) {
  $('.event-materials audio, .event-materials video').mediaelementplayer({
    audiowidth: '100%',
    defaultVideoWidth: '100%'
  });

  $('.addtocal').AddToCal({
    /* ical and vcal require an ics or vcs file to be served.
     * Since we don't have a server for this demo, these features are disabled.
     * As a result the 30boxes, iCal and vCalendar menu links will not appear
     */
    icalEnabled:false,
    vcalEnabled:false,

    /* getEventDetails is the most critical function to provide.
     * It is called when a user selects a calendar to add an event to.
     * The element parameter is the jQuery object for the event invoked.
     * You must return an object packed with the relevant event details.
     * How you determine the event attributes will depend on your page.
     * The example below illustrates how to handle two formats of event markup.
     */
    getEventDetails: function( element ) {
      var
        dtstart_element = $('.lc-event').find('.dtstart'), start,
        dtend_element = $('.lc-event').find('.dtend'), end,
        title_element = $('.lc-event').find('.summary'), title,
        details_element = $('.lc-event').find('.description'), details;

      // in this demo, we attempt to get hCalendar attributes or otherwise just dummy the values
      start = dtstart_element.length ? dtstart_element.attr('title') : new Date();
      if(dtend_element.length) {
        end = dtend_element.attr('title');
      } else {
        end = new Date();
        end.setTime(end.getTime() + 60 * 60 * 1000);
      }
      title = title_element.length ? title_element.html() : element.attr('id');
      details = details_element.length ? details_element.html() : element.html();

      // return the required event structure
      return {
        webcalurl: null,
        icalurl: null,
        vcalurl: null,
        start: start,
        end: end,
        title: title,
        details: details,
        location: null,
        url: null
        };
      },
  });
});
</script>
</div><!-- #contentarea -->
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
