<?php
/**
 * Template Name: Pods - Conference
 * Description: The template used for Conference Pods
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
$TRACE_PREFIX = 'pods-conference';

$pod_slug = get_post_meta($post->ID, 'pod_slug', true);
$pod = new Pod('conference', $pod_slug);
$is_conference = true;

var_trace('pod_slug: ' . $pod_slug, $TRACE_PREFIX, $TRACE_ENABLED);

var_trace('button_links: ' . var_export($button_links, true), $TRACE_PREFIX, $TRACE_ENABLED);

$event_hashtag = ltrim($pod->get_field('hashtag'), '#');

$event_blurb = do_shortcode($pod->get_field('abstract'));

$slider = $pod->get_field('slider');
if(!$slider) {
  $featured_image_uri = get_the_post_thumbnail(get_the_ID(), array(960,367));
}

/* process list of partners */
$partners = array();
$conference_partners_slugs = (array) $pod->get_field('partners.slug');
$slug_list = '(';
foreach($conference_partners_slugs as $slug) {
	$slug_list .=  "'$slug',";
}
$slug_list = substr($slug_list, 0, -1);
$slug_list .= ')';

$organizations_pod = new Pod('organization');
$organizations_pod->findRecords(array('where' => 'slug IN ' . $slug_list));

while($organizations_pod->fetchRecord()) {
	array_push($partners, array(
		'id' => $organizations_pod->get_field('slug'),
		'name' => $organizations_pod->get_field('name'),
		'logo_uri' => wp_get_attachment_url($organizations_pod->get_field('logo.ID')),
		'web_uri' => $organizations_pod->get_field('web_uri')
	));
}
var_trace($slug_list, 'slug_list');
var_trace($organizations_pod, 'organizations_pod');
var_trace($partners, 'partners');

$conference_publication_blurb = $pod->get_field('conference_newspaper.blurb');
$conference_publication_cover = wp_get_attachment_url($pod->get_field('conference_newspaper.snapshot.ID'));
$conference_publication_wp_page = get_permalink($pod->get_field('conference_newspaper.publication_web_page.ID'));
$conference_publication_pdf = $pod->get_field('conference_newspaper.publication_pdf_uri');
$conference_publication_issuu = $pod->get_field('conference_newspaper.issuu_uri');

$research_summary_title = $pod->get_field('research_summary.name');
$research_summary_blurb = $pod->get_field('research_summary.blurb');
// tiles is a multi-select pick field so in theory we could have more
// than one tile to display here, however initially we only process the
// first one and ignore the rest - later on we should deal with more
// complex cases (e.g. as a slider or so)
var_trace('tiles: ' . var_export($pod->get_field('research_summary.visualization_tiles'), true), $TRACE_PREFIX, $TRACE_ENABLED);
$visualization_tiles = $pod->get_field('research_summary.visualization_tiles');
$tile_pod = new Pod('tile', $visualization_tiles[0]['slug']);
var_trace('tile_image: ' . var_export($tile_pod->get_field('image'), true), $TRACE_PREFIX, $TRACE_ENABLED);
$research_summary_tile_image = wp_get_attachment_url($tile_pod->get_field('image.ID'));
$research_summary_pdf_uri = $pod->get_field('research_summary.data_section_pdf_uri');

$gallery = array(
 'picasa_gallery_id' => $pod->get_field('photo_gallery'),
 'slug' => $pod->get_field('slug')
);
?>

<?php get_header(); ?>

<div role="main">

<?php if ( have_posts() ) : the_post(); endif; ?>

