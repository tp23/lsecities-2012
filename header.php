<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package LSECities2012
 */
?><?php
$TRACE_ENABLED = is_user_logged_in();
var_trace('header.php starting for post with ID' . $post->ID);
$ancestors = get_ancestors($post->ID, 'page');
array_unshift($ancestors, $post->ID);
global $pods_toplevel_ancestor;
$toplevel_ancestor = array_pop($ancestors);

// co-branding: check the X-Site-Id HTTP header from frontend cache
$http_req_headers = getallheaders();
if($http_req_headers["X-Site-Id"] == 'ec2012') {
  lc_data('x-site-id', 'ec2012');
}

if($_GET["siteid"] == 'ec2012') { // we are being called via the ec2012 microsite
  $body_class_extra = 'ec2012';
  lc_data('microsite_id', 'ec2012');
} elseif($_GET["siteid"] == 'cc') { // we are being called via the Cities and the crisis microsite
  $body_class_extra = 'site-cc';
  lc_data('microsite_id', 'cc');
}

// If we are on the root frontpage ('/', page ID 393), set ancestor to nil
if($toplevel_ancestor == 393) { $toplevel_ancestor = null; }

// If we are processing a Pods page for the Article pod, manually set our current position
if($pods_toplevel_ancestor) { $toplevel_ancestor = $pods_toplevel_ancestor; }

var_trace(var_export($ancestors, true), 'ancestors (array)');
var_trace($ancestors[0], 'ancestor[0]');
var_trace($toplevel_ancestor, 'toplevel_ancestor');

$level2nav = wp_list_pages('child_of=' . $toplevel_ancestor . '&depth=1&sort_column=menu_order&title_li=&echo=0');

// check if we are in the Urban Age section
lc_data('urban_age_section', ($toplevel_ancestor == 94) ? true : false);
$logo_element_id = lc_data('urban_age_section') ? 'ualogo' : 'logo';

if($post->ID == 2481 or in_array(2481, $post->ancestors)) { // Labs -> Cities and the crisis
  // If we are navigating the Cities and the crisis minisite via reverse proxy, display appropriate menu
  $level1nav = '<li><a href="/" title="Home">Cities and the Crisis</a></li>';
  $level2nav = wp_list_pages('echo=0&depth=1&sort_column=menu_order&title_li=&child_of=' . 2481);
  // And strip prefix
  $level2nav = preg_replace('/https?:\/\/lsecities\.net\/labs\/cities-and-the-crisis/', '', $level2nav);
  lc_data('site-cc', true);
} elseif(lc_data('x-site-id') === 'ec2012') { // Electric City conference minisite
  // If we are navigating the EC2012 minisite via reverse proxy, display appropriate menu
  $level1nav = '';
  $class_for_current_page = $post->ID == 2701 ? ' current_page_item' : '';
  if(!is_user_logged_in()) {
    $only_include_top_pages_ids = '&include=2714,2716,3288,3290,3294,2949,3160,3102,3098';
  } else {
    $only_include_top_pages_ids = '&child_of=2701';
  }
  $level2nav = '<li class="page-item page-item-2701' . $class_for_current_page . '">' .
    '<a href="/">Home</a></li>' . 
    wp_list_pages('echo=0&depth=1&sort_column=menu_order&title_li=' . $only_include_top_pages_ids);
  // And strip prefix
  $level2nav = preg_replace('/https?:\/\/lsecities\.net\/ua\/conferences\/2012-london\/site/', '', $level2nav);
  var_trace($level2nav, 'header_level2nav', true);
  /*
  $level2nav = '<li class="page-item page-item-2701 current_page_item"><a href="/">Home</a></li><li class="page_item page-item-2714"><a href="/programme/">Programme</a></li>
<li class="page_item page-item-2716"><a href="/speakers/">Speakers</a></li>'; */
  // $appcache_manifest = '/appcache-manifests/ec2012.appcache';
  lc_data('site-ec2012', true);
} elseif($post->ID == 1074 or in_array(1074, $post->ancestors)) { // if within Newsletter section, do not populate level2nav
  $level2nav = '';
} else {
  $include_pages = '617,306,309,311,94,629,3338';
  $level1nav = '<li><a href="/" title="Home">Home</a></li>' . wp_list_pages('echo=0&depth=1&sort_column=menu_order&title_li=&include=' . $include_pages);
}
?><!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?><?php if($appcache_manifest): ?> manifest="<?php echo $appcache_manifest; ?>"<?php endif; ?>> <!--<![endif]-->
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	// if the page title is set from within a Pods template, use this -
	// otherwise use wp_title
	wp_title( '|', true, 'right' );

	// Add the blog name.
	// bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

	?></title>

