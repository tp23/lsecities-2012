<?php
namespace LSECitiesWPTheme\pods_list;
/**
 * Template Name: Pods - List - index
 * Description: The template used for lists of items
 *
 * @package LSECities2012
 */

/**
 * Differently than most other templates, here we need to pass an array
 * of slugs to the prepare function as we support more than one list per
 * page.
 */
$obj = pods_prepare_list(get_post_meta($post->ID, 'pod_slug', false));

var_trace(var_export($obj, true), 'LIST');
?>

<?php get_header(); ?>

<?php
var_trace(var_export($pod_featured_item_permalink, true), $TRACE_PREFIX . ' - featured_item_permalink');
var_trace(var_export($pod_list, true), $TRACE_PREFIX . ' - pod_list');

?>

<div role="main" class="row">

  <header class="entry-header twelvecol last">
		<h1 class="entry-title"><?php the_title(); ?></h1>
  </header><!-- .entry-header -->

  <article id="post-<?php the_ID(); ?>" <?php post_class('ninecol lc-article lc-list'); ?>>
    <div class="entry-content">
    <?php
    foreach($obj['lists'] as $list) {
      if(empty($list['items'])) continue;

      if($list['type'] === 'research_output') {
        include('templates/pods/list/list-content-research-outputs.php');
      } else {
        include('templates/pods/list/list-content-generic.php');
      }
    } // ($obj['lists'] as $list) ?>

		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->

<?php get_template_part('nav'); ?>

</div><!-- .main.row -->


<?php get_sidebar(); ?>

<?php get_footer(); ?>
