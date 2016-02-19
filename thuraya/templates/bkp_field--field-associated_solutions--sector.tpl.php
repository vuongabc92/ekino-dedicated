<?php
global $base_url;
//echo '<pre>';print_r($items);echo '</pre>';
foreach($items as $item){
//print_r($item);
echo '<div class="col1">'.$item['#title'].'</div>';
echo '<div class="col2"><a class="ui-icon plus" href='.$base_url.'/'.$item["#href"].'>'.$item['#title'].'</a></div>';
}
//drupal_render($items);
?>