<?php
/**
 * Template Name: Pods - Media Archive search
 * Description: Media Archive search webapp
 *
 * @package LSECities2012
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
            <p>
              <form action='' method='get'>
                <input type='text' name='search' id='query' />
                <input type='submit' value='Search' id='searchbutton' />
              </form>
            </p>
            
            <h2>Search results</h2>
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
<script src="https://raw.github.com/janl/mustache.js/master/mustache.js"></script>
<script type="text/javascript">
  // tests: http://jsfiddle.net/xswVa/1/
  $ = jQuery;
  
  var mTemplate = '<ul>\
  {{#items}}\
    <li><a href="https://youtu.be/{{youtube_uri}}">{{title}}</a></li>\
  {{/items}}\
  </ul>\
  {{^items}}\
    <p>No media items match your query.</p>\
  {{/items}}';
  
  function runMediaQuery() {
    var query = $('#query').val();

    if(query.length) {
      var datastring = 'search=' + query;
      
      $.ajax(
        {
          type: "GET",
          url: "/media/search",
          data: datastring,
          dataType: "json",
          cache: false,
          success: function(content, status) {
        <?php if(is_user_logged_in()): ?>
            console.log('ajax status: ' + status + "\nsearch results: " + content);
        <?php endif; ?>
            $('#searchresults').html(Mustache.render(mTemplate, content));
          }
        }
      );
    } else {
      $('#searchresults').html(Mustache.render(mTemplate, ''));
    }
  }
  
  var typewatch = (function(){
    var timer = 0;
    return function(callback, ms){
      clearTimeout (timer);
      timer = setTimeout(callback, ms);
    }  
  })();

  jQuery(document).ready(function($) {
    $('#searchresults').html(Mustache.render(mTemplate, ''));
    $('#searchbutton').click(function(e) {
      e.preventDefault();
      runMediaQuery();
    });
    $('#query').keyup(function() {
      typewatch(runMediaQuery, 500);
    });
  });
</script>
</div><!-- role='main'.row -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
