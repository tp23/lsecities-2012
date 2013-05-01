			<div class='row'>
				
          <?php if($_GET["siteid"] == 'ec2012'): ?>
          <a href="/">
            <div class='threecol' id='lclogo'>
              <img src="<?php bloginfo('stylesheet_directory'); ?>/images/logos/logo_lsecities_full_white.png" alt="LSE Cities logo">
            </div>
          </a>
          <?php elseif(lc_data('site-labs')): ?>
          <a href="/eumm/">
            <div class='sixcol' id='labs-logo'>
              <img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo_eumm.png" alt="European Metromonitor">
            </div>
          </a>
          <?php else: ?>
          <a href="/">
            <div class='threecol' id='lclogo'>
              <img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo_lsecities_fullred.png" alt="LSE Cities logo">
            </div>
          </a>
          <?php endif; // ($_GET["siteid"] == 'ec2012') ?>
        <?php
          if(lc_data('urban_age_section')): 
            if($_GET["siteid"] == 'ec2012'): ?>
              <a href="/ua/">
                <div class='threecol' id='ualogo'><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logos/logo_urbanage_nostrapline_white.png" alt="Urban Age logo"></div>
              </a>
            <?php else: ?>
              <a href="/ua/">
                <div class='threecol' id='ualogo'><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo_urbanage_nostrapline.gif" alt="Urban Age logo"></div>
              </a>
        <?php
          endif; // ($_GET["siteid"] == 'ec2012') ?>
        <?php elseif(lc_data('site-labs')): ?>
				<?php else: ?>
        <span class='threecol'>&nbsp;</span>
        <?php endif; // (lc_data('urban_age_section')) ?>
				<div class='sixcol last' id='toolbox'>
					<div id="searchbox" class="clearfix">
						<form method="get" id="search-box" action="http://www.google.com/search">
							<div class="hiddenFields">
								<input type="hidden" value="lsecities.net" name="domains" />
								<input type="hidden" value="lsecities.net" name="sitesearch" />
								<div id="queryfield">
									<input type="text" placeholder="Search LSE Cities" name="q" />
									<button><span>&#xE4A2;</span></button>
								</div>
							</div>
             </form>
						<span id="socialbuttons">
							<ul>
								<li>
									<a title="Follow us on Twitter" href="https://twitter.com/#!/LSECities">
										<img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/mal/icon_twitter-v1lightblue_24x24.png" alt="Follow us on Twitter">
									</a>
								</li>
								<li>
									<a title="Follow us on Facebook" href="https://facebook.com/lsecities">
										<img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/mal/icon_facebook-v2lightblue_24x24.png" alt="Follow us on Facebook">
									</a>
								</li>
								<li>
									<a title="Follow us on YouTube" href="https://youtube.com/urbanage">
										<img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/mal/icon_youtubelightblue_24x24.png" alt="Follow us on YouTube">
									</a>
								</li>
								<li>
									<a title="News feed" href="http://lsecities.net/feed/">
										<img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/mal/icon_rsslightblue_24x24.png" alt="News archive">
									</a>
								</li>
							</ul>
						</span>
					</div>
				</div><!-- #toolbox -->
				<nav id='level1nav'>
					<ul>
					<?php echo $lc_level1nav; ?>
					</ul>
				</nav><!-- #level1nav -->
			</div><!-- row -->
			<div class='row' id='mainmenus'>
				<nav class='twelvecol section-ancestor-<?php echo $lc_toplevel_ancestor ; ?>' id='level2nav'>
					<ul>
					<?php if($lc_toplevel_ancestor and $lc_level2nav): ?>
						<?php echo $lc_level2nav ; ?>
					<?php else: ?>
						<li>&nbsp;</li>
					<?php endif; ?>
					</ul>
				</nav>
			</div><!-- #mainmenus -->
