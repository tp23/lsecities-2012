                         
        <div>
          <a href="" target="_blank">
            <?php echo $section['thumbnail']; ?>
          </a>
          <div>
            <h1 class="headerTitle">
              <a href="<?php echo $newsletter['permalink'] . '#section' . $section['ID']; ?>" target="_blank">
                <span><?php echo $section['title']; ?></span>
              </a>
            </h1>
            <ul>
              <?php foreach($section['featured_items'] as $item): ?>
              <li>
                <a href="<?php echo $newsletter['permalink'] . '#item' . $item['ID']; ?>" target="_blank"><?php echo $item['toc_title']; ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
