<?php
$TRACE_ENABLED = is_user_logged_in();
$TRACE_PREFIX = 'nav.php -- ';
if($people_list):
?>
<?php if(is_user_logged_in()) : ?>
<dl class="in-page-navigation">
  <dt><?php echo get_the_title($post->ID); ?></dt>
  <dd>
<?php endif; ?>
    <nav id="whoswho-side-toc">
    <?php echo $people_list['summary']; ?>
    </nav>
<?php if(is_user_logged_in()) : ?>
  </dd>
</dl>
<?php endif; ?>
<?php endif; ?>
