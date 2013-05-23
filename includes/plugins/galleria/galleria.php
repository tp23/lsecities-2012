<?php
/*
Plugin Name: WordPress LC Galleria
Plugin URI: http://atastypixel.com/blog/wordpress/plugins/galleria-for-wordpress
Description: A plugin wrapper around the Galleria javascript gallery
Version: 1.0
Author: Michael Tyson
Author URI: http://atastypixel.com/blog
*/

define(LC_GALLERIA_BASE_PATH, lc_data('theme_base_path') . '/javascripts/vendor/galleria.io/src');

function galleria_shortcode($args) {
  ob_start();
  $gallery_uniqid = uniqid();
  ?>
  <div id="galleria_<?php echo $gallery_uniqid; ?>" style="width: <?php echo ($args['container-width'] ? $args['container-width'] : '100%'); ?>;"></div>
  <script type="text/javascript">
  jQuery(document).ready(function() {
    Galleria.loadTheme('<?php echo LC_GALLERIA_BASE_PATH . '/themes/classic/galleria.classic.js'; ?>');
    Galleria.run('#galleria_<?php echo $gallery_uniqid; ?>', {
      wait: false,
      debug: <?php echo is_user_logged_in() ? 'true' : 'false'; ?>,
      <?php if($args['picasa_album']) : ?>
      picasa: 'useralbum:<?php echo $args['picasa_album'] ; ?>',
      picasaOptions: {
        sort: 'date-posted-asc'
      },
      <?php elseif($args['flickr_set_id']) : ?>
      flickr: 'set:<?php echo $args['flickr_set_id'] ?>',
      flickrOptions: {
        sort: 'date-posted-asc'
      },
      <?php endif ; ?>
      <?php if($args['responsive']): ?>
      responsive: <?php echo $args['responsive']; ?>,
      <?php endif; ?>
      <?php if($args['height']): ?>
      height: '<?php echo $args['height']; ?>',
      <?php endif; ?>
    });
  });
  </script>  
  <?php
  $c = ob_get_contents();
  ob_end_clean();
  return $c;
}

function galleria_init() {
  wp_enqueue_script('galleria', LC_GALLERIA_BASE_PATH . '/galleria.js', 'jquery', false, true);
  wp_enqueue_script('galleria_picasa', LC_GALLERIA_BASE_PATH . '/plugins/picasa/galleria.picasa.js', 'galleria', false, true);
  wp_enqueue_script('galleria_theme_classic', LC_GALLERIA_BASE_PATH . '/themes/classic/galleria.classic.js', 'galleria', false, true);
  wp_enqueue_style('galleria_theme_classic', LC_GALLERIA_BASE_PATH . '/themes/classic/galleria.classic.css');
  wp_enqueue_style('galleria_theme_classic_lsecities', lc_data('theme_base_path') . '/stylesheets/plugins/galleria.io/galleria.classic.lsecities.css');
}

add_action('init', 'galleria_init' );
add_shortcode('galleria', 'galleria_shortcode');
