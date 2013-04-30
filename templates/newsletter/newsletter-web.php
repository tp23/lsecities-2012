<?php
/**
 * Template for LSE Cities newsletters (web channel)
 * 
 *
 * @package LSECities2012
 */
get_header(); ?>

	<div id="primary" class="site-content ninecol">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

      <div class="extended-table-of-contents">
<?php
foreach($newsletter_sections as $section) {
  include('header-section-email.php');
}
?>
      </div>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
