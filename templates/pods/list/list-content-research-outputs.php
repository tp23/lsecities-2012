<section class="list">
  <?php if(count($obj['lists']) > 1) { ?><h2><?php echo $list['title']; ?></h2><?php } ?>
  <ul>
  <?php
    foreach($list['items'] as $item): ?>
      <li>
        <?php if($item['uri']): ?><a href="<?php echo $item['uri']; ?>"><?php endif; ?>
        <?php echo $item['citation']; ?>
        <?php if($item['uri']): ?></a><?php endif; ?>
      </li>
    <?php
      endforeach; // ($list['items'] as $item)
    ?>
  </ul>
</section><!-- .list -->
