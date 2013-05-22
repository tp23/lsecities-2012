<?php
/**
 * Pods input helper: tile
 *
 * Used to display lists of available tiles when building slides
 */

$PODS_BASEURI_NEW_ITEM = '/wp-admin/admin.php?page=';
?>
<script>
// let ddslick dropdowns at bottom of page display in full
jQuery(function($) { $('.pods_form').css({overflow: 'visible'}); });
</script>

<div id="<?php echo $css_id; ?>_container">
<select name="<?php echo $name; ?>" id="pods_form1_<?php echo $name; ?>" class="form pick1 <?php echo $name; ?> pods_field pods_field_<?php echo $name; ?> pods_coltype_pick">
  <option value="">-- Select one --</option>
  <?php if ( !empty( $value ) ) : ?>

    <?php foreach ($value as $key => $val) : ?>
      <?php
        // check to see if this is the chosen value
        $active = $val['active'] === true ? ' active' : false;
        if($val['active'] === true) { var_trace(var_export($val, true)); }
        $tile_pod = new Pod('tile', $val['slug']);

        $tile_title = $val['name'];
        $tile_layout = $tile_pod->get_field('tile_layout.name');
        $description = $tile_title . ' (' . $tile_layout . ')';
        $tile_image_src = wp_get_attachment_image_src( $tile_pod->get_field('image.ID'), array(32,32), false);
      ?>
      <option value="<?php echo $val['id']; ?>" class="option<?php echo $active ?>" data-description="<?php echo $description; ?>"<?php if($tile_image_src) { echo ' data-imagesrc="' . $tile_image_src[0] . '"'; }  if($active) { echo ' selected="selected"'; }?>><?php echo $description; ?></div>
    <?php endforeach; ?>
  <?php endif; ?>
</select>
</div>
<script>
jQuery(function($) {
  $('#pods_form1_<?php echo $name; ?>').ddslick({
    width: '100%',
    selectText: 'Select a tile...',
    onSelected: function(data){
        //$('[name="<?php echo $name; ?>"]').val(selectedData.selectedIndex);
        console.log(this.id + ': ' + data.selectedData.value);
    }   
});
});
</script>
