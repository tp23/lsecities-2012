<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package LSECities2012
 */
?>
    <div class="reset-layout">&#160;</div>
	</div><!-- #main -->
</div><!-- #page -->
	<footer id="footer">
    <nav id="footerSitemap">
      <div class="row">
        <div class="onecol">&nbsp;</div>
        <div class="twocol">
          <h1>About</h1>
          <ul>
            <?php wp_list_pages('title_li=&depth=1&child_of=617&sort_column=menu_order&sort_order=ASC&echo=1'); ?>
          </ul>
          <h1>Who's who</h1>
          <ul>
            <?php wp_list_pages('title_li=&depth=1&child_of=421&sort_column=menu_order&sort_order=ASC&echo=1'); ?>
          </ul>
        </div>
        <div class="twocol">
          <h1>Research</h1>
          <ul>
            <?php wp_list_pages('title_li=&depth=2&child_of=306&sort_column=menu_order&sort_order=ASC&echo=1'); ?>
          </ul>
        </div>
        <div class="twocol">
          <h1>Publications</h1>
          <ul>
            <?php wp_list_pages('title_li=&depth=1&child_of=309&sort_column=menu_order&sort_order=ASC&echo=1'); ?>
          </ul>
          <h1>Events</h1>
          <ul>
            <?php wp_list_pages('title_li=&depth=1&child_of=311&sort_column=menu_order&sort_order=ASC&echo=1'); ?>
          </ul>
        </div>
        <div class="twocol">
          <h1>Urban Age</h1>
          <ul>
            <?php wp_list_pages('title_li=&depth=1&child_of=94&sort_column=menu_order&sort_order=ASC&echo=1'); ?>
          </ul>
          <?php if(lc_data('site-ec2012')): ?>
          <h1>Conferences</h1>
          <ul>
            <?php wp_list_pages('title_li=&depth=1&child_of=96&sort_column=menu_order&sort_order=ASC&echo=1'); ?>
          </ul>          
          <?php endif; // (lc_data('site-ec2012')) ?>
        </div>
        <div class="twocol">
          <?php get_template_part('templates/partials/organizers'); ?>
          <?php get_template_part('templates/partials/colophon'); ?>
        </div>
        <div class="onecol last">&nbsp;</div>
      </div>
    </nav>
  </footer><!-- #footer -->
</div><!-- ## grid # container -->

<?php wp_footer(); ?>

<?php if(!is_user_logged_in()): ?>
<script type="text/javascript">//<![CDATA[
  cookieControl({
      introText:'<p>This site uses some unobtrusive cookies to store information on your computer.</p>',
      fullText:'<p>Some cookies on this site are essential, and the site won\'t work as expected without them. These cookies are set when you submit a form, login or interact with the site by doing something that goes beyond clicking on simple links.</p><p>We also use some non-essential cookies to anonymously track visitors or enhance your experience of the site. If you\'re not happy with this, we won\'t set these cookies but some nice features of the site may be unavailable.</p><p>By using our site you accept the terms of our <a href="http://lsecities.net/info/privacy-policy/">Privacy Policy</a>.</p>',
      position:'right', // left or right
      shape:'triangle', // triangle or diamond
      theme:'light', // light or dark
      startOpen:false,
      autoHide:6000,
      subdomains:false,
      onCookiesNotAllowed:function(){},
      countries:'United Kingdom' // Or supply a list ['United Kingdom', 'Greece']
  });
   //]]>
</script>  
<?php endif; ?>

