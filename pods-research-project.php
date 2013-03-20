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
$web_uri = $pod->get_field('web_uri');
$pod_summary = do_shortcode($pod->get_field('summary'));
$pod_blurb = do_shortcode($pod->get_field('blurb'));
$pod_keywords = $pod->get_field('keywords');

// project duration
$project_duration = '';

// get years from start and date fields
try {
  if($pod->get_field('date_start')) { 
    $project_start = new DateTime($pod->get_field('date_start') . '-01-01');
    $project_start = $project_start->format('Y');
  }
  
  if($pod->get_field('date_end')) {
    $project_end = new DateTime($pod->get_field('date_end') . '-12-31');
    $project_end = $project_end->format('Y');
  }
} catch (Exception $e) {}

// get freeform duration text, if available
$project_duration_freeform = $pod->get_field('duration');

// if freeform duration is available, use this
if($project_duration_freeform) {
  $project_duration = $project_duration_freeform;
} elseif($project_start and $project_end) { // otherwise use start and end year
  $project_duration = $project_start . ' - ' . $project_end;
}

// build a list of all current members of staff
$staff = new Pod('people_group', 'lsecities-staff');
$all_staff = $staff->get_field('members.slug');
var_trace($all_staff, 'all_staff');

$project_coordinators_list = $pod->get_field('coordinators');
$project_coordinators_count = count($project_coordinators_list);
foreach($project_coordinators_list as $project_coordinator) {
  if($project_coordinator['slug'] and array_search($project_coordinator['slug'], $all_staff) !== FALSE) {
    $project_coordinators .= "\n" . '<a href="/' . get_page_uri(2177) . '#p-' . $project_coordinator['slug'] . '">';
  }
  $project_coordinators .= $project_coordinator['name'] . ' ' . $project_coordinator['family_name'];
  if($project_coordinator['slug'] and array_search($project_coordinator['slug'], $all_staff) !== FALSE) {
    $project_coordinators .= '</a>';
  }
  $project_coordinators .= ', ';
}
$project_coordinators = substr($project_coordinators, 0, -2);

$project_researchers_list = $pod->get_field('researchers');
$project_researchers_count = count($project_researchers_list);
foreach($project_researchers_list as $project_researcher) {
  if($project_researcher['slug'] and array_search($project_researcher['slug'], $all_staff) !== FALSE) {
    $project_researchers .= "\n" . '<a href="/' . get_page_uri(2177) . '#p-' . $project_researcher['slug'] . '">';
  }
  $project_researchers .= $project_researcher['name'] . ' ' . $project_researcher['family_name'];
  if($project_researcher['slug'] and array_search($project_researcher['slug'], $all_staff) !== FALSE) {
    $project_researchers .= '</a>';
  }
  $project_researchers .= ', ';
}
$project_researchers = substr($project_researchers, 0, -2);

/*
$project_partners_list = $pod->get_field('partners');
$project_partners_count = count($project_partners_list);
foreach($project_partners_list as $project_partner) {
  $project_partners .= $project_partner['name'] . ', ';
}
$project_partners = substr($project_partners, 0, -2);
*/

// generate list of research partners
$project_partners_list = $pod->get_field('partners', 'name ASC');
$project_partners_count = count($project_partners_list);
foreach($project_partners_list as $project_partner) {
  if($project_partner['web_uri'] and preg_match('/^https?:\/\//', $project_partner['web_uri'])) {
    $project_partners .= '<a href="' . $project_partner['web_uri'] . '">' . $project_partner['name'] . '</a>, ';
  } else {
    $project_partners .= $project_partner['name'] . ', ';
  }
}
$project_partners = substr($project_partners, 0, -2);

// generate list of research funders
$project_funders_list = $pod->get_field('funders', 'name ASC');
$project_funders_count = count($project_funders_list);
foreach($project_funders_list as $project_funder) {
  if($project_funder['web_uri'] and preg_match('/^https?:\/\//', $project_funder['web_uri'])) {
    $project_funders .= '<a href="' . $project_funder['web_uri'] . '">' . $project_funder['name'] . '</a>, ';
  } else {
    $project_funders .= $project_funder['name'] . ', ';
  }
}
$project_funders = substr($project_funders, 0, -2);

$research_strand_title = $pod->get_field('research_strand.name');
$research_strand_summary = $pod->get_field('research_strand.summary');

