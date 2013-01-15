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



function compose_project_list_by_strand($project_status) {
  // only accept known project statuses
  $known_project_status = new Pod('project_status', $project_status);
  if(!$known_project_status->getTotalRows) {
    error_log('unknown project status requested');
    return;
  }

  // retrieve all projects with requested status
  // TODO: do we want to sort projects by start date?
  // some have an arbitrary start day so this might not work in practice
  $projects_pod = new Pod('research_project');
  $projects_pod->findRecords(array(
    'where' => 'status.name = "' . $project_status . '"'
  ));

  // prepare research strands array
  // we want to display strands in a specific order, using strands' slugs for sorting (NNN-strand-slug)
  // where NNN is e.g. 010, 020, etc. for the first, second, etc. strand respectively
  $research_strands_pod = new Pod('research_strands', array('orderby' => 'slug'));
  
  $projects_list = array();
  $projects = array();
  
  foreach($research_strands_pod->fetchRecord as $research_strand) {
    $projects[$research_strands_pod->get_field('name')] = array();
  }
  
  while($projects_pod->fetchRecord()) {
    $projects[$projects_pod->get_field('research_strand.name')][] = array(
      'slug' => $projects_pod->get_field('slug'),
      'name' => $projects_pod->get_field('name'),
      'strand' => $projects_pod->get_field('research_strand.name'),
      'strand_slug' => $projects_pod->get_field('research_strand.slug')
    );
  }

  var_trace('projects: ' . var_export($projects_list, true), $TRACE_PREFIX, $TRACE_ENABLED);

  var_trace($project_status . ' projects (by strand): ' . var_export($projects, true), $TRACE_PREFIX, $TRACE_ENABLED);

  return $projects;
}

$current_projects = compose_project_list_by_strand('active');
$past_projects = compose_project_list_by_strand('completed');

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
