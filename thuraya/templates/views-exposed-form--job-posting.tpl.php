<div class="job_listing">
<?php
$i=1;
foreach ($widgets as $id => $widget): 
if($i=='1'){
?>
<div class="vac-text">Vacancies</div>
<div class="select_box"> <span class="select selectbox-bg" id="vacancies_filter">Filter</span>
                            <label for="vac_filters">Filter</label>
                            
                          </div>

<?php } else {?>
	  <div class="vac-text">Vacancies Search</div>
<?php }
print $widget->widget; 
$i++;
endforeach; 
print $button; ?>
</div>