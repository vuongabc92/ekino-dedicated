<?php global $base_url;?>
<ul>
<?php
foreach($items as $item){
							$sol_url = drupal_lookup_path('alias',$item['#href']);

echo '<li><a href='.$base_url.'/'.$sol_url.'>'.$item['#title'].'</a></li>';
}
?>
</ul>