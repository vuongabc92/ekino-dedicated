<?php global $base_url;
foreach($items as $item){
	if(empty($item['#file']->description)){$item['#file']->description =$item['#file']->filename;}
echo '<li><a href='.file_create_url($item['#file']->uri).' target="_blank">'.$item['#file']->description.'</a></li>';
//echo '<pre>';print_r($item);echo '</pre>';
}
?>