<div id="post-<?php the_ID(); ?>" <?php post_class('lc-article lc-conference-frontpage'); ?>>


          <div class='ninecol' id='contentarea'>
            <div class='top-content clearfix'>
              <article class="wireframe">
              <?php if($featured_image_uri) : ?>
              <header class='heading-image'>
                <div class='photospread wireframe'>
                  <?php echo $featured_image_uri; ?>
                </div>
              </header>
              <?php endif; ?>
              <div class='wireframe eightcol'>
                <header>
                  <h1><?php echo $pod->get_field('name'); ?></h1>
                  <?php if($pod->get_field('tagline')): ?><h2><?php echo $pod->get_field('tagline'); ?></h2><?php endif; ?>
                </header>
                <?php if($event_blurb): ?>
                  <div class="blurb"><?php echo $event_blurb; ?></div>
                <?php endif; ?>
                <?php if($event_contact_info and $is_future_event): ?>
                  <aside class="booking-and-access"><?php echo $event_contact_info; ?></aside>
                <?php endif; ?>
              </div>
              <aside class='wireframe fourcol last' id='keyfacts'>
                <?php echo $pod->get_field('info'); ?>
                <?php if($pod->get_field('programme_pdf')): ?>
                <dl id="programme">
                  <dt>Programme</dt>
                  <dd><a class="downloadthis pdf" href="<?php echo wp_get_attachment_url($pod->get_field('programme_pdf.ID')); ?>">Download (PDF)</a></dd>
                </dl>
                <?php endif; //($pod->get_field('programme_pdf') ?>
                <?php if(count($partners)): ?>
                <dl id="conference-partners">
                  <dt>Partners</dt>
                  <dd>
                    <ul>
                    <?php foreach($partners as $partner): ?>
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
                <?php if($event_hashtag): ?>
                <div class='twitterbox'>
                  <a href="https://twitter.com/#!/search/#<?php echo $event_hashtag; ?>">#<?php echo $event_hashtag; ?></a>
                </div>
                <?php endif; ?>
              </aside><!-- #keyfacts -->
              </article><!-- .wireframe -->
            </div><!-- .top-content -->
            <div class="extra-content">
              <?php if($research_summary_title and $research_summary_blurb and $research_summary_tile_image): ?>
              <section id="research-summary">
                <header><h1>Research</h1></header>
                <div>
                  <aside id="research-blurb" class="fourcol">
                    <h3><?php echo $research_summary_title; ?></h3>
                    <p><?php echo $research_summary_blurb; ?></p>
                    <?php if($research_summary_pdf_uri): ?>
                    <p><a class="downloadthis pdf button" href="<?php echo $research_summary_pdf_uri; ?>">Download research summary</a></p>
                    <?php endif; ?>
                  </aside>
                  <aside id="research-visualizations" class="eightcol last">
                    <img src="<?php echo $research_summary_tile_image; ?>" />
                  </aside>
                </div>
              </section><!-- #research-summary -->
              <?php endif; ?>
              <aside id="photoarea" class="eightcol">
                <?php include('inc/components/galleria.inc.php'); ?>
              </aside>
              <aside id="publicationsarea" class="fourcol last">
                <?php if($conference_publication_cover and $conference_publication_blurb): ?>
                <div>
                  <ul class="sixcol">
                    <?php if($conference_publication_wp_page): ?><li><a class="readthis online" href="<?php echo $conference_publication_wp_page; ?>">Read online</a></li><?php endif; ?>
                    <?php if($conference_publication_pdf): ?><li><a class="downloadthis pdf" href="<?php echo $conference_publication_pdf; ?>">Download (PDF)</a></li><?php endif; ?>
                    <?php if($conference_publication_issuu): ?><li><a class="readthis online" href="<?php echo $conference_publication_issuu; ?>">Online reader</a></li><?php endif; ?>
                  </ul>
                  <img src="<?php echo $conference_publication_cover; ?>" class="sixcol last">
                </div>
                <?php echo $conference_publication_blurb; ?>
                <?php endif; ?>
              </aside>
            </div><!-- .extra-content -->
          </div><!-- #contentarea -->

          <?php get_template_part('nav'); ?>

</div><!-- #post-<?php the_ID(); ?> -->
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
