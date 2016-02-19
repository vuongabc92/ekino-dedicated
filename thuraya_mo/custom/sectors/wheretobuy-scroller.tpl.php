<?php
    drupal_add_js(drupal_get_path('module', 'sectors') . '/webticker.js');
  ?>
<style type="text/css">
.tadingContainer{overflow:hidden; margin:10px 10px 0px 0px;}
.tading-now{float:left; color:#0AA9EE; font-weight:normal; font-family:'NewJuneBold',Arial,Geneva,sans-serif; font-size:16px; line-height:30px;}
.tickercontainer {
    width:85%;
    height: 27px;
    margin: 0;
    padding: 0;
    overflow: hidden;
	float:right;
}
.tickercontainer .mask {
    position: relative;
    top: 8px;
    height: 18px;
    overflow: hidden;
}
ul.newsticker {
    position: relative;
    font: bold 8pt Arial;
    color:black;
    list-style-type: none;
    margin: 0;
    padding: 0;
}
ul.newsticker li {
    float: left;
    margin: 0;
    padding-right: 7px;
}
.vline{border-right:2px solid #c5c5c5; margin-left:7px;}
.tickercontainer a{color:#5B5B5B;}
.tickercontainer a:hover{color:#0AA9EE; text-decoration:none;}
.tickercontainer .promoMessages a{color:#0AA9EE;}
.tickercontainer .promoMessages a:hover{color:#0AA9EE; text-decoration:none;}
</style>
<script type="text/javascript">
jQuery(document).ready(function () {
	jQuery('#webticker').webTicker({
       
    });   
});
</script>
<div class="tadingContainer">
<div class="tading-now">What&rsquo;s Trending</div>
<ul  id="webticker">
<?php 
global $base_url;
if($manage_promos != ''){
	//print_r($manage_promos);	
	foreach($manage_promos as $key => $value){			
		$promoTitle = $value['title']['und'][0]['value'];
		$promoLink = $value['url']['und'][0]['value'];		
		//$link = l($promoTitle,$promoLink);
		print '<li id="'.$promoTitle.'" class="promoMessages"><span></span><a href="'.$promoLink.'"><b>'.$promoTitle.'</b></a><span class="vline"></span></li>';
	};
}
if($service_partners != ''){
foreach ($service_partners as $service_partner){			
	$service_partner['id'] = $service_partner['title']['und'][0]['nid'];
	$service_partner_type = @$service_partner['partnertype']['und'][0]['value'];
	if($service_partner_type == 'Gold'){
		$class = 'ui-icon gold';
	}elseif($service_partner_type == 'Silver'){
		$class = 'ui-icon silver';	
	}elseif($service_partner_type == 'Bronze'){
		$class = 'ui-icon bronze';	
	}else{
		$class = '';
	}
	$service_partner_node = node_load($service_partner['id']);
	$service_partner['title'] = $service_partner_node->title; 
	if($display_type=='S'){
	$link = l($service_partner['title'],$base_url.'/where-to-buy?title='.$service_partner['title']);
	}
	else
	{
	$logo = @$service_partner['trikar_logo']['und'][0]['uri'];
	if($logo!=''){
	$imguri = array('style_name' => 'triker_logo', 'path' => $service_partner['trikar_logo']['und'][0]['uri']);
	$img_href = theme('image_style',$imguri);
	}
	$link = l($service_partner['title'],$base_url.'/retailer-where-to-buy?title='.$service_partner['title']);
	}
	print '<li id="'.$service_partner['title'].'"><span class="'.$class.'"></span><a href="javascript:void(0)">'.$img_href.' '.$link.'</a><span class="vline"></span></li>';
	
	}
}
?>	
</ul>
</div>
