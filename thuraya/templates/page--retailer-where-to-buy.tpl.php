<?php
global $base_url;
drupal_add_js($base_url.'/'.path_to_theme() . '/js/oms.min.js');
//echo '&nbsp;';
$views_page = views_get_page_view();
?>
<script>
window.onload = function() {
	var gm = google.maps;
	var basePath = "<?php echo $base_url.'/'.path_to_theme();?>";
	var map = new gm.Map(document.getElementById('w2buy_map'), {
		mapTypeId: gm.MapTypeId.ROADMAP,
		center: new gm.LatLng(30.06696627928031, 25.291412660455578), 
		zoom: 2,
		scrollwheel: false
	});
	
	var iw = new gm.InfoWindow();
	var oms = new OverlappingMarkerSpiderfier(map, {markersWontMove: true, markersWontHide: true});
	
	var iconWithColor = function(color) {
	return 'http://chart.googleapis.com/chart?chst=d_map_xpin_letter&chld=pin|+|' +
	  color + '|000000|ffff00';
	}
	var shadow = new gm.MarkerImage(
		'https://www.google.com/intl/en_ALL/mapfiles/shadow50.png',
		new gm.Size(37, 34),  // size   - for sprite clipping
		new gm.Point(0, 0),   // origin - ditto
		new gm.Point(10, 34)  // anchor - where to meet map location
	);

	oms.addListener('click', function(marker) {
		iw.setContent(marker.desc);
		iw.open(map, marker);
	});
	oms.addListener('spiderfy', function(markers) {
		for(var i = 0; i < markers.length; i ++) {
			markers[i].setIcon(basePath+'/images/marker-red-dark.png');
			markers[i].setShadow(null);
		} 
		iw.close();
	});
	oms.addListener('unspiderfy', function(markers) {
		for(var i = 0; i < markers.length; i ++) {
		  markers[i].setIcon(basePath+'/images/marker-red.png');
		  markers[i].setShadow(shadow);
		}
	});
	
	if (window.mapData.length == 0) {
		jQuery('#w2buy_map').hide();
		jQuery('#wrb_no_results').show();
	} else {
		jQuery('#wrb_no_results').hide();
		jQuery('#w2buy_map').show();
		var bounds = new gm.LatLngBounds();
		for (var i = 0; i < window.mapData.length; i ++) {
			var datum = window.mapData[i];
			var loc = new gm.LatLng(datum.lat, datum.lon);
			bounds.extend(loc);
			var marker = new gm.Marker({
			  position: loc,
			  title: datum.h,
			  map: map,
			  //icon: iconWithColor(usualColor),
			  icon: basePath+'/images/marker-red.png',
			  shadow: shadow
			});
			marker.desc = datum.d;
			oms.addMarker(marker);
		}
		
		if (jQuery('#edit-title').val() != "Company") {
			map.fitBounds(bounds);
		}

		// for debugging/exploratory use in console
		//window.map = map;
		window.oms = oms;
	}
}
</script>
<div class="ui-page">
  <!--  Header Section -->
<?php  print $mod_header;?>
  <!--  /Header Section -->
  <!--  Content Section -->
  <div class="ui-content">
     <div class="wtb">
  <div class="ui-page-content">
    <!-- Solutions  -->   
   <div class="main-container">	
  
    <!-- Solutions  -->   
         <div class="wheretobuy">
 	<?php $breadcrumb=str_replace('href="//"','href="/"',$breadcrumb); ?> 
      <div class="breadcrumbs"><?php print $breadcrumb; ?></div>
    
      <div class="content">
		<h1>Where to Buy</h1>
		<div class="service-link"><a href="<?php print $base_url; ?>/where-to-buy">Service Partners</a></div>
		<div class="retailers-link service-selected"><a href="<?php print $base_url; ?>/retailer-where-to-buy">Retailers</a></div>
        <?php print $messages; ?>
        <?php print render($tabs); ?>
        <?php print render($page['help']); ?>
        <?php if ($action_links): ?>
          <ul class="action-links"><?php print render($action_links); ?></ul>
        <?php endif; ?>
      
        <?php print render($page['content']); ?>
		<?php print wheretobuy_scroller('R');?>
		<?php if (count($views_page->result) == 0) :?>
		<div class="map-section">
		<div id="wrb_no_results" style="display:none;">
		<p> There are currently no Thuraya Retailer Partners in this location. Please <a target="_blank" href="<?php print $base_url.'/contact-us'?>">contact us</a> and we would be pleased to refer to a Retailer Partner located closest to you. If you are interested in becoming a Thuraya Retailer Partner, please contact Thuraya Customer Care at <a href="mailto:customer.care@thuraya.com" target="_top">customer.care@thuraya.com</a>.</p>
		</div>
		<?php endif; ?>
		<div class="MapContainer">
			<div id="w2buy_map"></div>
		</div>
