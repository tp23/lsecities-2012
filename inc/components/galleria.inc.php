<?php if(count($gallery['slides'])): ?>
<div class="lc-galleria" id="lc-galleria-<?php echo $gallery['slug']?>">
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
