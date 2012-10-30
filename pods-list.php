<?php
/**
 * Template Name: Pods - List - index
 * Description: The template used for lists of items
 *
 * @package LSECities2012
 */
?>

<?php
  /* URI: TBD */
  $TRACE_ENABLED = is_user_logged_in();
  $TRACE_PREFIX = 'pods-list';
  
  $pod_slugs = array();
  $lists = array();
  $pod_slugs = get_post_meta($post->ID, 'pod_slug', false);
  var_trace(var_export($pod_slugs, true), 'pod_slugs');
  foreach($pod_slugs as $index => $slug) {
    $this_pod = new Pod('list', $slug);
    
    array_push($lists, array(
      'type' => $this_pod->get_field('pod_type.slug'),
      'title' => $this_pod->get_field('name'),
      'page_id' => $this_pod->get_field('featured_item.ID'),
      'sort_order' => $this_pod->get_field('sort_descending') ? 'DESC' : 'ASC',
      'items' => $this_pod->get_field('list', "menu_order $sort_order")
    ));
  }
  
  $pod_slug = get_post_meta($post->ID, 'pod_slug', true);
  $pod = new Pod('list', $pod_slug);
  $pod_type = $pod->get_field('pod_type.slug');
  var_trace('fetching list Pod with slug: ' . $pod_slug . " and pod_type: " . $pod_type, $TRACE_PREFIX, $TRACE_ENABLED);
  $pod_title = $pod->get_field('name');
  $page_id = $pod->get_field('featured_item.ID');
  var_trace('slug for featured item: ' . get_post_meta($page_id, 'pod_slug', true), $TRACE_PREFIX, $TRACE_ENABLED);
  $pod_featured_item_thumbnail = get_the_post_thumbnail($page_id, array(960,367));
  if(!$pod_featured_item_thumbnail) { $pod_featured_item_thumbnail = '<img src="' . wp_get_attachment_url($pod->get_field('featured_item_image.ID')) . '" />'; }
  $pod_featured_item_permalink = get_permalink($page_id);
  $pod_featured_item_pod = new Pod($pod_type, get_post_meta($pod->get_field('featured_item.ID'), 'pod_slug', true));
  $sort_order = $pod->get_field('sort_descending') ? 'DESC' : 'ASC';
  $pod_list = $pod->get_field('list', "menu_order $sort_order");
?>

<?php get_header(); ?>

<?php
var_trace(var_export($pod_featured_item_permalink, true), $TRACE_PREFIX . ' - featured_item_permalink');
var_trace(var_export($pod_list, true), $TRACE_PREFIX . ' - pod_list');

?>

<div role="main" class="row">

  <header class="entry-header twelvecol last">
		<h1 class="entry-title"><?php echo $pod_title; ?></h1>
  </header><!-- .entry-header -->
  
  <article id="post-<?php the_ID(); ?>" <?php post_class('ninecol'); ?>>
    <div class="entry-content">
    
    <?php if(is_user_logged_in()) : ?>
    <?php var_trace($lists, 'pod lists'); ?>
    <?php foreach($lists as $index => $list): ?>
    <?php if(!empty($list['items'])) : ?>
      <section class="list">
        <h2><?php echo $list['title']; ?></h2>
        <p>
          <ul>
          <?php
            $index = 0;
            foreach($list['items'] as $key => $item) : 
              $item_pod = new Pod($pod_type, get_post_meta($item['ID'], 'pod_slug', true));
          ?>
          <?php if($index % 4 == 0 || $index == 0): ?>
            <div class="twelvecol">
          <?php endif; ?>
            <li class='threecol<?php if((($index + 1) % 4) == 0) : ?> last<?php endif ; ?>'>
              <a href="<?php echo get_permalink($item['ID']); ?>">
                <img src="<?php echo wp_get_attachment_url($item_pod->get_field('snapshot.ID')); ?>" />
              </a>
              <p>
                <a href="<?php echo get_permalink($item['ID']); ?>">
                  <?php echo $item_pod->get_field('name'); ?>
                </a>
              </p>
            </li>
          <?php if(($index + 1) % 4 == 0): ?>
            </div>
          <?php endif;
            $index++;
            endforeach; ?>
          </ul>
        </p>
      </section><!-- .list -->
    <?php endif; // (!empty($list['items'])) ?>
    <?php endforeach; // ($lists as $key => $list) ?>
      
    <?php else: ?>
    
    <?php if(!empty($pod_list)) : ?>
      <div class="list">
        <ul>
        <?php
          $index = 0;
          foreach($pod_list as $key => $item) : 
            $item_pod = new Pod($pod_type, get_post_meta($item['ID'], 'pod_slug', true));
        ?>
        <?php if($index % 4 == 0 || $index == 0): ?>
          <div class="twelvecol">
        <?php endif; ?>
          <li class='threecol<?php if((($index + 1) % 4) == 0) : ?> last<?php endif ; ?>'>
            <a href="<?php echo get_permalink($item['ID']); ?>">
              <img src="<?php echo wp_get_attachment_url($item_pod->get_field('snapshot.ID')); ?>" />
            </a>
            <p>
              <a href="<?php echo get_permalink($item['ID']); ?>">
                <?php echo $item_pod->get_field('name'); ?>
              </a>
            </p>
          </li>
        <?php if(($index + 1) % 4 == 0): ?>
          </div>
        <?php endif;
          $index++;
          endforeach; ?>
        </ul>
      </div><!-- .list -->
    <?php endif; // (!empty($pod_list)) ?>
    <?php endif; // (is_user_logged_in()) ?>
        
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->

<?php get_template_part('nav'); ?>

</div><!-- .main.row -->


<?php get_sidebar(); ?>

<?php get_footer(); ?>
