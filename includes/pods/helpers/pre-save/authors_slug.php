<?php
$name = $columns['name']['value'];
$family_name = $columns['family_name']['value'];
$slug = $columns['slug']['value'];
 
if(empty($slug)) {
        $columns['slug']['value'] = sanitize_title("$family_name - $name");
}
?>
