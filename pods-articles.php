<?php
/**
 * Template Name: Pods - Articles
 * Description: The template used for Article Pods
 *
 * @package LSECities2012
 */
$TRACE_ENABLED = is_user_logged_in();
?><?php
global $pods;
/* URI: /media/objects/articles/<article-slug>[?lang=<language>] */

$pod_slug = get_post_meta($post->ID, 'pod_slug', true);
if($pod_slug) {
  $pod = new Pod('article', $pod_slug);
  $pod_from_page = true;
} else {
  $pod = new Pod('article', pods_url_variable(3));
  $pod_from_page = false;
}

global $this_pod;
$this_pod = new LC\PodObject($pod, 'Articles');

global $pods_toplevel_ancestor;
$pods_toplevel_ancestor = 309;
global $nav_show_conferences;
$nav_show_conferences = $pod_from_page;

$lang = strtolower(pods_url_variable('lang', 'get'));
$article_lang2 = $pod->get_field('language.slug');
$article_layout = $pod->get_field('layout');

global $publication_pod;

$publication_pod = new Pod('publication_wrappers', $pod->get_field('in_publication.id'));

// grab the image URI from the Pod
$featured_image_uri = wp_get_attachment_url($pod->get_field('heading_image.ID'));

if($TRACE_ENABLED) { error_log('request_language: ' . $lang); }
if($TRACE_ENABLED) { error_log('article_lang2: ' . $article_lang2); }

if(!empty($lang) && $lang == $article_lang2) {
  $article_title = $pod->get_field('title_lang2');
  $article_subtitle = $pod->get_field('subtitle_lang2');
  $article_abstract = do_shortcode($pod->get_field('abstract_lang2'));
  $article_summary = do_shortcode($pod->get_field('summary_lang2'));
  $article_text = do_shortcode($pod->get_field('text_lang2'));
  $article_extra_content = do_shortcode($pod->get_field('extra_content_lang2'));
  $pdf_uri = wp_get_attachment_url($pod->get_field('article_pdf_lang2.ID'));
  if(empty($pdf_uri)) {
    $pdf_uri = $pod->get_field('article_pdf_uri_lang2');
  }
} else {
  $article_title = $pod->get_field('name');
  $article_subtitle = $pod->get_field('article_subtitle');
  $article_abstract = do_shortcode($pod->get_field('abstract'));
  $article_summary = do_shortcode($pod->get_field('summary'));
  $article_text = do_shortcode($pod->get_field('text'));
  $article_extra_content = do_shortcode($pod->get_field('extra_content'));
  $pdf_uri = wp_get_attachment_url($pod->get_field('article_pdf.ID'));
  if(empty($pdf_uri)) {
    $pdf_uri = $pod->get_field('article_pdf_uri');
  }
}

// prepend base URI
if(!preg_match('/^https?:\/\//i', $pdf_uri) && !empty($pdf_uri)) {
  // Istanbul newspaper follows different URI template
  if($pod->get_field('in_publication.slug') == 'istanbul-city-of-intersections') {
    $pdf_uri = 'http://v0.urban-age.net/publications/newspapers/' . $pdf_uri;
  } else {
    $pdf_uri = "http://v0.urban-age.net/0_downloads/" . $pdf_uri;
  }
}

$article_publishing_date = $pod->get_field('publishing_date');
if(!$article_publishing_date) {
  $article_publishing_date = $publication_pod->get_field('publishing_date');
}
$article_tags = $pod->get_field('tags');
$article_authors = $pod->get_field('authors');

// fetch any attachments, replace hostname until we switch to WP+Pods for the whole website
$attachments = $pod->get_field('attachments');
/* // legacy code - remove once new website is live and fully tested
if(count($attachments)) {
  foreach($attachments as &$attachment) {
    $attachment['guid'] = preg_replace('/^https?:\/\/v1\.lsecities\.net/i', 'http://urban-age.net', $attachment['guid']);
  }
}
*/

$gallery_pod = $pod->get_field('gallery');
var_trace($gallery_pod);

$gallery = array(
  'slides' => array()
);

for($i = 1; $i < 13; $i++) {
  $slide_id = $pod->get_field('gallery.' . sprintf('slide%02d', $i) . '.ID');
  var_trace($slide_id);
  if($slide_id) {
    array_push($gallery['slides'], array_shift(get_posts(array('post_type'=>'attachment', 'numberposts'=>1, 'p' => $slide_id))));
  }
}
var_trace($gallery, 'gallery: ');
?>