<script>
      //<![CDATA[
        // jQuery regex filter (http://james.padolsey.com/javascript/regex-selector-for-jquery/)
        jQuery.expr[':'].regex = function(elem, index, match) {
          var matchParams = match[3].split(','),
          validLabels = /^(data|css):/,
          attr = {
            method: matchParams[0].match(validLabels) ? 
                        matchParams[0].split(':')[0] : 'attr',
            property: matchParams.shift().replace(validLabels,'')
          },
          regexFlags = 'ig',
          regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
          return regex.test(jQuery(elem)[attr.method](attr.property));
        };
          
        jQuery(document).ready(function($) {
          // enable Galleria for embedded slideshows
          try {
            if(jQuery('.lc-newspaper-article .lc-galleria').length > 0) {
              jQuery('.lc-newspaper-article .lc-galleria').galleria({responsive: true, height: 0.75, lightbox: true, _toggleInfo: false, preload: 'all', debug: <?php echo is_user_logged_in() ? 'true' : 'false'; ?>});
            }
          } catch(error) { }
          
          // enable Galleria for right-hand-side navbar slideshows
          try {
            if(jQuery('#navigationarea .lc-galleria').length > 0) {
              jQuery('#navigationarea .lc-galleria').galleria({responsive: true, height: 0.75, transition: 'fade', transitionSpeed: 600, carousel: false, thumbnails: false, autoplay: 5000, showInfo: false, preload: 'all', debug: <?php echo is_user_logged_in() ? 'true' : 'false'; ?>});
              jQuery('#navigationarea .lc-galleria.fullbleed .galleria-thumbnails-container').hide();
            }
          } catch(error) { }
          
          // enable Galleria for research pages photo slider
          try {
            if(jQuery('.lc-research-project .lc-galleria, .lc-publication .lc-galleria').length > 0) {
              jQuery('.lc-research-project .lc-galleria, .lc-publication .lc-galleria').galleria({responsive: true, height: 0.4, transition: 'fade', transitionSpeed: 600, carousel: false, thumbnails: false, autoplay: 5000, showInfo: false, preload: 'all', debug: <?php echo is_user_logged_in() ? 'true' : 'false'; ?>});
              jQuery('.lc-research-project .lc-galleria.fullbleed .galleria-thumbnails-container, .lc-publication .lc-galleria .lc-galleria.fullbleed .galleria-thumbnails-container').hide();
            }
          } catch(error) { }
          
          try {
            if(jQuery('.lc-galleria.single .galleria-image-nav')) {
              jQuery('.lc-galleria.single .galleria-image-nav').hide();
            }
          } catch(error) {}
          
          $('.speaker-profile').hover(
            function () {
                $(this).children('.speaker-card').fadeIn();
            },
            function () {
                $(this).children('.speaker-card').fadeOut();
            }
          );
          
          $('.flexslider').flexslider(({
            animation: "slide",
            slideshow: false,
            mousewheel: false,
            controlNav: false,
            directionNav: true,
<?php if(lc_data('slider_jquery_options')) { echo lc_data('slider_jquery_options'); } ?>

          }));
          $('.runon li:nth-child(odd)').addClass('alternate');
          $('.accordion').accordion({autoHeight: false, active: $(this).find('.active')});

          // track clicks to binary files hosted in WordPress.
          // based on http://www.wduffy.co.uk/blog/tracking-google-goals-with-no-url-using-jquery/.
          // uses regex jQuery filter (http://james.padolsey.com/javascript/regex-selector-for-jquery/).
          <?php if(is_user_logged_in()): ?>
          function addGAEventTracker(uri) {
            var re = /^(http:\/\/lsecities\.net)?(.*)$/gi;
            var originalhref = $(this).attr('href');
            var href = originalhref.replace(re, '$2');
            <?php if(is_user_logged_in()): ?>
            console.log("PDF download at URI %s tracked with event label '%s'", originalhref, href);
            <?php endif; ?>            
            _gaq.push(['_trackEvent', 'PDF', 'download', href]);
          }
          $(':regex(href,(http:\/\/lsecities\.net\/)?\/files\/.*.pdf)').click(function() {
            console.log('download');
          });
          $(':regex(href,(http:\/\/lsecities\.net\/)?\/files\/.*)').click(function() {
            var re = /^(http:\/\/lsecities\.net)?(.*\.(.*))$/gi;
            var originalhref = $(this).attr('href');
            var href = originalhref.replace(re, '$2');
            var extension = originalhref.match(/^.*(\..*)$/);
            console.log('Download (type: %s) at URI %s tracked with event label \'%s\'', extension, originalhref, href);
          });
          <?php else: ?>
          
          $(':regex(href,(http:\/\/lsecities\.net\/)?\/files\/.*.pdf)').click(function() {
            var re = /^(http:\/\/lsecities\.net)?(.*)$/gi;
            var originalhref = $(this).attr('href');
            var href = originalhref.replace(re, '$2');
            console.log("PDF download at URI %s tracked with event label '%s'", originalhref, href);
            _gaq.push(['_trackEvent', 'PDF', 'download', href]);
          });
          $(':regex(href,(http:\/\/lsecities\.net\/)?\/files\/.*.xlsx?)').click(function() {
            var re = /^(http:\/\/lsecities\.net)?(.*)$/gi;
            var originalhref = $(this).attr('href');
            var href = originalhref.replace(re, '$2');
            console.log("Excel document download at URI %s tracked with event label '%s'", originalhref, href);
            _gaq.push(['_trackEvent', 'Excel document', 'download', href]);
          });
          $(':regex(href,(http:\/\/lsecities\.net\/)?\/files\/.*.docx?)').click(function() {
            var re = /^(http:\/\/lsecities\.net)?(.*)$/gi;
            var originalhref = $(this).attr('href');
            var href = originalhref.replace(re, '$2');
            console.log("Word document download at URI %s tracked with event label '%s'", originalhref, href);
            _gaq.push(['_trackEvent', 'Word document', 'download', href]);
          });
          <?php endif; ?>
        });
      //]]>
</script>
</body>
</html>
