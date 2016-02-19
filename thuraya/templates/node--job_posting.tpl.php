
<div class="in-container">
<h1><?php print $title;?></h1>
<h2 class="border-bottom"></h2>
<div class="job-container">
<ul>
<?php if(!empty($node->field_proferred_national['und'][0]['value'])): ?>
 <h2>&nbsp;&nbsp;</h2>
			<li><?php print $node->field_proferred_national['und'][0]['value'];?></li>	

	<?php endif;?>
<?php if(!empty($node->field_category['und'][0]['value'])): ?>
<br/>
	<li>	
	<b>Division</b>:<?php print $node->field_category['und'][0]['value'];?></li>	
	 <?php endif; ?>
	
	<?php if(!empty($node->field_job_purpose['und'][0]['value'])): ?>
	<li>
	<h3><?php if(!empty($node->field_job_purpose_title['und'][0]['value'])){
	print $node->field_job_purpose_title['und'][0]['value'];} else{print 'Job Purpose';} ?></h3>
	</li>
		<li><?php print $node->field_job_purpose['und'][0]['value'];?></li>	
	 <?php endif; ?>

	
	<?php if(!empty($node->field_principal_accountabilities['und'][0]['value'])): ?>
	<li>
	<h3>
	<?php if(!empty($node->field_principal_account_title['und'][0]['value'])){
	print $node->field_principal_account_title['und'][0]['value'];} else{
		print 'Principal Accountabilities';} ?>	
	</h3>
	</li>
		<li class="cmsdata"><?php print $node->field_principal_accountabilities['und'][0]['value'];?></li>	
	 <?php endif; ?>

	
	<?php if(!empty($node->field_know_skills_experience['und'][0]['value'])): ?>
		<li>
	<h3>
	<?php if(!empty($node->field_know_skills_exp_title['und'][0]['value'])){
	print $node->field_know_skills_exp_title['und'][0]['value'];} else{
		print 'Knowledge Skills and Experience';} ?>
	</h3>
	</li>
		<li class="cmsdata"><?php print $node->field_know_skills_experience['und'][0]['value'];?></li>	
	 <?php endif; ?>	
</ul>
</div>
<div class="sn-links ">

	<?php
    // We hide the comments and links now so that we can render them later.
    hide($content['comments']);
    hide($content['links']);
      
      if ($user->uid) {
	  global $base_url;
	  //Added by Samy to show the apply button for the logged in and normal user.
	  $link = $base_url.'/'.$content['links']['comment']['#links'][0]['href'].'#'.$content['links']['comment']['#links'][0]['fragment'];
      //print render($content['links']); 
		echo "<a class='apply-btn' href=$link><span class='text'>Apply</span><span class='ui-icon plus'></span></a>";	  
	  } else {
		echo "<a class='apply-btn' href='/user'><span class='text'>Apply</span><span class='ui-icon plus'></span></a>";
	  }
  ?>

  <?php print render($content['comments']); ?>


<ul class="ul-sn">
	<li class="new-medium">Share it</li>
	<li>
	<a href="http://www.facebook.com/sharer.php?u=<?php print curPageURL();?>" target="_blank" class="ui-icon facebook"></a>
	<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php print curPageURL();?>&amp;title=<?php print urlencode($node->title);?>&summary=<?php echo getJobPostingNodeTeaser($node);?>" target="_blank" class="ui-icon in"></a>
	 <a href="http://www.twitter.com/home?status=<?php print "Thuraya-".curPageURL();?>" class="ui-icon twiter" target="_blank"></a> 
</li>
</ul>
</div>
<!-- End middle content --></div>

