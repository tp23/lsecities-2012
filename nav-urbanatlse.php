<?php
$TRACE_ENABLED = is_user_logged_in();
$TRACE_PREFIX = 'nav-urbanatlse';
$current_post_id = $post->ID;

$GALLERY_POD_SLUG = 'urban-at-lse-gallery';

$pod = new Pod('gallery', $GALLERY_POD_SLUG);

$gallery = galleria_prepare($pod, 'fullbleed wireframe wait', '');

var_trace(var_export($gallery, true), 'gallery');

if(count($gallery['slides'])) : ?>
<div>
  <?php include('inc/components/galleria.inc.php'); ?>
</div>
<?php endif; ?>
