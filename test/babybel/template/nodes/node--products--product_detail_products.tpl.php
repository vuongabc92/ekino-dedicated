<?php
	$image_path = baybel_get_path('images');
	$color = babybel_common_switch_color_key_to_string($node->field_color[LANGUAGE_NONE][0]['rgb']);

	$title_picture = isset($node->field_picture[LANGUAGE_NONE][0]['title']) ? $node->field_picture[LANGUAGE_NONE][0]['title'] : '';
	$alt_picture = isset($node->field_picture[LANGUAGE_NONE][0]['alt']) ? $node->field_picture[LANGUAGE_NONE][0]['alt'] : '';

	$title_nutritional = isset($node->field_nutritional_table[LANGUAGE_NONE][0]['title']) ? $node->field_nutritional_table[LANGUAGE_NONE][0]['title'] : '';
	$alt_nutritional = isset($node->field_nutritional_table[LANGUAGE_NONE][0]['alt']) ? $node->field_nutritional_table[LANGUAGE_NONE][0]['alt'] : '';
?>
<?php print render($title_prefix); ?>
<?php print render($title_suffix); ?>

<div class="tabs-panel <?php print $color;?>-bgd">

		<?php
			if(isset($node->field_picture[LANGUAGE_NONE][0]['uri'])) {
		?>
		<div class="inner row">
		<div class="col-sm-4 left-panel">
		    <img title="<?php print $title_picture; ?>" src="<?php print image_style_url('285x517',$node->field_picture[LANGUAGE_NONE][0]['uri']); ?>" alt="<?php print $alt_picture; ?>">
		</div>
		<div class="col-sm-8 right-panel">
		    <div class="content">
		        <h3 class="title"><?php print $node->title; ?>*</h3>
		        <?php if(isset($node->field_content[LANGUAGE_NONE][0]['value'])) { ?>
		        <div class="description custom-editor">
		            <?php print $node->field_content[LANGUAGE_NONE][0]['value']; ?>
		        </div>
		        <?php } ?>
		        <?php if(isset($node->field_nutritional_table[LANGUAGE_NONE][0]['uri'])) { ?>
		        <div class="thumb">
		        	<img title="<?php print $title_nutritional; ?>" src="<?php print image_style_url('600x275',$node->field_nutritional_table[LANGUAGE_NONE][0]['uri']); ?>" alt="<?php print $node->title; ?>">
		        </div>
		        <?php } ?>
		    </div>
		</div>
		<!-- .right-panel -->
		<a href="#" title="close" class="btn-panel-close">close</a>
	</div>
    <!-- .inner row -->
		<?php } else { ?>
			<div class="inner">
				<!-- .content -->
			    <div class="content">
			        <h3 class="title"><?php print $node->title; ?>*</h3>
			     	<?php if(isset($node->field_content[LANGUAGE_NONE][0]['value'])) { ?>
			        <div class="description custom-editor">
			            <?php print $node->field_content[LANGUAGE_NONE][0]['value']; ?>
			        </div>
			        <?php } ?>
			        <?php if(isset($node->field_nutritional_table[LANGUAGE_NONE][0]['uri'])) { ?>
			        <div class="thumb text-center">
			        	<img title="<?php print $title_nutritional; ?>" src="<?php print image_style_url('600x275',$node->field_nutritional_table[LANGUAGE_NONE][0]['uri']); ?>" alt="<?php $alt_nutritional; ?>">
			        </div>
			        <?php } ?>
				</div>
				<!-- .content -->
				<a class="btn-panel-close" title="close" href="#">close</a>
			</div>
		<?php } ?>
</div>
<!-- .tabs-panel -->