<?php
/**
 * The sidebar containing the main widget area.
 *
 * Template derived from upstream TwentyTwelve; we hide the sidebar
 * for most post types and pods templates. For the rest,
 * if no active widgets in sidebar, we hide it as well.
 *
 * @package lsecities-theme
 * @subpackage lsecities-2012
 * @since LSE Cities 2012 1.4
 */
?>
<?php if(is_user_logged_in() and is_single($post->ID)): ?>
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>
<?php endif; ?>
