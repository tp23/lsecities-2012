<?php
$current_page_uri = preg_replace('/\?siteid=.*$/', '', get_current_page_URI());
?>
<div id="share-on-social-media">
  <div class="fivecol">&nbsp;</div>
  <div class="sevencol last">
    <span>Share</span>
    <span>
      <a href="https://www.facebook.com/sharer.php?u=<?php echo $current_page_uri; ?>&t=<?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?>">
        <img alt="Share on Facebook" src="<?php bloginfo('stylesheet_directory') ?>/images/icons/mal/icon_facebook-v2darkblue_24x24.png" />
      </a>
    </span>
    <span>
      <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($current_page_uri); ?>">
        <img alt="Share on Twitter" src="<?php bloginfo('stylesheet_directory') ?>/images/icons/mal/icon_twitter-v1darkblue_24x24.png" />
      </a>
    </span>
    <span>
      <a href="https://plus.google.com/share?url=<?php echo urlencode($current_page_uri); ?>">
        <img alt="Share on Google+" src="<?php bloginfo('stylesheet_directory') ?>/images/icons/mal/icon_googleplusdarkblue_24x24.png" />
      </a>
    </span>
  </div>
</div>
