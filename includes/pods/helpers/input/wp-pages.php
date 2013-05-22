<?php
if(!empty($value)) {
  $pages = array();
  
  foreach($value as $key => $val) {
    // check to see if this row is selected
    $active = empty($val['active']) ? '' : 'active';
    $full_page_name = $val['name'];

    // get parent name
    $ancestors = get_ancestors($val['id'], 'page');
    foreach($ancestors as $ancestor) {
      $full_page_name =  get_the_title($ancestor) . ' » ' . $full_page_name;
    }

    array_push($pages, array('id' => $val['id'], 'active' => $active, 'name' => $full_page_name));
  }
  
  /* sort list of WP Pages by hierarchy */
  foreach($pages as $p_key => $p_val) {
    $page_name[$p_key] = $p_val['name'];
  }
  array_multisort($page_name, SORT_ASC, $pages);
}
?>
<?php if($field['multiple']) : ?>

<div id="<?php echo $css_id; ?>" class="form pick <?php echo $name; ?> pods_field pods_field_<?php echo $name; ?> pods_coltype_pick">
<?php foreach($pages as $page) : ?>
  <div data-value="<?php echo $page['id']; ?>" class="option<?php if($page['active']) { ?> active<?php } ?>"><?php echo $page['name']; ?></div>
<?php endforeach; ?>
</div>

<?php else : ?>

<select name="<?php echo $name; ?>" class="form pick1 <?php echo $name; ?> pods_field pods_field_<?php echo $name; ?> pods_coltype_pick" id="<?php echo $css_id; ?>">
  <option value="">-- Select one --</option>
<?php foreach($pages as $page) : ?>
  <option value="<?php echo $page['id']; ?>"<?php if($page['active']) { ?> selected=""<?php } ?>><?php echo $page['name']; ?></option>
<?php endforeach; ?>



</select>
<?php endif; ?>