<?php global $base_url;?>
<ul>
<?php
foreach($items as $item){
echo '<li>'.$item['#markup'].'</li>';
}
?>
</ul>