<?php
global $post;
$obj = pods_prepare_conference(parent_conference_page($post->ID));

if(count($obj['button_links'])) :
?>
<div id="conferencepagesnav">
  <nav class="conferencemenu">
    <ul>
    <?php foreach($obj['button_links'] as $link) : ?>
      <li>
        <a href="<?php echo $link['guid'] ; ?>" title="<?php echo $link['post_title'] ; ?>">
          <?php echo $link['post_title'] ; ?>
        </a>
      </li>
    <?php endforeach ; ?>
    </ul>
  </nav><!-- .conferencemenu -->
  <nav>
    <dl>
      <dt>Urban Age conferences</dt>
      <dd>
<?php
if(count($obj['conferences_menu_items'])) : ?>
<ul class="citieslist">
<?php foreach($obj['conferences_menu_items'] as $item) : ?>
    <li><a href="<?php echo $item['permalink']; ?>"><?php echo $item['title']; ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif;
?>
      </dd>
    </dl>
  </nav>
</div>
<?php endif; ?>

