<?php
$vl = '';
if(!empty($content['field_timezone'])){	
 $dateTime = new DateTime();
 $d2 = gmdate("Y-M-d H:i:s",time());
 $dateTime->setTimeZone(new DateTimeZone($node->field_timezone['und'][0]['value']));
 $d1 = $dateTime->format('Y-M-d H:i:s'); 
 $difference= strtotime($d1)-strtotime($d2);
 $hours = $difference / 3600; 
$minutes = ($hours - floor($hours)) * 60; 
 $final_hours = floor($hours);
 $final_minutes = round($minutes);
 $vl = $final_hours.'hours'.$final_minutes.' mnts ';
}
?>
<?php //print_r($node->field_timezone); ?>
<?php
$nodepartnerTier = $node->field_partner_tier['und'];
foreach($nodepartnerTier as $key=>$value){
	$x = $value['value'];
	$tiers["$x"] = $value['value']; 	
}
$all_fields = field_info_fields();
$partnertier = list_allowed_values($all_fields["field_partner_tier"]);
$tierimages = array_intersect_key($partnertier, $tiers);
?>
<table cellspacing='3' border='0'>
<tr><td><b>Company Name</b></td>
<td>
<?php print $title; 
 if(!empty($content['field_company_logo'])){print ' '.render($content['field_company_logo']);}?>

</td></tr>
<tr><td><b>Address</b></td><td>				
<?php print render($content['field_address']);?></td></tr>

<tr><td><b>Email</b></td><td>				
<?php print render($content['field_email']);?></td></tr>

<tr><td><b>Website</b></td><td>				
<?php print render($content['field_website']);?></td></tr>

<tr><td><b>Contact Person</b></td><td>				
<?php print render($content['field_contact_person']);?></td></tr>

<tr><td><b>Tel</b></td><td>				
<?php print render($content['field_telephone_number']);?></td></tr>

<tr><td><b>Products</b></td><td>				
<?php print render($content['field_products']);?></td></tr>

<tr><td><b>Partner Tier</b></td><td>				
<?php foreach ($tierimages as $key => $value) {
	echo $value.'</br>';
}?></td></tr>

<tr><td><b>skype</b></td><td>				
<?php print render($content['field_skype']);?></td></tr>
<tr><td><b>Location</b></td><td>				
<?php print render($content['field_location']);?></td></tr>
<tr><td><b>Timezone</b></td><td>				
<?php print render($content['field_timezone']);?></td></tr>
<tr><td><b>GMT DIFF</b></td><td>				
<?php print $vl;?></td></tr>

<tr><td><b>Other Details</b></td><td>				
<?php print render($content['field_other_details']);?></td></tr>

</table>