<script>
  var data = [];
  var popupData = '';
  
  <?php 
	
	for($i=0; $i<count($views_page->result); $i++) { 
		$tmz = $views_page->result[$i]->_field_data['nid']['entity']->field_timezone['und'][0]['value'];
		$timeZone = '';
		if (!empty($tmz)) {
			$dateTime = new DateTime($tmz);
			$dateTime->setTimeZone($tmz);
			$d1 = $dateTime->format('Y-M-d H:i:s'); 
			$d2 = gmdate("Y-M-d H:i:s",time());
			$difference= strtotime($d1)-strtotime($d2);
			$hours = $difference / 3600; // 3600 seconds in an hour
			$minutes = ($hours - floor($hours)) * 60; 
			$final_hours = floor($hours);
			$final_minutes = round($minutes);

			$tz = new DateTimeZone($tmz);
			$trans = $tz->getTransitions(strtotime(date('Y-m-d')),strtotime(date('Y-m-d')));
			$daylight_saving = $trans[count($trans) - 1]['isdst'];

			if ($daylight_saving == '1'){
				if ($final_hours[0] != "-"){ $final_hours=$final_hours-1;  }
				else { $final_hours=$final_hours+1; }
			}
			if($final_hours > 0){ $final_hours = '+'. $final_hours; }
			$timeZone = '(GMT '.$final_hours.' h '.$final_minutes.' m )';
		}
		
		$ph_nums = $views_page->result[$i]->_field_data[nid][entity]->field_telephone_number[und][0][value];
		if (!empty($ph_nums)) {
			$ph_nums = str_replace('+','',$ph_nums);
			$ph_nums = str_replace('|',', ',$ph_nums);
			$ph_nums = str_replace('\'','',$ph_nums);
		}
		
		$fax_nums = $views_page->result[$i]->_field_data[nid][entity]->field_fax_number[und][0][value];
		if (!empty($fax_nums)) {
			$fax_nums = str_replace('+','',$fax_nums);
			$fax_nums = str_replace('|',', ',$fax_nums);
			$fax_nums = str_replace('\'','',$fax_nums);
		}
		
		$partnerList='';
		
		$title = $views_page->result[$i]->_field_data['nid']['entity']->title;
		$title = str_replace('\'', '', $title)
?>
  var website = '<?php echo $views_page->result[$i]->_field_data['nid']['entity']->field_website['und'][0]['value']; ?>';
  var email = '<?php echo $views_page->result[$i]->_field_data['nid']['entity']->field_email['und'][0]['value']; ?>';
  
  popupData = "<div class='openlayers-popup openlayers-tooltip-name'><ul class='wheretobuy_popup'><li class='head'><h2><?php echo $title; ?></h2></li></ul><ul class='content-pop'>";
  <?php if ($views_page->result[$i]->_field_data['nid']['entity']->field_contact_person['und'][0]['value'] != "") { ?>
  popupData += '<li><span class="wtb_label">Name</span> <?php echo addslashes($views_page->result[$i]->_field_data['nid']['entity']->field_contact_person['und'][0]['value']); ?></li>';
  <?php } ?>
  <?php if ($ph_nums != "") { ?>
  popupData += '<li><span class="wtb_label">Tel</span> <?php echo $ph_nums; ?></li>';
  <?php } ?>
  <?php if ($fax_nums != "") { ?>
  popupData += '<li><span class="wtb_label">Fax</span> <?php echo $fax_nums;?></li>';
  <?php } ?>
  if (email != "") {
	popupData += '<li><span class="wtb_label">Email</span> <a href="mailto:'+ email +'">'+ email +'</a></li>';
  }
  if (website != "") {
	popupData += '<li><span class="wtb_label">Site</span><a href="http://'+ website +'" target="_blank"> '+ website +'</a></li>';
  }
  <?php if ($timeZone != "") { ?>
  popupData += '&nbsp;<li><span class="wtb_label">Time Zone</span> <?php echo $timeZone; ?> </li>';
  <?php } ?>
  popupData += '</ul>';
  popupData += '</div>';
	  data.push({
      lon: <?php echo $views_page->result[$i]->_field_data['nid']['entity']->field_location['und'][0]['lon']; ?>,
      lat: <?php echo $views_page->result[$i]->_field_data['nid']['entity']->field_location['und'][0]['lat']; ?>,
      h:   '',
      d:   popupData
    });
  <?php } ?>
  window.mapData = data;
</script>
<div class="map-nav">
		  <?php $sales_url = $base_url.'/modal_forms/nojs/webform/53';?>

                <ul class="col-1">
                  <li><a href="<?php print $base_url.'/retailer-partners';?>">A-Z Listing <span class="ui-icon arrow">&nbsp;</span></a></li>
                  <li><a class="colorbox-inline" href="?width=610&amp;height=460&amp;inline=true#webformcontent">Sales Enquiry Form <span class="ui-icon arrow">&nbsp;</span></a></li>
				 
				  <li><a href="<?php print $base_url.'/pricing-plans'; ?>">Pricing<span class="ui-icon arrow">&nbsp;</span></a></li>
				  <li><a href="<?php print $base_url.'/become-a-partner'; ?>">Become a Partner<span class="ui-icon arrow">&nbsp;</span></a></li>
                </ul>
               
				<ul class="col-2">
	                  <li>Share it</li>
					  <li>
					  <a href="http://www.facebook.com/sharer.php?u=<?php print curPageURL();?>" target="_blank" class="ui-icon facebook"></a>
	 <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php print curPageURL();?>&amp;title=Thuraya" target="_blank" class="ui-icon in"></a>
	 <a href="http://www.twitter.com/home?status=<?php print "Thuraya-".curPageURL();?>" class="ui-icon twiter" target="_blank"></a> 
				</li>
				</ul>
             </div>		
     </div>

<?php
  $block1 = module_invoke('block', 'block_view', 13);
  $b1_title = block_load('block', '13'); 
  $block2 = module_invoke('block', 'block_view', 14);
  $b2_title = block_load('block', '14'); 
  $block3 = module_invoke('block', 'block_view', 15);
  $b3_title = block_load('block', '15'); 
?>
<div class="content-bt">
   <?php print views_embed_view('retailer_banner','block'); ?>
</div>
</div>
    </div>
	</div>
<div style="display:none">
	<div id="webformcontent">
		<?php
			$formnode = node_load('53');					
			webform_node_view($formnode,'full');
			print theme_webform_view($formnode->content);
		?>
	</div>
</div>
   </div>
  </div>
     </div>
  </div>
  <!--  /Content Section -->
  <!-- Footer -->
  <?php print $mod_footer;?>
  <!-- /Footer -->
</div>
