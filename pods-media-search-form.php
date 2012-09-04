<?php
/**
 * Template Name: Pods - Media Archive search
 * Description: Media Archive search webapp
 *
 * @package LSE Cities 2012
 */
?><?php
$TRACE_ENABLED = is_user_logged_in();
$TRACE_PREFIX = 'pods-media-archive-search';
$pods_toplevel_ancestor = 306;
?><?php get_header(); ?>

<div role="main">
  <?php if ( have_posts() ) : the_post(); endif; ?>
  <div id="post-<?php the_ID(); ?>" <?php post_class('lc-article lc-media-archive-search'); ?>>
    <div class='ninecol' id='contentarea'>
      <div class='top-content'>
        <?php if(count($heading_slides)) : ?>
        <header class='heading-image'>
          <div class='flexslider wireframe'>
            <ul class='slides'>
              <?php foreach($heading_slides as $slide): ?>
              <li><img src='<?php echo $slide; ?>' /></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </header>
        <?php endif; ?>
        
        <article class='wireframe eightcol row'>
          <header class='entry-header'>
            <h1>Search media archive</h1>
          </header>
          <div class='entry-content article-text'>
            <form action='' method='get'>
              <input type='text' name='search' id='query' />
              <input type='submit' value='Search' id='searchbutton' />
            </form>
            
            <div id='searchresults'>
            </div>
          </div>
        </article>
        <aside class='wireframe fourcol last entry-meta' id='keyfacts'>
          &nbsp;
        </aside><!-- #keyfacts -->
      </div><!-- .top-content -->
      <div class='extra-content twelvecol'>
      </div><!-- .extra-content -->
    </div><!-- #contentarea -->
  </div><!-- #post-<?php the_ID(); ?> -->
<script type="text/javascript">
  function runMediaQuery() {
    var query = $('#query').val();
    var datastring = 'search=' + query;
    
    $.ajax(
      {
        type: "GET",
        url: "/media/search",
        data: datastring,
        cache: false,
        success: function(content) {
          $('#searchresults').html(content);
        }
      }
    );
  }
  
  var typewatch = (function(){
    var timer = 0;
    return function(callback, ms){
      clearTimeout (timer);
      timer = setTimeout(callback, ms);
    }  
  })();

  jQuery(document).ready(function($) {
    $('#searchbutton').click(function(e) {
      e.preventDefault();
      runMediaQuery();
    });
    $('#query').keyup(function() {
      typewatch(runMediaQuery(), 500);
    });
  });
</script>
</div><!-- role='main'.row -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
