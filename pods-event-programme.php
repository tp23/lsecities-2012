<?php
namespace LSECitiesWPTheme\event_programme;
/**
 * Template Name: Pods - Event programme
 * Description: The template used for event programmes
 *
 * @package LSECities2012
 */

$obj = pods_prepare_event_programme(get_post_meta($post->ID, 'pod_slug', true));

?><?php get_header(); ?>

<div role="main" class="row">

<article id="post-<?php the_ID(); ?>" <?php post_class('ninecol lc-article lc-event-programme'); ?>>
  <header class="entry-header">
    <h1 class="entry-title"><?php echo $obj['pod_title']; ?></h1>
    <?php if($obj['pod_subtitle']) : ?>
    <h2><?php echo $obj['pod_subtitle']; ?></h2>
    <?php endif ; ?>
  </header><!-- .entry-header -->
	<div class="entry-content">
    <div id="contentarea">
    <h1><?php echo $obj['page_title']; ?></h1>

    <?php if(!empty($obj['sessions'])) : ?>
      <div class="article row">
        <div class="ninecol event-programme">
        <?php process_subsession_templates($obj['sessions']); ?>
        </div>
        <div class="threecol last">
          <div>
          </div>
        </div>
      </div>
    <?php endif ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
    </div><!-- #contentarea -->
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->

<?php get_template_part('nav'); ?>

</div><!-- role='main'.row -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