<?php get_header(); ?>

<div role="main">

<?php if ( have_posts() ) : the_post(); endif; ?>

<div id="post-<?php the_ID(); ?>" class='lc-article lc-newspaper-article'>

          <div class='ninecol' id='contentarea'>
            <div class='top-content'>
              <?php if($featured_image_uri): ?>
              <header class="heading-image">
                <div class='photospread wireframe'>
                  <img src="<?php echo $featured_image_uri; ?>" alt="" />
                </div>
              </header>
              <?php endif; ?>
              <article class='wireframe eightcol'>
                <header class="entry-header">
                  <h1 class="entry-title article-title"><?php echo $article_title; ?></h1>
                  <?php if($article_subtitle): ?>
                  <h2><?php echo $article_subtitle; ?></h2>
                  <?php endif; ?>
                  <?php if($article_abstract): ?>
                  <div class="entry-meta article-abstract"><?php echo $article_abstract; ?></div>
                  <?php endif; ?>
                </header><!-- .entry-header -->
                <div class="entry-content">    
                <?php if(!empty($pod->data)): ?>
                  <div class="article">
                    <div class="entry-content article-text<?php if($article_layout) { echo ' ' . $article_layout; } ?>">
                    <?php if($article_text): ?>
                      <?php echo $article_text; ?>
                    <?php elseif($article_summary): ?>
                      <?php echo $article_summary; ?>
                    <?php endif; ?>
                    </div>

                    <?php if($gallery and is_user_logged_in()): ?>
                      <div class="lc-galleria">
                      <?php foreach($gallery['slides'] as $slide): ?>
                        <a href="<?php echo wp_get_attachment_url($slide->ID); ?>">
                          <img title="<?php echo $slide->post_title; ?>"
                            src="<?php echo wp_get_attachment_url($slide->ID); ?>"
                            alt="<?php echo $slide->post_title; ?>"
                            data-title="<?php echo $slide->post_title; ?>" 
                            data-description="<?php echo $slide->post_excerpt; ?>" />
                        </a>
                      <?php endforeach; ?>
                      </div>
                    <?php endif; ?>
                    <?php if($article_extra_content): ?>
                    <div class="extra-content"><?php echo $article_extra_content; ?></div>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
                    
                <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
                </div><!-- .entry-content -->
              </article>
  
  


              <aside class='wireframe fourcol last minorfacts' id='keyfacts'>
                <div>
                  <dl>
                  <?php if(is_array($article_authors)): ?>
                    <dt>Authors</dt>
                    <dd>
                      <ul>
                      <?php foreach($article_authors as $author): ?>
                        <li><?php echo $author['name'] ?> <?php echo $author['family_name'] ?></li>
                      <?php endforeach; ?>
                      </ul>
                    </dd>
                  <?php endif; ?>
                    <?php if($article_publishing_date): ?>
                    <dt>Publication date</dt>
                    <dd><?php echo $article_publishing_date ?></dd>
                    <?php endif; ?>
                    <?php if(is_array($article_tags)): ?>
                    <dt>Tags</dt>
                    <dd>
                      <ul>
                        <?php foreach($article_tags as $tag): ?>
                          <li><?php echo $tag['name'] ; ?></li>
                        <?php endforeach; ?>
                      </ul>
                    </dd>
                    <?php endif; ?>
                  </dl>
                  <?php if($pdf_uri or is_array($attachments)) : ?>
                  <div class="downloads-area">
                    <ul>
                    <?php if($pdf_uri): ?>
                    <li>
                      <a class='downloadthis pdf button' href="<?php echo $pdf_uri; ?>">Download this article as PDF</a>
                    </li>
                    <?php endif; ?>
                    <?php
                      if(is_array($attachments)) :
                        foreach($attachments as $attachment) :?>
                        <li><a class='downloadthis pdf button' href="<?php echo wp_get_attachment_url($attachment['ID']); ?>" /><?php echo $attachment['post_title']; ?></a></li>
                    <?php
                        endforeach;
                      endif; ?>
                    </ul>
                  </div>
                  <?php endif; ?>           
  
                  <?php get_template_part('snippet-socialmedia-share'); ?>
                  <div class="media-items">
                    
                  </div>
                </div>
              </aside><!-- #keyfacts -->
            </div><!-- .top-content -->
          </div><!-- #contentarea -->

          <?php get_template_part('nav'); ?>
          </div><!-- #navigationarea -->
          
</div><!-- #post-<?php the_ID(); ?> -->

</div><!-- role="main" -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
