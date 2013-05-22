<?php $PODS_BASEURI_NEW_ITEM = '/wp-admin/admin.php?page='; ?>

<div id="<?php echo $css_id; ?>" class="form pick <?php echo $name; ?> pods_field pods_field_<?php echo $name; ?> pods_coltype_pick">
  <?php if ( !empty( $value ) ) : ?>

  <?php /* sort list of people by surname */
      foreach($value as $key => $row) {
        $family_name[$key] = $row['family_name'];
      }
      array_multisort($family_name, SORT_ASC, $value);
    ?>

    <?php foreach ($value as $key => $val) : ?>
      <?php
        // check to see if this is the chosen value
        $active = empty($val['active']) ? '' : 'active';

        // check to see if we have a full name
        $full_name = $val['name'];
        if( !empty( $val['family_name'] ) )
        {
          $full_name = $val['family_name'] . ', ' . $full_name;
        }
      ?>
      <div data-value="<?php echo $val['id']; ?>" class="option<?php echo ' ' . $active ?>"><?php echo $full_name; ?></div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<div>
  <p><a target="_blank" href="<?php echo $PODS_BASEURI_NEW_ITEM . 'people' . '&action=add' ; ?>">Add a new person</a></p>
  <p>After adding a new person, save this document and refresh the page in order to see the updated list of people.</p>
</div>
