<?php
global $current_post_id, $parent_post_id;
if($current_post_id) {
  $children = wp_list_pages('title_li=&depth=1&child_of='.$parent_post_id.'&echo=0');
  
  // if we are in the labs folder, hide lsecities hostname in links
  /*
  if($current_post_id == 2481 or in_array(2481, get_post_ancestors($current_post_id))) {
    $children = hide_lsecities_page_hierarchy_in_labs_links($children);
  }*/
}
if ($children) : ?>
<nav>
  <dl>
    <dt><?php echo get_the_title($parent_post_id); ?></dt>
    <dd>
      <ul>
      <?php echo $children; ?>
      </ul>
    </dd>
  </dl>
</nav>
<?php else : ?>
&#160;
<?php endif; ?>