<meta name="description" content="<?php echo esc_html(lc_data('meta_description')); ?>">

<link rel="profile" href="http://gmpg.org/xfn/11" />
<script async type="text/javascript" src="https://use.typekit.com/ftd3lpp.js"></script>
<script async type="text/javascript">try{Typekit.load();}catch(e){}</script> 
<link href="https://cloud.webtype.com/css/9044dce3-7052-4e0e-9dbb-377978412ca7.css" rel="stylesheet" type="text/css" />
<?php 
  wp_enqueue_style('font-open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,300,800,300italic,400italic,800italic');

  wp_enqueue_style('jquery.flexslider', get_stylesheet_directory_uri() . '/stylesheets/flexslider/flexslider.css');
  wp_enqueue_script('jquery.flexslider', get_stylesheet_directory_uri() . '/javascripts/jquery.flexslider.min.js', 'jquery', false, true);
?>

<?php wp_enqueue_script('jquery-ui-core', '', '', '', true); ?>
<?php wp_enqueue_script('jquery-ui-accordion', '', '', '', true); ?>
<?php wp_enqueue_script('jquery-ui-tabs', '', '', '', true); ?>
<?php wp_enqueue_script('jquery-sticky', get_stylesheet_directory_uri() . '/javascripts/jquery.sticky.min.js', 'jquery', false, true); ?>
<?php wp_enqueue_script('jquery-organictabs', get_stylesheet_directory_uri() . '/javascripts/jquery.organictabs.js', 'jquery', false, true); ?>
<?php wp_enqueue_script('jquery-mediaelement', get_stylesheet_directory_uri() . '/javascripts/mediaelement-and-player.js', 'jquery', '2.9.2', false); ?>
<?php wp_enqueue_script('rfc3339date', get_stylesheet_directory_uri() . '/javascripts/rfc3339date.js', false, false, true); ?>
<?php wp_enqueue_script('jquery-addtocal', get_stylesheet_directory_uri() . '/javascripts/jquery.addtocal.js', array('jquery', 'jquery-ui-core', 'jquery-ui-menu'), false, true); ?>
<!-- <script async="async" src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script> -->
<?php wp_enqueue_script('jquery-url-parser', get_stylesheet_directory_uri() . '/javascripts/vendor/jquery-url-parser/purl.js', array('jquery'), false, true); ?>
<?php wp_enqueue_script('cookie-control', get_stylesheet_directory_uri() . '/javascripts/civicuk.com/cookieControl-5.1.min.js', 'jquery', false, true); ?>
<?php wp_enqueue_style('jquery-mediaelement', get_stylesheet_directory_uri() .'/stylesheets/mediaelement/mediaelementplayer.css'); ?>
<?php wp_enqueue_style('font-theovandoegsburg', get_stylesheet_directory_uri() . '/stylesheets/fonts/theovand/stylesheet.css'); ?>
<?php wp_enqueue_style('font-fontello', get_stylesheet_directory_uri() . '/stylesheets/fonts/fontello/stylesheet.css'); ?>
 <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>

<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory') ?>/stylesheets/cssgrid.net/1140.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />

<script type='text/javascript'>
/* <![CDATA[ */
var usernoiseButton = {"text":"Feedback","style":"background-color: #ff0000; color: #FFFFFF; opacity: 0.7;","class":"un-left","windowUrl":"http:\/\/lsecities.net\/wp-admin\/admin-ajax.php?action=un_load_window","showButton":"1"};
/* ]]> */
</script>
</head>

<body <?php body_class($body_class_extra); ?>>

    <!--[if lt IE 9 ]>
      <p class='flash top chromeframe'>
        You are using an outdated browser.
        <a href="http://browsehappy.com/">Upgrade your browser today</a> or
        <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a>
        to better experience this site.
      </p>
    <![endif]-->

	<div class='container' id='container'> <!-- ## grid -->
		<header id='header'>
    <?php
      // prepare variables for template
      set_query_var('lc_toplevel_ancestor', $toplevel_ancestor);
      set_query_var('lc_level1nav', $level1nav);
      set_query_var('lc_level2nav', $level2nav);
      // include site-specific header fragment
      if(lc_data('x-site-id') === 'ec2012') {
        locate_template('templates/header/header-ec2012.php', true, true);
      } else {
        locate_template('templates/header/header-default.php', true, true);
      }
    ?>
	  </header><!-- #header -->

	<div id="main" class="row">
