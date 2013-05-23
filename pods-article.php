<?php
/**
 * Template Name: Pods - Articles
 * Description: The template used for Article Pods
 *
 * @package LSECities2012
 */
$TRACE_ENABLED = is_user_logged_in();

$article_data = pods_prepare_article($post->ID);

/**
 * Copy gallery object to own variable for compatibility with
 * gallery snippet.
 */
$gallery = $obj['gallery'];

?><?php get_header(); ?>

<div role="main">

<?php if ( have_posts() ) : the_post(); endif; ?>

<div id="post-<?php the_ID(); ?>" class='lc-article lc-newspaper-article'>

          <div class='ninecol' id='contentarea'>
            <div class='top-content'>
              <?php if($obj['featured_image_uri']): ?>
              <header class="heading-image">
                <div class='photospread wireframe'>
                  <img src="<?php echo $obj['featured_image_uri']; ?>" alt="" />
                </div>
              </header>
              <?php endif; ?>
              <article class='wireframe eightcol'>
                <header class="entry-header">
                  <h1 class="entry-title article-title"><?php echo $obj['article_title']; ?></h1>
                  <?php if($obj['article_subtitle']): ?>
                  <h2><?php echo $obj['article_subtitle']; ?></h2>
                  <?php endif; ?>
                  <?php if($obj['article_abstract']): ?>
                  <div class="entry-meta article-abstract"><?php echo $obj['article_abstract']; ?></div>
                  <?php endif; ?>
                </header><!-- .entry-header -->
                <div class="entry-content">    
                <?php if(!empty($pod->data)): ?>
                  <div class="article">
                    <div class="entry-content article-text<?php if($obj['article_layout']) { echo ' ' . $obj['article_layout']; } ?>">
                    <?php if($obj['article_text']): ?>
                      <?php echo $obj['article_text']; ?>
                    <?php elseif($obj['article_summary']): ?>
                      <?php echo $obj['article_summary']; ?>
                    <?php endif; ?>
                    </div>
                    <?php include('includes/components/galleria.inc.php'); ?>
                    <?php if($obj['article_extra_content']): ?>
                    <div class="extra-content"><?php echo $obj['article_extra_content']; ?></div>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
                    
                <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
                </div><!-- .entry-content -->
              </article>
  
  


              <aside class='wireframe fourcol last minorfacts' id='keyfacts'>
                <div>
                  <dl>
                  <?php if(is_array($obj['article_authors'])): ?>
                    <dt>Authors</dt>
                    <dd>
                      <ul>
                      <?php foreach($obj['article_authors'] as $author): ?>
                        <li><?php echo $author['name'] ?> <?php echo $author['family_name'] ?></li>
                      <?php endforeach; ?>
                      </ul>
                    </dd>
                  <?php endif; ?>
                    <?php if($obj['article_publishing_date']): ?>
                    <dt>Publication date</dt>
                    <dd><?php echo $obj['article_publishing_date'] ?></dd>
                    <?php endif; ?>
                    <?php if(is_array($obj['article_tags'])): ?>
                    <dt>Tags</dt>
                    <dd>
                      <ul>
                        <?php foreach($obj['article_tags'] as $tag): ?>
                          <li><?php echo $tag['name'] ; ?></li>
                        <?php endforeach; ?>
                      </ul>
                    </dd>
                    <?php endif; ?>
                  </dl>
                  <?php if($obj['pdf_uri'] or is_array($obj['attachments'])) : ?>
                  <div class="downloads-area">
                    <ul>
                    <?php if($obj['pdf_uri']): ?>
                    <li>
                      <a class='downloadthis pdf button' href="<?php echo $obj['pdf_uri']; ?>">Download this article as PDF</a>
                    </li>
                    <?php endif; ?>
                    <?php
                      if(is_array($obj['attachments'])) :
                        foreach($obj['attachments'] as $attachment) :?>
                        <li><a class='downloadthis pdf button' href="<?php echo wp_get_attachment_url($attachment['ID']); ?>" /><?php echo $attachment['post_title']; ?></a></li>
                    <?php
                        endforeach;
                      endif; ?>
                    </ul>
                  </div>
                  <?php endif; ?>           
  
                  <?php get_template_part('snippet-socialmedia-share'); ?>
                  <div class="media-items">
                    
                  </div>
                </div>
              </aside><!-- #keyfacts -->
            </div><!-- .top-content -->
          </div><!-- #contentarea -->

          <?php get_template_part('nav'); ?>
          </div><!-- #navigationarea -->
          
</div><!-- #post-<?php the_ID(); ?> -->

</div><!-- role="main" -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
