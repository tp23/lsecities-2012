<?php
/**
 * Template Name: Pods - Media Archive search (dev)
 * Description: Media Archive search webapp (dev)
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
        
        <article class="wireframe">
                <section class="clearfix queryarea">
                  <header class="entry-header fourcol">
                    <h1 class="entry-title article-title">Media archive</h1>
                    <h2>Search</h2>
                  </header>
                  <div class="eightcol last">
                    <form method="get" action="">
                      <div class="fourcol">
                        <h3>Format</h3>
                        <ul>
                          <li>
                            <label>
                              <input type="checkbox" value="lecture" disabled="disabled">lecture
                            </label>
                          </li>
                          <li>
                            <label>
                              <input type="checkbox" value="talk" disabled="disabled">talk
                            </label>
                          </li>
                          <li>
                            <label>
                              <input type="checkbox" value="conference-session" disabled="disabled">conference session
                            </label>
                          </li>
                        </ul>
                      </div>
                      <div class="fourcol">
                        <h3>Media</h3>
                        <ul>
                          <li>
                            <label>
                              <input type="checkbox" value="audio" disabled="disabled">audio
                            </label>
                          </li>
                          <li>
                            <label>
                              <input type="checkbox" value="video" disabled="disabled">video
                            </label>
                          </li>
                        </ul>
                      </div>
                      <input type="text" placeholder="free text search: enter keywords here" name="search" id="query" class="tencol last">
                    </form>
                  </div>
                </section>
                <section class="clearfix">
                  <div class="resultsarea">
                    <h2>Search results</h2>
                    <div id="searchresults"></div>
                  </div>
                </section>
              </article>
              
              
        <aside class='wireframe fourcol last entry-meta' id='keyfacts'>
          &nbsp;
        </aside><!-- #keyfacts -->
      </div><!-- .top-content -->
      <div class='extra-content twelvecol'>
      </div><!-- .extra-content -->
    </div><!-- #contentarea -->
  </div><!-- #post-<?php the_ID(); ?> -->
<?php wp_enqueue_script('mustachejs', get_stylesheet_directory_uri() . '/javascripts/mustache.min.js', array(), '0.7.0', true); ?>
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
