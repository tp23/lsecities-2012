                         
        <div>
          <a href="" target="_blank">
            <?php echo get_the_post_thumbnail($section[0]->ID, array(600,294)); ?>
          </a>
          <div>
            <h1 class="headerTitle">
              <a href="" target="_blank">
                <span><?php echo get_the_title($section[0]->ID); ?></span>
              </a>
            </h1>
            <ul>
              <?php foreach($section[1] as $item): ?>
              <li>
                <a href="#<?php echo $item->ID; ?>" target="_blank"><?php echo get_the_title($item->ID); ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
