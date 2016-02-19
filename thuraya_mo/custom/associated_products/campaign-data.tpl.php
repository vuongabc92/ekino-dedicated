<?php if(!empty($campaigndata)){  
$c=1;
?>
<div class="in-container">			
	<ul>
	<?php 
	
	 foreach ($campaigndata as $data) {
                     $node = node_load($data->nid);
                     $image = field_get_items('node', $node, 'field_page_image');
                     $node_color=$node->field_color_code_field['und']['0']['rgb']; 
 	                 print '<li class="campaig-home-'.$c.'">';
					 print '<div class="hover-div">';
					 print '<div class="prod-img">';
                     print "<span class='product_1'>";
                     if(!empty($image)){
                       foreach ($image as $key=>$value) {
                         $output = field_view_value('node', $node, 'field_page_image', $image[$key],array(
									  'type' => 'image',
									  'settings' => array(
										'image_style' => 'home_campaign', 
										'image_link' => 'content',
									  ),
                                   ));
                         print render($output);
						break;
                       }   
                      }
				print '</span>';
				print "<div class='prod_title' style='background:".$node_color.";'>";
				print $node->title;
				print "</div>";
				print "</div>";
				
				print '<div class="info-div" style="background:#FFFFFF;color:#000000">';
				if($node->body[$node->language][0]["value"] != ""){
					print substr($node->body[$node->language][0]["value"], 0, 100).".....";
				}
				global $base_url;
				$external_url=@$node->field_page_url[$node->language][0]["value"];
				if(!empty($external_url)){
				print '<div class="r-more"><a href="'.$external_url.'" target="_blank"><span>Read more </span><span class="ui-icon plus"></span></a></div>';
				}
				else
				{
				print '<div class="r-more"><a href="'.drupal_lookup_path('alias',"node/".$node->nid).'"><span>Read more </span><span class="ui-icon plus"></span></a></div>';
				}
				print "</div>";
				
				print "</div>";
				print '</li>';
         $c++;   }
	?>
	</ul>
</div>
<?php } ?>

<script type="text/javascript"> 
jQuery('.hover-div').hover( function() {
    //mouse over
    jQuery(this).find('.prod-img').hide();
    jQuery(this).find('.info-div').show();
    }, function() {
    //mouse out
    jQuery(this).find('.prod-img').show();
    jQuery(this).find('.info-div').hide();
    });
</script>