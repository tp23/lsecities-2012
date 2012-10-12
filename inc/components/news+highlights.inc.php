              
              <div class="row">
              <?php if($news_categories): ?>
              <section id='news_area' class="fourcol">
                <header>
                  <h1>News</h1>
                </header>
                <?php $more_news = new WP_Query('posts_per_page=10' . $news_categories); ?>
                <ul>
                <?php
                    while ($more_news->have_posts()) :
                      $more_news->the_post();
                ?>
                  <li><a href="<?php the_permalink(); ?>"><?php the_time('j M'); ?> | <?php the_title() ?></a></li>
                <?php
                    endwhile;
                ?>
                </ul>
              </section><!-- #news_area -->
              <?php endif; ?>
              <?php if(count($linked_events)): ?>
              <section id="linked-events" class="fourcol">
                <header><h1>Events</h1></header>
                <ul>
              <?php
                foreach($linked_events as $event): ?>
                <li>
                  <a href="<?php echo PODS_BASEURI_EVENTS . '/' . $event['slug']; ?>"><?php echo date('j F Y', strtotime($event['date_start'])) . ' | ' . $event['name']; ?></a>
                </li>
              <?php endforeach; // ($events as $event) ?>
                </ul>
              </section><!-- #linked-events -->
              <?php
              endif; // (count($events)) ?>
              <?php if(count($linked_events)): ?>
              <section id="linked-events" class="fourcol last">
                <header><h1>Events</h1></header>
                <ul>
              <?php
                foreach($linked_events as $event): ?>
                <li>
                  <a href="<?php echo PODS_BASEURI_EVENTS . '/' . $event['slug']; ?>"><?php echo date('j F Y', strtotime($event['date_start'])) . ' | ' . $event['name']; ?></a>
                </li>
              <?php endforeach; // ($events as $event) ?>
                </ul>
              </section><!-- #linked-events -->
              <?php
              endif; // (count($events)) ?>
              </div>
