<?php
$TRACE_ENABLED = is_user_logged_in();
$TRACE_PREFIX = 'nav-urbanatlse';
$current_post_id = $post->ID;

$GALLERY_POD_SLUG = '';

$pod = new Pod('gallery', $GALLERY_POD_SLUG);

$gallery = galleria_prepare($pod, false, 'this');

if(count($gallery['slides'])) : ?>
<div>
  <?php include('inc/components/galleria.inc.php'); ?>
</div>
<?php endif; ?>