$project_status = $pod->get_field('project_status.name');

$featured_post['ID'] = $pod->get_field('featured_post.ID');
if($featured_post['ID']) {
  $featured_post['permalink'] = get_permalink($featured_post['ID']);
  $featured_post['thumbnail_url'] = wp_get_attachment_url(get_post_thumbnail_id($featured_post['ID']));
  $featured_post['title'] = get_the_title($featured_post['ID']);
}

$research_output_categories = array('book', 'journal-article', 'book-chapter', 'research-report', 'conference-newspaper', 'conference-proceedings', 'conference-report', 'report', 'blog-post', 'interview', 'magazine-article');
$research_event_categories = array('conference', 'presentation', 'public-lecture', 'workshop');
$event_calendar_categories = array('lse-cities-event');

$research_output_publications_pod_slugs = (array)$pod->get_field('research_outputs_publications.slug');
var_trace(var_export($research_output_publications_pod_slugs, true), 'research_output_publications_pod_slugs');

$research_output_pod_slugs = (array)$pod->get_field('research_outputs.slug');
var_trace(var_export($research_output_pod_slugs, true), 'research_output_pod_slugs');
$research_outputs = array();
foreach($research_output_pod_slugs as $research_output_pod_slug) {
  $research_output_pod = new Pod('research_output', $research_output_pod_slug);
  
  var_trace(var_export($research_output_pod->get_field('category'), true), 'output category');

  $research_outputs[$research_output_pod->get_field('category.slug')][] = array(
    'title' => $research_output_pod->get_field('name'),
    'citation' => $research_output_pod->get_field('citation'),
    'date' => date_string($research_output_pod->get_field('date')),
    'uri' => $research_output_pod->get_field('uri')
  );
}

// now add publications from the publication_wrappers aka Publications pod
$research_output_publications_pod_slugs = (array)$pod->get_field('research_output_publications.slug');
var_trace(var_export($research_output_publications_pod_slugs, true), 'research_output_publications_pod_slugs');
foreach($research_output_publications_pod_slugs as $tmp_slug) {
  $research_output_publication_pod = new Pod('publication_wrappers', $tmp_slug);
  
  var_trace(var_export($research_output_publication_pod->get_field('category'), true), 'output category');
  
  $research_outputs[$research_output_publication_pod->get_field('category.slug')][] = array(
    'title' => $research_output_publication_pod->get_field('name'),
    'citation' => $research_output_publication_pod->get_field('name'),
    'date' => date_string($research_output_publication_pod->get_field('publishing_date')),
    'uri' => get_permalink($research_output_publication_pod->get_field('publication_web_page.ID'))
  );
}

// select events from the main LSE Cities calendar
$events = array();
if($pod->get_field('events')) {
  foreach($pod->get_field('events', 'date_start DESC') as $event) {
    $events[] = array(
      'title' => $event['name'],
      'citation' => $event['name'],
      'date' => $event['date_start'],
      'uri' => PODS_BASEURI_EVENTS . '/' . $event['slug']
    );
  }
}

// now create a single array with all the research events
$research_events = array();
foreach($research_event_categories as $category_slug) {
  foreach($research_outputs[$category_slug] as $event) {
    array_push($research_events, $event);
  }
}

// and sort research events by date descending
foreach($research_events as $key => $val) {
  $date[$key] = $val['date'];
}
array_multisort($date, SORT_DESC, $research_events);

var_trace($research_outputs, 'research_outputs');

foreach($research_output_categories as $category) {
  if(count($research_outputs[$category])) {
    $project_has_research_outputs = true;
  }
}

// prepare heading gallery
$gallery = galleria_prepare($pod, 'fullbleed wireframe');

// if we have research photo galleries/photo essays, prepare them
$research_photo_galleries = galleria_prepare_multi($pod, 'fullbleed wireframe wait', 'photo_galleries');

$news_categories = news_categories($pod->get_field('news_category'));

?><?php get_header(); ?>

