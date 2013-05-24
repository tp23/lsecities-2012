<?php
/**
 * The main navigation component
 *
 * Routes navigation according to current section or Pods doctype
 *
 * @package LSECities2012
 */
 
$TRACE_PREFIX = 'nav.php -- ';
global $current_post_id;
global $BASE_URI;
global $IN_CONTENT_AREA;
global $post;
$current_post_id = $post->ID;
$IN_CONTENT_AREA = false;
$ancestors = $ancestors_and_self = get_post_ancestors($current_post_id);

var_trace(var_export($ancestors, true), $TRACE_PREFIX . 'ancestors: ');

lc_data('parent_post_id', count($ancestors) > 1 ? array_shift($ancestors) : $current_post_id);

var_trace($current_post_id, $TRACE_PREFIX . 'post ID: ');
var_trace(lc_data('parent_post_id'), $TRACE_PREFIX . 'parent post ID: ');
var_trace(var_export($ancestors, true), $TRACE_PREFIX . 'ancestors: ');
var_trace(var_export($pods_toplevel_ancestor, true), $TRACE_PREFIX . 'pods_toplevel_ancestor: ');
?>

<?php if(!lc_data('site-ec2012')): ?>
<div class="wireframe threecol last" id="navigationarea">

<?php
$nav_generated = false;

// /ua/ (Urban Age frontpage)
if($current_post_id === 94) {
  get_template_part('templates/partials/organizers');
  $nav_generated = true;
}

// /research (the whole Research section) or individual Research project pod items
if($current_post_id === 306 or in_array(306, $ancestors_and_self) or (lc_data('pods_toplevel_ancestor') === 306)) {
  get_template_part('templates/nav/nav', 'research');
  $nav_generated = true;
}

// /publications (the whole Publications section)
if($current_post_id === 309 or in_array(309, $ancestors_and_self)) {
  get_template_part('templates/nav/nav', 'publications');
  $nav_generated = true;
}

if(lc_data('pods_toplevel_ancestor') === 309) {
  get_template_part('templates/nav/nav', 'article');
  $nav_generated = true;
}

// /events (the whole Events section) or individual Event pod items
if($current_post_id === 311 or in_array(311, $ancestors_and_self) or (lc_data('pods_toplevel_ancestor') === 311)) {
  get_template_part('templates/nav/nav', 'events');
  $nav_generated = true;
}

// /ua/award/ or /about/collaboration-opportunities/
if($current_post_id === 489 or in_array(1890, $ancestors_and_self)) {
  get_template_part('templates/nav/nav', 'empty');
  $nav_generated = true;
}

// /ua/conferences/
if(lc_data('nav_show_conferences') or is_array(parent_conference_page($current_post_id))) {
  get_template_part('templates/nav/nav', 'conference');
  $nav_generated = true;
}

// /about/whos-who/
if($current_post_id === 421 or in_array(421, $ancestors_and_self)) {
  // first display navigation for this section
  get_template_part('templates/nav/nav', 'generic');
  
  // and then display in-page navigation
  get_template_part('templates/nav/nav', 'people-list');
  $nav_generated = true;
}

// /urban-at-lse/
if($current_post_id === 3338 or in_array(3338, $ancestors_and_self)) {
  get_template_part('templates/nav/nav', 'urbanatlse');
  $nav_generated = true;
}

if($nav_generated === false) {
  get_template_part('templates/nav/nav', 'generic');
}

// include mailing list subscription template part
get_template_part('templates/nav/nav', 'mailing-list-subscription');
?>
</div>
<?php else: // (!lc_data('site-ec2012')) ?>
<div class="wireframe threecol last" id="navigationarea">
<?php
if(lc_data('pods_toplevel_ancestor') === 309) {
  get_template_part('templates/nav/nav', 'article');
  $nav_generated = true;
} ?>
</div>
<?php endif; // (!lc_data('site-ec2012')) ?>
