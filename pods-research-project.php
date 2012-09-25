<?php
/**
 * Template Name: Pods - Research project
 * Description: The template used for Research projects
 *
 * @package LSECities2012
 */
?><?php
/* URI: /objects/research-projects */
$BASE_URI = PODS_BASEURI_RESEARCH_PROJECTS;
$TRACE_ENABLED = is_user_logged_in();
global $IN_CONTENT_AREA, $HIDE_CURRENT_PROJECTS, $HIDE_PAST_PROJECTS;
$TRACE_PREFIX = 'pods-research-projects';
$pods_toplevel_ancestor = 306;

$pod_slug = get_post_meta($post->ID, 'pod_slug', true);
if($pod_slug) {
  $pod_from_page = true;
} else {
  $pod_slug = pods_url_variable(2);
}

if(!$pod_from_page) {
  // set toplevel ancestor explicitly as we are outside of WP's hierarchy
  global $pods_toplevel_ancestor;

  $pods_toplevel_ancestor = 306;
}

var_trace('pod_slug: ' . $pod_slug, $TRACE_PREFIX, $TRACE_ENABLED);
$pod = new Pod('research_project', $pod_slug);

global $this_pod;
$this_pod = new LC\PodObject($pod, 'Research');

$pod_title = $pod->get_field('name');
$pod_tagline = $pod->get_field('tagline');
$pod_summary = do_shortcode($pod->get_field('summary'));
$pod_blurb = do_shortcode($pod->get_field('blurb'));

// get tiles for heading slider
$heading_slides = array();
var_trace($pod->get_field('heading_slides.slug'), $TRACE_PREFIX, $TRACE_ENABLED);
$slider_pod = new Pod('slide', $pod->get_field('heading_slides.slug'));
foreach($slider_pod->get_field('tiles.slug') as $tile_slug) {
  var_trace($tile_slug, $TRACE_PREFIX, $TRACE_ENABLED);
  $tile = new Pod('tile', $tile_slug);
  array_push($heading_slides, wp_get_attachment_url($tile->get_field('image.ID')));
}

if($pod->get_field('date_start')) { 
  $project_start = new DateTime($pod->get_field('date_start') . '-01-01');
  $project_start = $project_start->format('Y');
}

if($pod->get_field('date_end')) {
  $project_end = new DateTime($pod->get_field('date_end') . '-12-31');
  $project_end = $project_end->format('Y');
}

$project_coordinators_list = $pod->get_field('coordinators');
$project_coordinators_count = count($project_coordinators_list);
foreach($project_coordinators_list as $project_coordinator) {
  $project_coordinators .= $project_coordinator['name'] . ' ' . $project_coordinator['family_name'] . ', ';
}
$project_coordinators = substr($project_coordinators, 0, -2);

$project_researchers_list = $pod->get_field('researchers');
$project_researchers_count = count($project_researchers_list);
foreach($project_researchers_list as $project_researcher) {
  $project_researchers .= $project_researcher['name'] . ' ' . $project_researcher['family_name'] . ', ';
}
$project_researchers = substr($project_researchers, 0, -2);

$project_partners_list = $pod->get_field('contributors');
$project_partners_count = count($project_partners_list);
foreach($project_partners_list as $project_partner) {
  $project_partners .= $project_partner['name'] . ', ';
}
$project_partners = substr($project_partners, 0, -2);

$research_strand_title = $pod->get_field('research_strand.name');
$research_strand_summary = $pod->get_field('research_strand.summary');

$project_status = $pod->get_field('project_status.name');
?><?php get_header(); ?>

<div role="main">
  <?php if ( have_posts() ) : the_post(); endif; ?>
  <div id="post-<?php the_ID(); ?>" <?php post_class('lc-article lc-research-project'); ?>>
    <div class='ninecol' id='contentarea'>
      <div class='top-content'>
        <?php if(count($heading_slides)) : ?>
        <header class='heading-image'>
          <div class='flexslider-research wireframe fullbleed' style="width: 100%; max-width: 100%;">
            <ul class='slides'>
              <?php foreach($heading_slides as $slide): ?>
              <li><img src='<?php echo $slide; ?>' /></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </header>
        <?php endif; ?>
        
        <article class='wireframe eightcol row'>
          <header class='entry-header'>
            <h1><?php echo $pod_title; ?></h1>
            <?php if($pod_tagline): ?><h2><?php echo $pod_tagline; ?></h2><?php endif ; ?>
          </header>
          <div class='entry-content article-text'>
            <?php if($pod_summary): ?>
            <div class="abstract"><?php echo $pod_summary; ?></div>
            <?php endif; ?>
            <?php echo $pod->get_field('blurb'); ?>
          </div>
        </article>
        <aside class='wireframe fourcol last entry-meta' id='keyfacts'>
          <dl>
          <?php if($project_coordinators): ?>
            <dt>Project <?php echo $project_coordinators_count > 1 ?'coordinators' : 'coordinator'; ?></dt>
            <dd><?php echo $project_coordinators; ?></dd>
          <?php endif; ?>
          <?php if($project_researchers): ?>
            <dt><?php echo $project_researchers_count > 1 ? 'Researchers' : 'Researcher'; ?></dt>
            <dd><?php echo $project_researchers; ?></dd>
          <?php endif; ?>
          <?php if($project_partners): ?>
            <dt>Project <?php echo $project_partners_count > 1 ? 'partners' : 'partner'; ?></dt>
            <dd><?php echo $project_partners; ?></dd>
          <?php endif; ?>
          <?php if($research_strand_title): ?>
            <dt>Research strand</dt>
            <dd><?php echo $research_strand_title; ?></dd>
          <?php endif; ?>
          <?php if($project_start and $project_end): ?>
            <dt>Timespan</dt>
            <dd><?php echo $project_start; ?> - <?php echo $project_end; ?></dd>
          <?php endif; ?>
          </dl>
        </aside><!-- #keyfacts -->
      </div><!-- .top-content -->
      <div class='extra-content twelvecol'>
      </div><!-- .extra-content -->
    </div><!-- #contentarea -->
    <?php
      $IN_CONTENT_AREA = false;
      if($project_status == 'active') {
        $HIDE_CURRENT_PROJECTS = false;
        $HIDE_PAST_PROJECTS = true;
      } else {
        $HIDE_CURRENT_PROJECTS = true;
        $HIDE_PAST_PROJECTS = false;
      }
      get_template_part('nav'); ?>
  </div><!-- #post-<?php the_ID(); ?> -->

</div><!-- role='main'.row -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
