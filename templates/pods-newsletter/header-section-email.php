                         
        <div>
          <a href="" target="_blank">
            <?php echo get_the_post_thumbnail($section->ID, array(600,294)); ?>
          </a>
          <div>
            <h4 class="h4">
              <a href="" target="_blank">
                <span><?php echo get_the_title($section->ID); ?></span>
              </a>
            </h4>
            <ul>
              <?php foreach($featured_items as $item): ?>
              <li>
                <a href="#<?php echo $item->ID; ?>" target="_blank"><?php echo get_the_title($item->ID); ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
