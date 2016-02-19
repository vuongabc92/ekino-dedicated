<?php
$countryId = '%';
$productId = '%';
$partnerTier = '%';
$company = '%';

if(isset($_GET['submit'])){
	if($_GET['field_address_country'] != 'All')
		$countryId = $_GET['field_address_country'];

	if($_GET['field_products_nid'] != 'All')
		$productId = $_GET['field_products_nid'];

	if($_GET['field_partner_tier_value'] != 'All')
		$partnerTier = $_GET['field_partner_tier_value'];

	if($_GET['title'] != '')
		$company = '%'.$_GET['title'].'%';
}

global $base_url;
$image = $base_url.'/sites/all/themes/thuraya/images/babble.png';
?>
<script type="text/javascript"
src="http://maps.google.com/maps/api/js?sensor=false&libraries=drawing"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	initialize();
	var mybounds;
	function initialize() {
		mybounds = new google.maps.LatLngBounds();
		map = new google.maps.Map(document.getElementById('map'), {
			zoom: 2,
			center: new google.maps.LatLng(5.6856414, 16.4596186),
			scrollwheel: false,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			disableDefaultUI: true,
			zoomControl: true,
		    panControl: true
		});
		var data = jQuery('#mapdata').html();
		//alert(data);		
		obj = JSON.parse(data);
		if(obj.marker == undefined){
			jQuery('#nomap').show();
			jQuery('#map').hide();
		} else {
			jQuery('#nomap').hide();
			jQuery('#map').show();			
			buildOverlays(obj);
			map.fitBounds(mybounds);
		}
	}
		
	function buildOverlays(data) {
		var image = '<?php print $image;?>';	
		
		for(var i in data.marker) {
			center = data.marker[i].position.split(',');
			myLatLng = new google.maps.LatLng(center[0], center[1]);
			mybounds.extend(myLatLng);
			//alert(myLatLng);
			var beachMarker = new google.maps.Marker({
				position: myLatLng,
				draggable:false,
				id: data.marker[i].nid,
				map: map,
				icon: image
			});
		//beachMarker.setTitle((i + 1).toString());
		//var msg = data.marker[i].title +','+data.marker[i].tel;
		
		/*var beachMarker = new google.maps.Circle({
            center:myLatLng,
            clickable:true,
            fillColor:'#2E64FE',
            fillOpacity:0.3, 
            map:map,
            radius:8,
            strokeColor:'#FFFFFF',
            strokeOpacity:0.3});*/
		
		var msg=	
		'<ul class="wheretobuy_popup"><li class="head"><h2>'+data.marker[i].title+'</h2></li></ul><ul class="content-pop">';
		if(data.marker[i].tel != null)
			msg+='<li><span class="wtb_label">Tel</span>'+data.marker[i].tel+'</li>';
		if(data.marker[i].fax != null)
			msg+='<li><span class="wtb_label">Fax</span>'+data.marker[i].fax+'</li>';
		if(data.marker[i].email != null)
			msg+='<li><span class="wtb_label">Email</span><a href="mailto:'+data.marker[i].email+'">'+data.marker[i].email+'</a></li>';
		if(data.marker[i].website != null)
			msg+='<li><span class="wtb_label">Website</span><a target="_blank" href="http://'+data.marker[i].website+'">'+data.marker[i].website+'</a></li>';
		if(data.marker[i].timezone != "")
			msg+='<li><span class="wtb_label">Time Zone</span>'+data.marker[i].timezone+'</li>';
		
		msg += '</ul>';
		
		if(data.marker[i].partner != null){	
			var pt_value = data.marker[i].partner.split(',');
			var m ='';
			
			for(k in pt_value){
				//console.log(pt_value[k]);
				if(pt_value[k] == 'ldg'){
				 m +='<span class="ui-icon gold"></span>Land Data';
				} else if(pt_value[k]  == 'lds'){
				 m +='<span class="ui-icon silver"></span>Land Data';
				} else if(pt_value[k]  == 'ldb'){
				 m +='<span class="ui-icon bronze"></span>Land Data';
				} else if(pt_value[k] == 'lvg'){
				 m +='<span class="ui-icon gold"></span>Land Voice';
				} else if(pt_value[k]  == 'lvs'){
				 m +='<span class="ui-icon silver"></span>Land Voice';
				} else if(pt_value[k]  == 'lvb'){
				 m +='<span class="ui-icon bronze"></span>Land Voice';
				} else if(pt_value[k]  == 'mg'){
				 m +='<span class="ui-icon gold"></span>Maritime';
				} else if(pt_value[k]  == 'ms'){
				 m +='<span class="ui-icon silver"></span>Maritime';
				} else if(pt_value[k]  == 'mb'){
				 m +='<span class="ui-icon bronze"></span>Maritime';
				} 
			}
			msg+='<div class="bottom_popup">'+m+'</div>';
		}
		attachSecretMessage(beachMarker, 0, msg, myLatLng);
	}

	function attachSecretMessage(marker, num, msg, myLatLng) {
		//console.log("lang="+myLatLng);
		var infowindow = new google.maps.InfoWindow({
			position: myLatLng,
			content:msg,
			maxWidth: 400
		});

		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(marker.get('map'), marker);
		});
	}			
    }
	
});
</script>
<div class="careers generic">
  <div class="colums">
	<div class="col2" style="width:100%;">
	  <div class="in-container">
		<h1><?php print $title; ?></h1>
		<?php if($node->field_short_description): ?>
		<h2><?php print($node->field_short_description[$node->language][0]["safe_value"]);?></h2>
		<?php endif; ?>	
		<div class="content">
			
			<div id="search-area">
			<form name="frmWheretoBuy" method="GET">
				<div class="col-1">
				<ul>
					<li>
					<div class="select_box">
					<span id="regionbox" class="select selectbox-bg">Region/Country</span>
					<label>Region/Country</label>
					</div>
		            <div class="form-item">
					<?php
						$countriesList = get_countries_list();
					?>
					<select id="edit-field-address-country" name="field_address_country" class="form-select">
						<option value="All">Region/Country</option>
						<?php
						foreach($countriesList as $key => $value){
							print '<option value="'.$key.'">'.$value.'</option>';
						}
						?>
					</select>
					</div>
					</li>
					<li>
						<div class="select_box">
						<?php
							$productsList = node_load_multiple(array(), array('type' => 'product')); 
							//print "<pre>"; print_r($productsList); exit;
						?>
						<span id="productsbox" class="select selectbox-bg">Products</span>
						<label>Products</label>
						</div>
						<div class="form-item">
						<select id="edit-field-products-nid" name="field_products_nid" class="form-select"><option value="All">Products</option>
						<?php foreach ($productsList as $key => $value):
							if($value->status == 1): ?>
						<option value="<?php print $value->nid; ?>"><?php print $value->title; ?></option>
						<?php 
							endif;
							endforeach; ?>
						</select>
						</div>
					</li>
					<li>
					   <div class="select_box">
					   <span id="Partnerbox" class="select selectbox-bg">Partner tier</span>
						<label>Partner tier</label>
						</div>
						<div class="form-item">
						<select id="edit-field-partner-tier-value" name="field_partner_tier_value" class="form-select"><option value="All">Partner tier</option><option value="ldg">Land Data Gold</option><option value="lds">Land Data Silver</option><option value="ldb">Land Data Bronze</option><option value="lvg">Land Voice Gold</option><option value="lvs">Land Voice Silver</option><option value="lvb">Land Voice Bronze</option><option value="mg">Maritime Gold</option><option value="ms">Maritime Silver</option><option value="mb">Maritime Bronze</option></select>
						</div>
					</li>
					<li>
						<div class="form-item">
						<input type="text" id="edit-title" name="title" value="" size="30" maxlength="128" class="form-text">
						</div>
					</li>
                </ul>
            </div>
			<div class="col-2">
			<input type="submit" id="edit-submit-where-to-buy" name="submit" value="Apply" class="form-submit">      
			</div>
			</form>
			</div>
			<div id="mapdata" style="display:none;">
			<?php print getMapLocations($countryId, $productId, $partnerTier, $company); ?>			
			</div>
			<div id="map" style="width: 100%; height: 500px"></div>
			<div id="nomap" style="display:none;">There are currently no Thuraya Service Partners in this location. Please <a href='/contact-us'>contact</a> us and we would be pleased to refer you to a Service Partner located closest to you. If you are interested in becoming a Thuraya Service Partner, please <a href='/become-a-partner'>contact us</a>.</div>
		</div>
		<div class="sn-links">
				<ul class="ul-sn">
				<li class="new-medium">Share it</li>
				<li>					
					<a href="http://www.facebook.com/sharer.php?u=<?php print curPageURL();?>" target="_blank" class="ui-icon facebook"></a>
					<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php print curPageURL();?>&amp;title=<?php print urlencode($node->title);?>&summary=<?php echo getNodeTeaser($node);?>" target="_blank" class="ui-icon in"></a>
					<a href="http://www.twitter.com/home?status=<?php print "Thuraya-".curPageURL();?>" class="ui-icon twiter" target="_blank"></a>
			   </li>
			  </ul>
			</div>
	  </div>
	</div>                
  </div>
</div>
