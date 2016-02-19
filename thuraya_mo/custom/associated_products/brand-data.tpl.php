<?php if(!empty($branddata)){ ?>
<div class="prolist-topcontainer">
	<?php foreach ($branddata as $data) { 
		$node = node_load($data->entity_id);
		//print_r($node);
	?>
	<div class="col1">
		<div class="in-container"><?php print($node->field_brand_video[$node->language][0]["value"]);?></div>
	</div>
	<div class="col2">
		<h1><?php print $node->title; ?></h1>
		<?php print $node->body[$node->language][0]["safe_value"];?>
	</div>
	<?php } ?>
</div>
<?php } ?>