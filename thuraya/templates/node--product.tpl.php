<?php 
global $base_url;
drupal_add_js($base_url.'/'.path_to_theme() . '/js/product.js');
//echo "<pre>"; print_r($node->field_fast_facts[$node->language][0]['safe_value']); exit;
echo '&nbsp;';
?>
   <!-- Solutions  -->
        <div class="main_content">
          <div class="product_details product-02">
            <div class="colums">
              <div class="col1">
                <div class="right-push">
                  <div class="slider-container">
                    <div class="slider-animation">
                      <?php 
					//echo print_r($node->field_product_image[$node->language]); exit;
					//print image_style_url('thumbnail', $node->field_product_image[$node->language][$i]['uri'])
					$noOfImages = count($node->field_product_image[$node->language]);
				?>
					<div id="moveSlider">
						<ul>
						<?php for($i=0; $i<$noOfImages; $i++) { ?>
						<li class="sd"><img src="<?php print file_create_url($node->field_product_image[$node->language][$i]['uri']) ?>" alt="Product Image"></li>
						<?php } ?>
						</ul>		
					</div>
                    </div>
					<?php if($noOfImages > 1): ?>
                    <div class="pager-section">
						<div id="prev"><img src="<?php print file_create_url("sites/all/themes/thuraya/images/l-ar.png") ?>" alt="Previous"></div>
						<div id="pager">
							<ul>
							<?php for($i=0; $i<$noOfImages; $i++) { ?> 
							<li><img src="<?php print image_style_url('small', $node->field_product_image[$node->language][$i]['uri']) ?>" alt="Preview Image"></li>
							<?php } ?>
							</ul>
						</div>
						<?php if($noOfImages > 3): ?>
							<div id="next"><img src="<?php print file_create_url("sites/all/themes/thuraya/images/r-ar-active.png") ?>" alt="Next"></div>
						<?php else: ?>
							<div id="next"><img src="<?php print file_create_url("sites/all/themes/thuraya/images/r-ar.png") ?>" alt="Next"></div>
						<?php endif; ?>
                    </div>
					<?php endif; ?>
                  </div>
                </div>
              </div>
			  <div class="colb" id="centerdiv">
			  <div class="menu-nav">
				  <ul class="menu-list">
					<li id="pmaindiv" class="active"><div id="menudiv"><a href="javascript:void(0)" onclick="showDivs('pmain')">Main</a></div></li>
					<li id="featuresdiv"><div><a href="javascript:void(0)" onclick="javascript:showDivs('features')">Features</a></div></li>
					<li id="learnitdiv"><div><a href="javascript:void(0)" onclick="javascript:showDivs('learnit')">Learn it</a></div></li>
					<li id="useitdiv"><div><a href="javascript:void(0)" onclick="showDivs('useit')">Use it</a></div></li>
					<li id="buyitdiv"><div><a href="javascript:void(0)" onclick="showDivs('buyit')">Buy it</a>
					
					</div></li>
					<li id="accessoriesdiv"><div><a href="javascript:void(0)" onclick="showDivs('accessories')">Accessories</a></div></li>
				  </ul>
			  </div>
              <div class="col2 cmsdata">
                <div class="right-push" id="pmain">
				    <?php if ($title): ?>
					<h1><?php print $title; ?></h1>
					<?php endif; ?>
					<?php if(isset($node->field_short_description)): ?>
					<h2><?php print $node->field_short_description[$node->language][0]['value']; ?></h2>
					<?php endif; ?>
					<?php if($node->body):
						if($node->body[$node->language][0]["safe_summary"] != ""){
							print '<div id="bodydata" style="display:none;">'.$node->body[$node->language][0]["safe_value"].'</div>';
					?>
					<div id="teaser"><?php print $node->body[$node->language][0]["safe_summary"]; ?></div>
					<?php } else { ?>
					<?php print $node->body[$node->language][0]["safe_value"]; ?>
					<?php } ?>
					<?php endif; ?>
                  <div class="info_div">
					<?php if($node->field_product_demo): ?>
					  <div class="demo_div"><a class="colorbox-load" target="_blank" href="<?php print file_create_url($node->field_product_demo[$node->language][0]['safe_value'].'?iframe=true&width=800&height=500') ?>"><span class="text_div">3D Demo</span> <span class="ui-icon demo">&nbsp;</span></a> </div>
					  <?php endif; ?>
					<?php if(!empty($node->field_youtube_video_url)): ?>  
					<div class="demo_div video_div"><a class="colorbox-load" target="_blank" href="<?php print $node->field_youtube_video_url[$node->language][0]['value'].'?iframe=true&width=800&height=500'; ?>"><span class="text_div">Video</span> <span class="ui-icon video-icon">&nbsp;</span></a> </div>
					<?php endif; ?>
                    <?php if($node->field_compare_model): ?>
					 <div class="compare_div"><a target="_blank" href="<?php print file_create_url($node->field_compare_model[$node->language][0]['uri']) ?>"><span class="text_div">Compare this model</span> <span class="ui-icon plus">&nbsp;</span></a></div>
					 <?php endif; ?>
                  </div>
				  <?php if($node->body[$node->language][0]["safe_summary"] != ""): ?>
                  <div class="read-greay"><a href="javascript:void(0)" id="readmore" onclick="showMore()">Read more<span class="ui-icon arrow-down"></span></a></div>
				  <?php endif; ?>
                  <div class="info_div info_div_no_bottom">
                    <div class="quick_contact">
                  	<a href="javascript:void(0)" onclick="showForm()"><span class="text_div">Buy Here</span> <span class="ui-icon plus">&nbsp;</span></a>
					<!--<a class="colorbox-inline buyit" href="?width=500&amp;height=550&amp;inline=true#webformcontent"><span class="text_div">Buy Here</span> <span class="ui-icon plusOrange">&nbsp;</span></a> -->
                  </div>
                  <div class="share_div"> <span class="text_div">Share it</span>
                      <div class="map-nav">
                        <ul class="col-2">
                          <li> 
							  <a href="http://www.facebook.com/sharer.php?u=<?php print curPageURL();?>" target="_blank" class="ui-icon facebook"></a>
							  <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php print curPageURL();?>&amp;title=<?php print urlencode($node->title);?>&summary=<?php echo getNodeTeaser($node);?>" target="_blank" class="ui-icon in"></a>
							  <a href="http://www.twitter.com/home?status=<?php print "Thuraya-".curPageURL();?>" class="ui-icon twiter" target="_blank"></a> </li>
                        </ul>
                      </div>
                  </div>
                  </div>
                </div>
				<!-- hidden DIVs to store data for the other tabs - Features, Learn it, Use it..... -->
				<div id="features" style="display:none;">
				<?php if(isset($node->field_features)):?>
				<h1>Features</h1>
				<?php print $node->field_features[$node->language][0]["safe_value"]; ?>
				<?php endif; ?>
				</div>
				<div id="useit" style="display:none">
				<?php if(isset($node->field_use_it)):?>
				<h1>Use It</h1>
				<?php print $node->field_use_it[$node->language][0]["safe_value"]; ?>
				<?php endif; ?>
				</div>
				<div id="learnit" style="display:none">
				<?php if(isset($node->field_learn_it)):?>
				<h1>Learn It</h1>
				<?php print $node->field_learn_it[$node->language][0]["safe_value"]; ?>
				<?php endif; ?>
				</div>
				<div id="buyit" style="display:none">
				<?php if(isset($node->field_buy_it)):?>
				<h1>Buy It</h1>
				<?php print $node->field_buy_it[$node->language][0]["safe_value"]; ?>
				<?php endif; ?>
				</div>
				<div id="accessories" style="display:none">
				<?php if(isset($node->field_accessories)):?>
				<h1>Accessories</h1>
				<?php print $node->field_accessories[$node->language][0]["safe_value"]; ?>
				<?php endif; ?>
				</div>
				<div class="cont-form" id="cform" style="display:none">
                  <?php
					$formnode = node_load('54');					
					webform_node_view($formnode,'full');
					print theme_webform_view($formnode->content);
				  ?>
                </div>
				<div class="cont-form-popup" id="cform-popup" style="display:none">
				<div id="webformcontent">
                <?php
					$formnode = node_load('1584');					
					webform_node_view($formnode,'full');
					print theme_webform_view($formnode->content);
				  ?>
				 </div> 
                </div> 	
              </div>
              <div class="col3">
                <div class="in-container">
                  <ul>
                    <?php if(!empty($node->field_fast_facts)): ?>
					<li>					
						<div>
							<h3>Fast Facts</h3>
							<span class="content">
							<?php print $node->field_fast_facts[$node->language][0]['safe_value']; ?>
							</span>
						</div>
						<div class="divider1_div"></div>
					</li>
					<?php endif; ?>
                    <?php if(!empty($node->field_file) || !empty($node->field_sub_page) || !empty($node->field_external_links)): ?>
					<li class="leftarrow dl">
						<div class="downloads">
						<?php
							if(!empty($node->field_useful_links_title))
								$title = $node->field_useful_links_title[$node->language][0]['safe_value'];
							else
								$title = "Useful Links";
						?>
							<h3><?php print $title; ?></h3>
							<ul>
							<?php 
								//check for files uploaded
								if(!empty($node->field_file)){
									$downloadFiles = $node->field_file[$node->language];
									//print_r($downloadFiles); exit;
									for($i=0; $i<count($downloadFiles);$i++)
									{
										$fileDesc = $downloadFiles[$i]['description'];
										if($fileDesc == "")
											$fileDesc = "Downalod File";
										print '<li><a target="_blank" href="'.file_create_url($downloadFiles[$i]['uri']).'">'.$fileDesc.'</a></li>';
									}
								}

								//check for Sub Pages added
								if(!empty($node->field_sub_page)){
									$subPages = $node->field_sub_page[$node->language];
									for($i=0;$i<count($subPages);$i++){
										$entity_id = $node->field_sub_page[$node->language][$i]['value'];
										$entity = entity_load('field_collection_item', array($entity_id));
										print '<li><a href="javascript:void(0)" onclick="showPage('."'subpage".$entity_id.$id.'\')">'.$entity[$entity_id]->field_page_title[$node->language][0]['value'].'</a>';
										print '<div id= "subpage'.$entity_id.$id.'" style="display:none">';
										print '<h1>'.$entity[$entity_id]->field_page_title[$node->language][0]['value'].'</h1>';
										print $entity[$entity_id]->field_page_description[$node->language][0]['safe_value'].'</div></li>';
									}
								}
								
								//check for External Links added
								if(!empty($node->field_external_links)){						
									$extLinks = $node->field_external_links[$node->language];
									for($i=0;$i<count($extLinks);$i++){
										$entity_id = $node->field_external_links[$node->language][$i]['value'];
										$entity = entity_load('field_collection_item', array($entity_id));
										//echo "<pre>";print_r($entity[$entity_id]->field_link_url);exit;
										print '<li><a target="_blank" href="'.$entity[$entity_id]->field_link_url[$node->language][0]['url'].'">'.$entity[$entity_id]->field_link_url[$node->language][0]['title'].'</a></li>';
									}
								}
							?>
							</ul>
						</div>
						<div class="divider1_div"></div>
					</li>
					<?php endif;?>
                    <li class="leftarrow">
					<h3>Sectors</h3>
                    <div class="sectors">
						<ul>
							<?php 
								$sectorsList = node_load_multiple(array(), array('type' => 'sector')); 
								//print "<pre>"; print_r($sectorsList); exit;
								$assSectors = $node->field_associated_solutions[$node->language];
								//print_r($assSectors); exit;
								foreach ($sectorsList as $key => $value):
									$className = strtolower(str_replace("Comms", "", $value->title));
									$className = str_replace("gov't", 'govt', $className);
									$activeState = "";
									for($i=0; $i<count($assSectors); $i++){
										//print ">>".$assSectors[$i]['nid'];
										if($assSectors[$i]['nid'] == $value->nid){
											$activeState = "class='active'";
											break;
										}
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
              </div>
			  </div>
			  <div class="col2 no-col3" style="display:none" id="subpagediv">
				<div class="r-more">
				<a href="javascript:void(0)" onclick="backtoMain()"><span class="ui-icon prev"></span><span>Back to Main</span></a>
				</div>
				<div class="text-container" id="subpage"></div>
                  <div class="shareit">                  
                    <div class="share_div"> 
					  <div class="text-share">Share it</div>
                      <div class="map-nav">
                        <ul class="col-2">
                          <li><a href="http://www.facebook.com/sharer.php?u=<?php print curPageURL();?>" target="_blank" class="ui-icon facebook"></a><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php print curPageURL();?>&amp;title=Thuraya" target="_blank" class="ui-icon in"></a><a href="http://www.twitter.com/home?status=<?php print "Thuraya-".curPageURL();?>" class="ui-icon twiter" target="_blank"></a> </li>
                        </ul>
                      </div>
                    </div>
                  </div>                
              </div>
			</div>			
            <?php print associated_product_type_list($node->field_product_type[$node->language][0]["tid"], $node->nid);?>
          </div>
        </div>
		<?php $carousIds = implode(',', array($node->nid))?>
		<input type="hidden" id="coursel-id" name="coursel-id" value="<?php echo $carousIds ?>" />
