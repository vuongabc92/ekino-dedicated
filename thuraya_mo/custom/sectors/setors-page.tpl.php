<?php
global $base_url;

drupal_add_js(drupal_get_path('module', 'sectors') . '/sector.js');
$gen = node_load('846');
if(isset($gen->field_generic_video['und'][0]['value'])){
	$mob = getMobile();
	if($mob == 1){
	$newWidth = '100%';
	} else {
	$newWidth = 450;
	}
	$newHeight = 280;
	$output_video = $gen->field_generic_video['und'][0]['value'];

	$output_video = preg_replace(
	array('/width="\d+"/i', '/height="\d+"/i'),
	array(sprintf('width="%d"', $newWidth), sprintf('height="%d"', $newHeight)),
	$output_video);
}
?>
<div class="prolist-topcontainer">
	<div class="col1">
	  <div class="in-container">
<?php print $output_video; ?>
</div>
	</div>
	<div class="col2">
	  <h1><?php print 'Sectors';?></h1>
		<div class="content">
              <?php if(isset($gen->body['und'][0]['value'])){ print $gen->body['und'][0]['value'];}?>

	<div id="solMenuInCont" class="all_sectors" style="margin:0px;">
	<ul>
      <li class="comms-energy">
	<a href="<?php $base_url;?>/energy-comms" title="EnergyComms" class="sector_url">
	 <span class="ui-icon logo"></span>							
	</a></li>
   <li class="comms-enterprise">
	<a href="<?php $base_url;?>/enterprise-comms" title="EnterpriseComms" class="sector_url">
	 <span class="ui-icon logo"></span>							
	</a></li>
   <li class="comms-defense">
	<a href="<?php $base_url;?>/government-comms" title="GovernmentComms" class="sector_url">
	 <span class="ui-icon logo"></span>							
	</a></li>
   <li class="comms-leisure">
	<a href="<?php $base_url;?>/leisure-comms" title="LeisureComms" class="sector_url">
	 <span class="ui-icon logo"></span>							
	</a></li>
   <li class="comms-marine">
	<a href="<?php $base_url;?>/marine-comms" title="MarineComms" class="sector_url">
	 <span class="ui-icon logo"></span>							
	</a></li>

	 <li class="comms-media"><a href="<?php $base_url;?>/media-comms" title="MediaComms" class="sector_url">
	<span class="ui-icon logo"></span>							
	</a></li>

	<li class="comms-relief"><a href="<?php $base_url;?>/relief-comms" title="ReliefComms" class="sector_url">
	 <span class="ui-icon logo"></span>							
	</a></li>
	</ul>
	</div>

		</div>				
	 </div>
</div>

	  <div class='solutions_title'><h1>Sector Solutions</h1></div>
	   <?php if(isset($gen->field_text_under_sector_solution['und'][0]['value'])){?>
	    <p>
	    <?php print $gen->field_text_under_sector_solution['und'][0]['value'];?>
	   </p>
	   <?php } ?>
        <div class="solu_logo">			
	  	 <div class="col1">
		 <div class="in-container">
		   <div id="soluMenuCont">					
		    <div class="header"><a href="javascript:void(0)">Choose Sector<span class="ui-icon down-arrow-g"></span></a></div>
			<div id="drop_dn" class="content">
			<div class="comms" id="solMenuInCont">
			<ul>
			 <a class='sector_url' href="<?php print $base_url.'/'.$sector_url;?>" style="text-decoration:none;">
			 <li><span class="ui-icon logo"></span></li>							
			  <li class="logoText">
			    <span class="logoBText">
				</span>
				</a>
			   </li>
			  </ul>				
			</div>
			</div>			
			</div>
				
                     <div id="soluMenu" style="display: none;">				
                        <ul>
                        <li><a id="energy" href="#solu_logo"><span class="logoBText">Energy</span><span class="logoSText">Comms</span></a></li>
                        <li><a id="enterprise" href="#solu_logo"><span class="logoBText">Enterprise</span><span class="logoSText">Comms</span></a></li>
			   <li><a id="government" href="#solu_logo"><span class="logoBText">Government</span><span class="logoSText">Comms</span></a></li>
                        <li><a id="leisure" href="#solu_logo"><span><span class="logoBText">Leisure</span><span class="logoSText">Comms</span></span></a></li>
                        <li><a id="marine" href="#solu_logo"><span class="logoBText">Marine</span><span class="logoSText">Comms</span></a></li>
                        <li class="active"><a id="media" href="#solu_logo"><span class="logoBText">Media</span><span class="logoSText">Comms</span></a>
                        <span class="ui-icon down-arrow-b" id="closeArrow"></span></li>
                        <li><a id="relief" href="#solu_logo"><span class="logoBText">Relief</span><span class="logoSText">Comms</span></a></li>
                        </ul>
			</div>
		    </div>
		  </div>
            <div class="col2" id="solutionsajax">
			<?php
			$p = $base_url.'/sites/all/modules/custom/sectors';
			?>
			 <div id='loadingmessage' style='display:none;top:20px;text-align: center;'>
                <img src='<?php print $p;?>/loading.gif'/>
				               </div>
            </div>
		  </div>
