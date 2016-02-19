<?php global $base_url;
foreach($items as $item){
echo '<li><a href='.$base_url.'/'.$item["#href"].' target="_blank">'.$item['#title'].'</a></li>';
}
?>
