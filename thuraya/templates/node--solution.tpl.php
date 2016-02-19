<?php
/**
* Author     : Ramya
* Description: Template file for sector details page 
**/
echo "&nbsp;";
$sec_class = $class = $class1 = $s ='';
 

?>
 
	<div class="media-solutions sol-detail">
 
		<?php
			$assSectors = solutions_related_sectors($node->nid);

			if(empty($content['field_fast_facts']) && empty($content['field_file']) && count($assSectors) == 0){$class='nocol3';$s ='1';}
			if(empty($content['field_solution_image'])){$class1 = 'nocol1';}
			?>
		
			<div class="colums">
			<?php if(!empty($content['field_solution_image'])){?>
			<div class="col1">
				<div class="in-container">
				<?php print render($content['field_solution_image']);?>
				</div>
			</div>
			<?php }?>
			
			<div class="col2 <?php print $class.' '.$class1;?>">
				<div class="in-container">
					<ul>
					<li class="headline">                                           
                                            
                                            <span><?php print $title;?></span></li>			
					<li class="content">
                                        <?php print $node->body['und'][0]['value'];?>
                                        </li>
                                        <?php if(!empty($content['field_sector_video'])){
				                        $newWidth = 370;
										$newHeight = 230;
										$output_video = $node->field_sector_video['und'][0]['value'];

										$output_video = preg_replace(
										array('/width="\d+"/i', '/height="\d+"/i'),
										array(sprintf('width="%d"', $newWidth), sprintf('height="%d"', $newHeight)),
										$output_video);
										?>
					<li class="video">
                                        <?php print $output_video;?>
                                        </li>
                                        <?php }?>
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
				
				if(!empty($content['field_file_useful_link']) || !empty($content['field_external_link_useful']) || !empty($content['field_sub_page_useful'])){?>
				<li class="leftarrow dl">
					<div class="border">
<h3><?php if(!empty($content['field_title'])){
						print render($content['field_title']);}else {print 'Useful Links';}?></h3>
						<ul>
						<?php print render($content['field_file_useful_link']);?>
						<?php if(!empty($content['field_external_link_useful'])){print '<li>'.render($content['field_external_link_useful']).'</li>';}?>

						<?php if(!empty($content['field_sub_page_useful'])){
						print render($content['field_sub_page_useful']);}?>
						</ul>
					</div>
				</li>
                                <?php }?>

							 <?php 	if(!empty($content['field_service_list'])){?>
					
								<li class="leftarrow dl">
                                    <div class="border">
                                        <h3>Service List</h3>
                                        <ul>						
										<?php print render($content['field_service_list']);?>

                                        </ul>
                                    </div>
                                </li>   
								<?php } ?>
			<?php if(!empty($content['field_file']) || !empty($content['field_title']) || !empty($content['field_subpage_link'])){?>
				<li class="leftarrow dl">
					<div class="border">
						
						<h3>Downloads</h3>

						<ul><?php if(!empty($content['field_external_link'])){print '<li>'.render($content['field_external_link']).'</li>';}?>

						<?php if(!empty($content['field_subpage_link'])){ print render($content['field_subpage_link']);}?>
						<?php print render($content['field_file']);?>
						</ul>
					</div>
				</li>
                                <?php }?>
				<li class="sector">
					<h3>Sectors</h3>
					  <div class="sectors">
                                <ul>
									<?php 
										$sectorsList = node_load_multiple(array(), array('type' => 'sector')); 
									//	print "<pre>"; print_r($sectorsList);
										foreach ($sectorsList as $key => $value):
											$className = strtolower(str_replace("Comms", "", $value->title));
											$activeState = "";										
												if(in_array($value->nid,$assSectors)){
												$activeState = "class='active'";
											}	
										?>
										<li class="<?php print $className; ?>"><a <?php print $activeState; ?> href="<?php print url("node/".$value->nid)?>"><span class="ui-icon"></span><?php print t($value->title);?></a></li>
									<?php
										//print $value->nid.">>".$value->title."<br>";
										endforeach;
									?>
                                </ul>
                            </div>
				
                 </li>	
                 
                 
				</ul>
				</div>
		<?php } ?>

			</div>
			</div>
			
                            <?php print associated_products_list($node->nid);?> 
                                       
                          
		</div>
	  
  