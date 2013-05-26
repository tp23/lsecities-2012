<?php
/**
 * Template Name: Pods - Conference
 * Description: The template used for Conference Pods
 *
 * @package LSECities2012
 */

/**
 * Pods initialization
 */
$TRACE_ENABLED = is_user_logged_in();
$TRACE_PREFIX = 'pods-conference';

$obj = pods_prepare_conference(get_post_meta($post->ID, 'pod_slug', true));

/**
 * Copy gallery object to own variable for compatibility with
 * gallery partial.
 */
$gallery = $obj['gallery'];

?><?php get_header(); ?>

<div role="main">

<?php if ( have_posts() ) : the_post(); endif; ?>

<div id="post-<?php the_ID(); ?>" <?php post_class('lc-article lc-conference-frontpage'); ?>>


          <div class='ninecol' id='contentarea'>
            <div class='top-content clearfix'>
              <article class="wireframe">
              <?php if($obj['featured_image_uri']) : ?>
              <header class='heading-image'>
                <div class='photospread wireframe'>
                  <?php echo $obj['featured_image_uri']; ?>
                </div>
              </header>
              <?php endif; ?>
              <div class='wireframe eightcol'>
                <header>
                  <h1><?php echo $obj['conference_title']; ?></h1>
                  <?php if($obj['conference_tagline']): ?><h2><?php echo $obj['conference_tagline']; ?></h2><?php endif; ?>
                </header>
                <?php if($obj['event_blurb']): ?>
                  <div class="blurb"><?php echo $obj['event_blurb']; ?></div>
                <?php endif; ?>
                <?php if($obj['event_contact_info'] and $obj['is_future_event']): ?>
                  <aside class="booking-and-access"><?php echo $obj['event_contact_info']; ?></aside>
                <?php endif; ?>
              </div>
              <aside class='wireframe fourcol last' id='keyfacts'>
                <?php echo $obj['event_info']; ?>
                <?php if($obj['event_programme_pdf']): ?>
                <dl id="programme">
                  <dt>Programme</dt>
                  <dd><a class="downloadthis pdf" href="<?php echo $obj['event_programme_pdf']; ?>">Download (PDF)</a></dd>
                </dl>
                <?php endif; // ($obj['event_programme_pdf']) ?>
                <?php if(count($obj['partners'])): ?>
                <dl id="conference-partners">
                  <dt>Partners</dt>
                  <dd>
                    <ul>
                    <?php foreach($obj['partners'] as $partner): ?>
                      <li id="partner-<?php echo $partner['id']; ?>">
                      <?php if($partner['web_uri']): ?><a href="<?php echo $partner['web_uri']; ?>"><?php endif; ?>
                      <?php if($partner['logo_uri']): ?>
                        <img src="<?php echo $partner['logo_uri']; ?>" alt="<?php echo $partner['name']; ?>" />
                      <?php else: ?>
                        <?php echo $partner['name']; ?>
                      <?php endif; //($partner['logo_uri'])?>
                      <?php if($partner['web_uri']): ?></a><?php endif; ?>
                      </li>
                    <?php endforeach; //($partners as $partner) ?>
                    </ul>
                  </dd>
                </dl>
                <?php endif; // (count($partners)) ?>
                <?php if($obj['event_hashtag']): ?>
                <div class='twitterbox'>
                  <a href="https://twitter.com/#!/search/#<?php echo $obj['event_hashtag']; ?>">#<?php echo $obj['event_hashtag']; ?></a>
                </div>
                <?php endif; ?>
              </aside><!-- #keyfacts -->
              </article><!-- .wireframe -->
            </div><!-- .top-content -->
            <div class="extra-content">
              <?php if($obj['research_summary_title'] and $obj['research_summary_blurb'] and $obj['research_summary_tile_image']): ?>
              <section id="research-summary">
                <header><h1>Research</h1></header>
                <div>
                  <aside id="research-blurb" class="fourcol">
                    <h3><?php echo $obj['research_summary_title']; ?></h3>
                    <p><?php echo $obj['research_summary_blurb']; ?></p>
                    <?php if($obj['research_summary_pdf_uri']): ?>
                    <p><a class="downloadthis pdf button" href="<?php echo $obj['research_summary_pdf_uri']; ?>">Download research summary</a></p>
                    <?php endif; ?>
                  </aside>
                  <aside id="research-visualizations" class="eightcol last">
                    <img src="<?php echo $obj['research_summary_tile_image']; ?>" />
                  </aside>
                </div>
              </section><!-- #research-summary -->
              <?php endif; ?>
              <aside id="photoarea" class="eightcol">
                <?php include('templates/partials/galleria.inc.php'); ?>
              </aside>
              <aside id="publicationsarea" class="fourcol last">
                <?php if($obj['conference_publication_cover'] and $obj['conference_publication_blurb']): ?>
                <div>
                  <ul class="sixcol">
                    <?php if($obj['conference_publication_wp_page']): ?><li><a class="readthis online" href="<?php echo $obj['conference_publication_wp_page']; ?>">Read online</a></li><?php endif; ?>
                    <?php if($obj['conference_publication_pdf']): ?><li><a class="downloadthis pdf" href="<?php echo $obj['conference_publication_pdf']; ?>">Download (PDF)</a></li><?php endif; ?>
                    <?php if($obj['conference_publication_issuu']): ?><li><a class="readthis online" href="<?php echo $obj['conference_publication_issuu']; ?>">Online reader</a></li><?php endif; ?>
                  </ul>
                  <img src="<?php echo $obj['conference_publication_cover']; ?>" class="sixcol last">
                </div>
                <?php echo $obj['conference_publication_blurb']; ?>
                <?php endif; ?>
              </aside>
            </div><!-- .extra-content -->
          </div><!-- #contentarea -->

          <?php get_template_part('nav'); ?>

</div><!-- #post-<?php the_ID(); ?> -->
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
