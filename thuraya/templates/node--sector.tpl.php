<?php
/**
* Author     : Ramya
* Description: Template file for sector details page 
**/	
global $base_url;
drupal_add_js($base_url.'/'.path_to_theme() . '/js/sector.js');

echo "&nbsp;";
$carouselIds = array();
$sec_class = $class = $class1 = $s ='';
$str = strtolower($title);
$pos = strpos($str,'comms');
$title_first_part = substr($str,0,$pos);
$title_second_part = substr($str,$pos);

if($title_first_part =='media'){$sec_class = '';}
else {$sec_class = $title_first_part.'-sd';}

$subSectors = get_subsectors($node->vid);
$main_path = $base_url.'/'.drupal_get_path_alias('node/'.$node->nid);
$main_content = $content;

function render_solutions ($field_associated_solutions) {
    if(!empty($field_associated_solutions)){
	  $output = '<ul>';
	}
	else{
	  return '';
	}
    foreach($field_associated_solutions as $key => $value){
	  $get_node_alias = drupal_get_path_alias('node/'.$value['nid']);
	  $output .= '<li><a href="/'.$get_node_alias.'">'.$value['node']->title.'</a></li>';
	}
	$output .= '</ul>';
	return $output;
}
function get_subsectors($vid)
{
	$query = db_select('node', 'n');
	$query->innerjoin('field_data_field_main_sector', 'fa', 'fa.entity_id= n.nid');
	$query->fields('n', array('title', 'nid'));
	$query->condition('fa.field_main_sector_nid', $vid)
		  ->condition('fa.bundle', 'subsector')
		  ->condition('n.status', 1)
		  ->orderBy('n.nid');
	$result = $query->execute();
	$i=0;
	foreach ($result as $record) {
	$subSectors[$i]['id']=$record->nid;
	$subSectors[$i]['title']=$record->title;
	$i++;
	}
	return $subSectors;
}
?>
	<input type="hidden" value="<?php echo count($subSectors); ?>" id="subsectors-num" />
	<div class="sector-menu">
			  <ul class="menu-list menu-list-sectors">
				<li id="<?php print "subsec0"; ?>" class="active"><div id="menudiv"><a href="<?php echo $main_path; ?>" >Main</a></div></li>
				<?php for($i=0; $i<count($subSectors); $i++) { 
				$secId = "subsector".($i+1);
				$subsec_path = $base_url.'/'.drupal_get_path_alias('node/'.$subSectors[$i]['id']);
				if($subSectors[$i]['id']==$node->nid){
				$selcted_class="active";
				}
				?>
				<li id="<?php echo "subsec".($i+1); ?>"><div><a href="<?php echo $subsec_path; ?>" class="sub-sectortab <?php echo $selcted_class;?>"><?php echo $subSectors[$i]['title']; ?></a></div></li>
				<?php } ?>
			  </ul>
			</div>
	   <?php 
     		$secId = "subsector0";  
		?>
			<div class="<?php print $sec_class." ".$secId;?> media-solutions">
		         <?php
			       if(empty($content['field_fast_facts']) && empty($content['field_file']) && empty($content['field_associated_solutions'])){
				      $class='nocol3';
					  $s ='1';
				   }
			       if(empty($content['field_sector_video']) && empty($content['field_product_image'])){
				      $class1 = 'nocol1';
				   }
			?>
		
			       <div class="colums" id="secmain">
			       <?php if(!empty($content['field_sector_video'])){
				            $newWidth = 300;
				            $newHeight = 230;
				            $output_video = $node->field_sector_video['und'][0]['value'];

				            $output_video = preg_replace(
				            array('/width="\d+"/i', '/height="\d+"/i'),
				            array(sprintf('width="%d"', $newWidth), sprintf('height="%d"', $newHeight)), $output_video);
			       ?>
			        <div class="col1">
				        <div class="in-container">
				            <?php print $output_video; ?>
				        </div>
			        </div>
			        <?php } elseif(!empty($content['field_product_image'])){ ?>
			        <div class="col1">
				         <div class="in-container"><?php print render($content['field_product_image']);?></div>
			        </div>			
			        <?php  }  ?>
			
			        <div class="col2 <?php print $class.' '.$class1;?>">
			
				         <div class="in-container">
					        <ul>
					            <li class="headline">                                           
                                            <span class="ui-icon icon-big <?php print $title_first_part;?>-comms-big"></span>
                                            <span><?php print strtoupper($title_first_part);?></span><span class="sfont"><?php print strtoupper($title_second_part);?></span></li>			
					            <li class="content">
                                        <?php print $node->body['und'][0]['value'];?>
                                </li>
                        <?php //if(!empty($content['field_product_image'])){?>																				
					            <li class="video"> 
				        <?php //print render($content['field_product_image']);?>
                                </li>
                                        <?php //} ?>
					            <li class="share">					
						                    <ul class="col-2">
							                     <li class="share-it">Share it</li>
							                     <li class="share-icons">
	                                                     <a href="http://www.facebook.com/sharer.php?u=<?php print curPageURL();?>" target="_blank" class="ui-icon facebook"></a>
	                                                     <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php print curPageURL();?>&amp;title=<?php print urlencode($node->title);?>&summary=<?php echo getNodeTeaser($node);?>" target="_blank" class="ui-icon in"></a>
	                                                     <a href="http://www.twitter.com/home?status=<?php print "Thuraya-".curPageURL();?>" class="ui-icon twiter" target="_blank"></a> 
														
							                     </li>
						                    </ul>
					            </li>
					         </ul>
				     </div>
			</div>
			<?php if($s!='1'){?>
			<div class="col3">
				<div class="in-container">
				<ul>
				<?php if(!empty($content['field_fast_facts'])){?>
				<li>					
					<div class="border">
						<h3>Fast Facts</h3>
						<div class="content">
                           <?php print render($content['field_fast_facts']);?>
                         </div>
					</div>
				</li> <?php }
				if(!empty($content['field_service_list'])){
				?>
				<li class="leftarrow dl">
                                    <div class="border">
                                        <h3>Service List</h3>
                                        <ul>						
										<?php print render($content['field_service_list']);?>

                                        </ul>
                                    </div>
                                </li>   

                                <?php } if(!empty($content['field_file']) || !empty($content['field_title']) || !empty($content['field_subpage_link'])){?>
				<li class="leftarrow dl">
					<div class="border">
						<h3><?php if(!empty($content['field_title'])){
						print render($content['field_title']);}else {print 'Useful Links';}?></h3>

						<ul><?php if(!empty($content['field_external_link'])){print '<li>'.render($content['field_external_link']).'</li>';}?>

						<?php if(!empty($content['field_subpage_link'])){ print render($content['field_subpage_link']);}?>
						<?php print render($content['field_file']);?>
						</ul>
					</div>
				</li>
                                <?php }?>
								<?php if(!empty($content['field_associated_solutions'])){?>
				<li class="leftarrow sol">
					<h3>Solutions</h3>
					<?php print render($content['field_associated_solutions']);?>
				
                                </li>
									<?php } ?>

				</ul>
				</div>
			   </div>
			   <?php } ?>
			   </div>
			  <?php print associated_products_list($node->nid);
			   $carouselIds[$node->nid] = $node->nid;
			   ?>
			   </div>
    <?php 
	
	     	
		$carousIds = implode(',', $carouselIds);
    ?>
  <input type="hidden" id="coursel-id" name="coursel-id" value="<?php echo $carousIds ?>" />