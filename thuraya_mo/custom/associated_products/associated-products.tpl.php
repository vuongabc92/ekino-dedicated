<?php 
if(!empty($products)){?>
      <div class="carousel-list">
        <div class="carousel-header"><span class="hline"> <h2>Associated Products</h2></span> </div>
          <div class="carousel-slide">
            <ul id="foo2">
             <?php 
			 
			 foreach ($products as $product) {
                     $node = node_load($product);
                     $image = field_get_items('node', $node, 'field_product_image');
 	                 print '<li>';
					 print '<div class="hover-div">';
					 print '<div class="prod-img">';
                     print "<span class='product_1'>";
                     if(!empty($image)){
                       foreach ($image as $key=>$value) {
                         $output = field_view_value('node', $node, 'field_product_image', $image[$key],array(
									  'type' => 'image',
									  'settings' => array(
										'image_style' => 'thumbnail', 
										'image_link' => 'content',
									  ),
                                   ));
                         print render($output);
						break;
                       }   
                      }
				print '</span>';
				print "<div class='prod_title'>";
				print $node->title;
				print "</div>";
				print "</div>";
				
				print '<div class="info-div">';
				if($node->body[$node->language][0]["value"] != ""){
					print substr($node->body[$node->language][0]["value"], 0, 100).".....";
				}
				global $base_url;
				print '<div class="r-more"><a href="'.drupal_lookup_path('alias',"node/".$node->nid).'"><span>Read more </span><span class="ui-icon plus"></span></a></div>';
				print "</div>";
				
				print "</div>";
				print '</li>';
            }?>
		
        </ul>
    <div class="clearfix"></div>
    <div style="display:inline-block; ">
		<a id="prev2" class="ui-icon prev" href="#">&lt;</a>
		<div id="pager2" class="pager"></div>
		<a id="next2" class="ui-icon next" href="#">&gt;</a>
	</div>
</div>
</div>
<?php } ?>

