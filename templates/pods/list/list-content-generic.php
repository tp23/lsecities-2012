<section class="list by-four">
  <?php if(count($obj['lists']) > 1) { ?><h2><?php echo $list['title']; ?></h2><?php } ?>
  <ul>
  <?php
    foreach($list['items'] as $item):
    ?>
    <li class='threecol'>
      <a href="<?php echo $item['permalink']; ?>">
        <img src="<?php echo $item['pod_featured_image_uri']; ?>" />
      </a>
      <p>
        <a href="<?php echo $item['permalink']; ?>">
          <?php echo $item['title']; ?>
        </a>
      </p>
    </li><!-- .treecol -->
  <?php 
    endforeach; // ($list['items'] as $item)
    ?>
  </ul>
</section><!-- .list -->
