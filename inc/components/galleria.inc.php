<?php
  $gallery_id = 'lc-galleria-'. $gallery['slug'];
  $gallery_class = $gallery['picasa_gallery_id'] ? 'lc-galleria-picasa' : 'lc-galleria';
  $gallery_class .= $gallery['extra_classes'] ? ' ' . $gallery['extra_classes'] : ''; 
?>
<?php if($gallery['picasa_gallery_id']): ?>
  <div class="<?php echo $gallery_class; ?>" id="<?php echo $gallery_id; ?>"></div>
  <script type="text/javascript">
    jQuery(document).ready(function() {
      jQuery('#<?php echo $gallery_id; ?>').setOptions({
        picasa: 'useralbum:<?php echo $gallery['picasa_gallery_id']; ?>',
        picasaOptions: {
          sort: 'date-posted-asc'
        }
      }).refreshImage();
    });
  </script>
<?php else: ?>
  <?php if(count($gallery['slides'])): ?>
  <div class="<?php echo $gallery_class; ?>" id="<?php echo $gallery_id; ?>">
    <ul>
  <?php foreach($gallery['slides'] as $slide): ?>
    <li>
    <a href="<?php echo wp_get_attachment_url($slide->ID); ?>">
      <img title="<?php echo $slide->post_title; ?>"
        src="<?php echo wp_get_attachment_url($slide->ID); ?>"
        alt="<?php echo get_post_meta($slide->ID, '_wp_attachment_image_alt', true) ? get_post_meta($slide->ID, '_wp_attachment_image_alt', true) : $slide->post_title; ?>"
        data-title="<?php echo $slide->post_title; ?>" 
        data-description="<?php echo $slide->post_excerpt; ?>" />
    </a>
    </li>
  <?php endforeach; ?>
    </ul>
  </div>
  <?php endif; ?>
<?php endif; ?>
