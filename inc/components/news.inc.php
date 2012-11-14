              <?php if($news_categories): ?>
              <section id='news-area'>
                <header>
                  <h1><?php if($news_prefix) { echo $news_prefix . '  | '; } ?>News</h1>
                </header>
                <div class='clearfix row'>
                  <?php $latest_news = new WP_Query('posts_per_page=3' . $news_categories);
                    while ($latest_news->have_posts()) :
                      $latest_news->the_post();
                      $do_not_duplicate = $post->ID;
                      if($latest_news->current_post == 2) { $class_extra = " last"; }
                    ?>
                  <div class='fourcol<?php echo $class_extra; ?>'>
                    <div class="feature-info">
                      <div class="feature-date">
                        <div class="month"><?php the_time('M'); ?></div>
                        <div class="day"><?php the_time('j'); ?></div>
                      </div>
                      <header>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                      </header>
                    </div>
                    <?php the_excerpt(); ?>
                  </div>
                  <?php endwhile;
                    wp_reset_postdata();
                  ?>
                </div><!--.clearfix.row -->
                <?php $more_news = new WP_Query('posts_per_page=10' . $news_categories);
                  if($more_news->found_posts > 3) :
                ?>
                <ul>
                <?php
                    while ($more_news->have_posts()) :
                      $more_news->the_post();
                      if ($more_news->current_post > 2) :
                ?>
                  <li><a href="<?php the_permalink(); ?>"><?php the_time('j M'); ?> | <?php the_title() ?></a></li>
                <?php endif;
                    endwhile;
                ?>
                </ul>
                <?php
                  endif;
                ?>
              </section><!-- #news_area -->
              <?php endif; ?>
