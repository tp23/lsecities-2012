<?php
$TRACE_ENABLED = is_user_logged_in();
$TRACE_PREFIX = 'nav-conferences';

global $post;
$conference_page = parent_conference($post->ID);
var_trace(var_export($conference_page, true), 'CONFERENCE_PAGE'); 
$pod_slug = $conference_page['slug'];

$pod = new Pod('conference', $pod_slug);
$button_links = $pod->get_field('links') ? $pod->get_field('links') : array();

if(count($button_links)) {
  // sort by menu_order of linked items
  foreach($button_links as $sort_key => $sort_value) {
    $menu_order[$sort_key] = $sort_value['menu_order'];
  }
  array_multisort($menu_order, SORT_ASC, $button_links);
}

// add the conference homepage itself
array_unshift($button_links, array('post_title' => $pod->get_field('name'), 'guid' => "/ua/conferences/$pod_slug"));

if(count($button_links)) :
?>
<div id="conferencepagesnav">
  <?php if(count($button_links)): ?>
  <nav class="conferencemenu">
    <ul>
    <?php foreach($button_links as $key => $link) : ?>
      <li>
        <a href="<?php echo $link['guid'] ; ?>" title="<?php echo $link['post_title'] ; ?>">
          <?php echo $link['post_title'] ; ?>
        </a>
      </li>
    <?php endforeach ; ?>
    </ul>
  </nav><!-- .conferencemenu -->
  <?php endif; ?>
  <nav>
    <dl>
      <dt>Urban Age conferences</dt>
      <dd>
<?php
$conference_list = new Pod('list', 'urban-age-conferences');
$pod_type = $conference_list->get_field('pod_type.slug');
$pod_list = $conference_list->get_field('list_pages', 'menu_order DESC');

if(count($pod_list)) : ?>
<ul class="citieslist">
<?php foreach($pod_list as $key => $item) :
    $item_pod = new Pod($pod_type, get_post_meta($item['ID'], 'pod_slug', true)); ?>
    <li><a href="<?php echo get_permalink($item['ID']); ?>"><?php if($item_pod->get_field('conference_title') and $item_pod->get_field('show_title_in_navigation')) { echo $item_pod->get_field('conference_title') . '<br/>'; }?><?php echo $item_pod->get_field('city') . ' | ' . $item_pod->get_field('year'); ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif;
?>
      </dd>
    </dl>
  </nav>
</div>
<?php endif; ?>

