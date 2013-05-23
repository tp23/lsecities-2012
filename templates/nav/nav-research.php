<?php
$TRACE_ENABLED = is_user_logged_in();
$TRACE_PREFIX = 'nav-research';
$current_post_id = $post->ID;

global $IN_CONTENT_AREA;
global $HIDE_CURRENT_PROJECTS, $HIDE_PAST_PROJECTS;
$BASE_URI = PODS_BASEURI_RESEARCH_PROJECTS;

var_trace('HIDE_CURRENT_PROJECTS: '. $HIDE_CURRENT_PROJECTS, $TRACE_PREFIX, $TRACE_ENABLED);
var_trace('HIDE_PAST_PROJECTS: '. $HIDE_PAST_PROJECTS, $TRACE_PREFIX, $TRACE_ENABLED);

var_trace('post ID: ' . $current_post_id, $TRACE_PREFIX, $TRACE_ENABLED);
var_trace(var_export($pod, true), $TRACE_PREFIX, $TRACE_ENABLED);


$current_projects_by_strand = compose_project_list_by_strand('active');
var_trace(var_export($current_projects_by_strand, true), $TRACE_PREFIX . ' - active projects (by strand): ', $TRACE_ENABLED);
$past_projects_by_strand = compose_project_list_by_strand('completed');
var_trace(var_export($past_projects_by_strand, true), $TRACE_PREFIX . ' - completed projects (by strand): ', $TRACE_ENABLED);

?>
  <?php if(($IN_CONTENT_AREA and !$HIDE_CURRENT_PROJECTS) or (!$IN_CONTENT_AREA and $HIDE_CURRENT_PROJECTS)): ?>
  <nav id="projectsmenu">
    <div id="current-projects">
      <?php if(!$IN_CONTENT_AREA): ?><h1>Current research</h1><?php endif; ?>
      <dl>
      <?php foreach($current_projects_by_strand as $strand): ?>
        <dt><?php echo $strand['name']; ?></dt>
        <?php foreach($strand['projects'] as $strand_project): ?>
        <dd><a href="<?php echo $BASE_URI . '/' . $strand_project['slug']; ?>"><?php echo $strand_project['name']; ?></a></dd>
        <?php endforeach; ?>
      <?php endforeach; ?>
      </dl>
    </div>
  </nav> <!-- #projectsmenu -->
  <?php endif; ?>
  <?php if(($IN_CONTENT_AREA and !$HIDE_PAST_PROJECTS) or (!$IN_CONTENT_AREA and $HIDE_PAST_PROJECTS)): ?>
  <nav id="projectsmenu">
    <div id="past-projects">
      <?php if(!$IN_CONTENT_AREA): ?><h1>Completed research</h1><?php endif; ?>
      <dl>
      <?php foreach($past_projects_by_strand as $strand): ?>
        <dt><?php echo $strand['name']; ?></dt>
        <?php foreach($strand['projects'] as $strand_project): ?>
        <dd><a href="<?php echo $BASE_URI . '/' . $strand_project['slug']; ?>"><?php echo $strand_project['name']; ?></a></dd>
        <?php endforeach; ?>
      <?php endforeach; ?>
      </dl>
    </div>
  </nav> <!-- #projectsmenu -->
  <?php endif; ?>
</nav>