<div role="main">
  <?php if ( have_posts() ) : the_post(); endif; ?>
  <div id="post-<?php the_ID(); ?>" <?php post_class('lc-article lc-research-project'); ?>>
    <div class='ninecol' id='contentarea'>
      <div class='top-content'>
        <?php if(count($gallery['slides'])) : ?>
        <header class='heading-image'>
          <?php include('includes/components/galleria.inc.php'); ?>
        </header>
        <?php endif; ?>
        
        <article class='wireframe eightcol row'>
          <header class='entry-header'>
            <h1><?php echo $pod_title; ?></h1>
            <?php if($pod_tagline): ?><h2><?php echo $pod_tagline; ?></h2><?php endif ; ?>
            <?php if($pod_summary): ?>
            <div class="abstract"><?php echo $pod_summary; ?></div>
            <?php endif; ?>
            
            <?php if((is_array($pod->get_field('news_category')) and count($pod->get_field('news_category')) > 0) or count($events) or count($research_photo_galleries)): ?>
            <!--[if gt IE 8]><!--> <script>jQuery(function() { jQuery("article").organicTabs(); });</script> <!--<![endif]-->
            <ul class="nav organictabs row">
              <li class="threecol"><a class="current" href="#project-info">Profile</a></li>
              <?php if(count($events)): ?>
              <li class="threecol"><a href="#news_area">News</a></li>
              <?php endif; // (count($events))?>
              <?php if((is_array($pod->get_field('news_category')) and count($pod->get_field('news_category')) > 0) or count($research_events)): ?>
              <li class="threecol"><a href="#news_area">News</a></li>
              <?php endif; ?>
              <?php if($project_has_research_outputs): ?>
              <li class="threecol"><a href="#linked-publications">Publications</a></li>
              <?php endif; ?>
              <?php if(count($research_photo_galleries)): ?>
              <li class="threecol last"><a href="#linked-galleries">Galleries</a></li>
              <?php endif; ?>
            </ul>
            <?php endif; ?>
          </header>
          <div class='entry-content article-text list-wrap'>
            <section id="project-info">
              <?php echo $pod->get_field('blurb'); ?>
            </section>
            <?php
              if(count($events)):
            ?>
            <section id="events_area" class="hide">
              <header><h1>Events</h1></header>
              <ul>
              <?php
              foreach($events as $event): ?>
              <li>
                <?php if($event['uri']): ?><a href="<?php echo $event['uri']; ?>"><?php endif; ?>
                <?php echo date_string($event['date'], 'jFY') . ' | ';
                      echo $event['citation'] ? $event['citation'] : $event['title']; ?>
                <?php if($event['uri']): ?></a><?php endif; ?>
              </li>
              <?php endforeach; // ($events as $event) ?>
              </ul>
            </section>
            <?php endif; // (count($events)) ?>
            <?php
              if($project_has_research_events or (is_array($pod->get_field('news_category')) and count($pod->get_field('news_category')) > 0)):
              // latest news in categories defined for this research project
              $more_news = new WP_Query('posts_per_page=10' . news_categories($pod->get_field('news_category'))); ?>
              <section id="news_area" class="hide">
                <?php if(is_array($pod->get_field('news_category')) and count($pod->get_field('news_category')) > 0): ?>
                <header><h1>Project news</h1></header>
                <ul>
                <?php
                    while ($more_news->have_posts()) :
                      $more_news->the_post();
                ?>
                  <li><a href="<?php the_permalink(); ?>"><?php the_time('j M Y'); ?> | <?php the_title() ?></a></li>
                <?php
                    endwhile;
                ?>
                </ul>
                <?php endif; // (is_array($pod->get_field('news_category')) and count($pod->get_field('news_category')) > 0) ?>
                <?php if(count($research_events)): ?>
                <header><h1>Conferences</h1></header>
                <ul>
                <?php
                foreach($research_events as $event): ?>
                <li>
                  <?php if($event['uri']): ?><a href="<?php echo $event['uri']; ?>"><?php endif; ?>
                  <?php echo date_string($event['date'], 'jFY') . ' | ';
                        echo $event['citation'] ? $event['citation'] : $event['title']; ?>
                  <?php if($event['uri']): ?></a><?php endif; ?>
                </li>
                <?php endforeach; // ($research_events as $event) ?>
                </ul>
                <?php endif; // (count($research_events)) ?>
              </section> <!-- #news_area -->
            <?php
             endif; // ($pod->get_field('news_category')) and count($pod->get_field('news_category')) > 0 or count($events))
            // publications
            if($project_has_research_outputs): ?>
            <section id="linked-publications" class="hide">
              <header><h1>Publications</h1></header>
              <dl>
                <?php
                  foreach($research_output_categories as $category_slug):
                    if(count($research_outputs[$category_slug])):
                  ?>
                  <dt><?php $category_object = get_category_by_slug($category_slug); echo $category_object->cat_name; ?></dt>
                  <dd>
                    <ul>
                    <?php foreach($research_outputs[$category_slug] as $publication): ?>
                      <li>
                        <?php if($publication['uri']): ?><a href="<?php echo $publication['uri']; ?>"><?php endif; ?>
                        <?php echo $publication['citation']; ?>
                        <?php if($publication['uri']): ?></a><?php endif; ?>
                      </li>
                    <?php
                    endforeach; // ($publication_list as $publication) ?>
                    </ul>
                  </dd>
                <?php 
                    endif; // (count($research_outputs[$category_slug]))
                  endforeach; // ($research_output_categories as $category) ?>

                <!--
                <?php foreach($publications as $publications_in_category): ?>
                <dt></dt>
                <dd>
                  <ul>
                  <?php foreach($publications_in_category as $publication): ?>
                    <li><?php echo $publication['authors']; ?> - <?php echo $publication['title']; ?> <!-- - <? echo $publication['date']; ?> --> [<?php echo $publication['category']; ?>]</li>
                  <?php endforeach; // ($publication_list as $publication) ?>
                  </ul>
                </dd>
                <?php endforeach; // ($publications as $publication_category) ?>
                -->

              </dl>
            </section>
            <?php
            endif; // ($project_has_research_outputs)
            // photo galleries
            if(count($research_photo_galleries)): 
              var_trace($research_photo_galleries, 'research_photo_galleries');
              ?>
            <section id="linked-galleries" class="hide later">
              <header><h1>Photo essays</h1></header>
              <?php
              foreach($research_photo_galleries as $key => $gallery): ?>
                <div class="sixcol<?php if((($key + 1) % 2) == 0): ?> last<?php endif; ?>">
                <?php
                include('includes/components/galleria.inc.php'); ?>
                </div>
                <?php
              endforeach; // ($research_photo_galleries as $key => $gallery) ?>
            </section>
            <?php
            endif; // (count($research_photo_galleries)) ?>
          </div> <!-- .entry-content.article-text -->
        </article>
        <aside class='wireframe fourcol last entry-meta' id='keyfacts'>
          <dl>
          <?php if($web_uri): ?>
            <dt>Website</dt>
            <dd><a href="<?php echo $web_uri; ?>"><?php echo $web_uri; ?></a></dd>
          <?php endif; ?>
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
          <?php if($project_funders): ?>
            <dt>Project <?php echo $project_funders_count > 1 ? 'funders' : 'funder'; ?></dt>
            <dd><?php echo $project_funders; ?></dd>
          <?php endif; ?>
          <?php if($research_strand_title): ?>
            <dt>Research strand</dt>
            <dd><?php echo $research_strand_title; ?></dd>
          <?php endif; ?>
          <?php if($project_duration): ?>
            <dt>Duration</dt>
            <dd><?php echo $project_duration; ?></dd>
          <?php endif; ?>
          <?php if($pod_keywords): ?>
            <dt>Keywords</dt>
            <dd><?php echo $pod_keywords; ?></dd>
          <?php endif; ?>
          <?php if($featured_post['ID']): ?>
            <dt>Highlights</dt>
            <dd>
              <a style="position: relative;" href="<?php echo $featured_post['permalink']; ?>" title=""> <?php // TODO: move CSS to its proper spot :) ?>
                <?php if($featured_post['thumbnail_url']): ?>
                <img src="<?php echo $featured_post['thumbnail_url']; ?>" />
                <?php endif; // ($featured_post['thumbnail_url']) ?>
                <?php if($featured_post['title']): ?>
                <h1 style="box-sizing: border-box; position: absolute; bottom: 0; color: white; background: rgba(0,0,0,0.6); width: 100%; padding: 0.3em;"><?php echo $featured_post['title']; ?></h1>  <?php // TODO: move CSS to its proper spot :) ?>
                <?php endif; // ($featured_post['title']) ?>
              </a>
            </dd>
          <?php endif; // ($featured_post['ID'])?>
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
