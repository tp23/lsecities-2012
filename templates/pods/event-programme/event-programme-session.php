<?php namespace LSECitiesWPTheme\event_programme; ?>
<section id='<?php echo $session['id']; ?>' class='<?php echo $session['type']; ?>'>
<?php if($session['title'] and !$session['hide_title']): ?>
  <header><h1>
    <?php if($session['show_times']): ?>
    <span><?php echo $session['start_datetime']; ?></span> <?php if(!is_null($session['end_datetime'])): ?>&#8212;<span> <?php echo $session['end_datetime']; ?></span><?php endif; ?>
    <?php endif; ?>
    <?php echo $session['title']; ?>
  </h1></header>
<?php endif; ?>
<?php if($session['subtitle'] and !$session['hide_title']): ?>
<h3><?php echo $session['subtitle']; ?></h3>
<?php endif; ?>
<?php if($session['blurb']): ?>
<p><?php echo $session['blurb']; ?></p>
<?php endif; ?>

<?php if($session['chairs_blurb']): ?>
<dl class='session-chairs'>
  <dt><?php echo $session['chairs_label']; ?></dt>
  <dd><?php echo $session['chairs_blurb']; ?></dd>
</dl>
<?php endif; ?>
<?php if($session['respondents_blurb']): ?>
<dl class='session-respondents'>
  <dt><?php echo $session['respondents_label']; ?></dt>
  <dd><?php echo $session['respondents_blurb']; ?></dd>
</dl>
<?php endif; ?>
<?php if($session['speakers_blurb']): ?>
<div>
  <?php echo $session['speakers_blurb']; ?>
</div>
<?php endif; ?>
<?php if($session['youtube_video'] or $session['slides']): ?>
  <ul class="mediaitems">
  <?php if($session['youtube_video']): ?>
    <li class='link video'><a class='watchvideo onyoutube' href='http://youtube.com/watch?v=<?php echo $session['youtube_video']; ?>'>Watch video</a></li>
  <?php endif; ?>
  <?php if($session['slides']): ?>
    <li class='link slides'><a class='downloadthis pdf' href='<?php echo $session['slides']; ?>'>Browse slides</a></li>
  <?php endif; ?>
  </ul>
<?php endif; ?>
<?php
  process_session_templates($session['sessions']);
?>    
</section><!-- #<?php echo $session['id']; ?> -->
