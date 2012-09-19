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

$projects_pod = new Pod('research_project');

$current_projects_list = array();
$projects_pod->findRecords(array(
  'where' => 'status.name = "active"'
));
$current_projects = array();
while($projects_pod->fetchRecord()) {
  array_push($current_projects_list, array(
    'slug' => $projects_pod->get_field('slug'),
    'name' => $projects_pod->get_field('name'),
    'strand' => $projects_pod->get_field('research_strand.name')
  ));
  $current_projects[$projects_pod->get_field('research_strand.name')] = array();
}

var_trace('projects: ' . var_export($current_projects_list, true), $TRACE_PREFIX, $TRACE_ENABLED);

foreach($current_projects_list as $project) {
  $key = $project['strand'];
  array_push($current_projects[$key], $project);
}

var_trace('projects (by strand): ' . var_export($current_projects, true), $TRACE_PREFIX, $TRACE_ENABLED);

$past_projects_list = array();
$projects_pod->findRecords(array(
  'where' => 'status.name = "completed"'
));
$past_projects = array();
while($projects_pod->fetchRecord()) {
  array_push($past_projects_list, array(
    'slug' => $projects_pod->get_field('slug'),
    'name' => $projects_pod->get_field('name'),
    'strand' => $projects_pod->get_field('research_strand.name')
  ));
  $past_projects[$projects_pod->get_field('research_strand.name')] = array();
}

var_trace('projects: ' . var_export($current_projects, true), $TRACE_PREFIX, $TRACE_ENABLED);

foreach($past_projects_list as $project) {
  $key = $project['strand'];
  array_push($past_projects[$key], $project);
}

var_trace('past projects (by strand): ' . var_export($projects, true), $TRACE_PREFIX, $TRACE_ENABLED);
?>
  <?php if(($IN_CONTENT_AREA and !$HIDE_CURRENT_PROJECTS) or (!$IN_CONTENT_AREA and $HIDE_CURRENT_PROJECTS)): ?>
  <nav id="projectsmenu">
    <div id="current-projects">
      <?php if(!$IN_CONTENT_AREA): ?><h1>Current research</h1><?php endif; ?>
      <dl>
      <?php foreach($current_projects as $strand_name => $strand_projects): ?>
        <dt><?php echo $strand_name; ?></dt>
        <?php foreach($strand_projects as $strand_project): ?>
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
      <?php foreach($past_projects as $strand_name => $strand_projects): ?>
        <dt><?php echo $strand_name; ?></dt>
        <?php foreach($strand_projects as $strand_project): ?>
        <dd><a href="<?php echo $BASE_URI . '/' . $strand_project['slug']; ?>"><?php echo $strand_project['name']; ?></a></dd>
        <?php endforeach; ?>
      <?php endforeach; ?>
      </dl>
    </div>
  </nav> <!-- #projectsmenu -->
  <?php endif; ?>
</nav>
