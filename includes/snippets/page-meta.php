<?php if(is_user_logged_in()):
  $media_attributions = lc_data('META_media_attr'); ?>
<div id="hiddenmeta" style="display: none;">
  <?php if(lc_data('META_last_modified')): ?>
  <span class="updated" title="<?php echo lc_data('META_last_modified'); ?>">Last modified: <?php echo lc_data('META_last_modified'); ?></span>
  <?php endif; ?>
  <?php if(count($media_attributions)): ?>
    <h4>Media sources</h4>
    <ul>
  <?php
    foreach($media_attributions as $key => $item):
      if($item['attribution_uri'] and $item['author']): ?>
    <li><a href="<?php echo $item['attribution_uri']; ?>"><?php echo $item['title']; ?></a> by <?php echo $item['author']; ?></li>
  <?php
      endif;
    endforeach; ?>
    </ul>
  <?php
  endif;
  ?>
</div>
<?php endif; ?>
