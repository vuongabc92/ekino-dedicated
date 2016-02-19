<?php global $base_url;
?>
<ul>
<?php
foreach($items as $item){
	if(isset($item['#href'])){
echo '<li><a href='.$base_url.'/'.$item['#href'].' target="_blank">'.$item['#title'].'</a></li>';
	}
}
?>
</ul>