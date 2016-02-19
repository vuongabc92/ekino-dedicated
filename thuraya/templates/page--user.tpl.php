<?php global $user,$base_url;?>

<div class="ui-page">
  <!--  Header Section -->
<?php  print $mod_header;?>
  <!--  /Header Section -->
  <!--  Content Section -->
  <div class="ui-content">
  <div class="media-solutions-bg career2">
  <div class="solutions-details">
  <div class="main-container">
    <!-- Solutions  -->


   <?php
   if(arg(0)=='user' && arg(1)!='register' && arg(2)!='edit'){
	   $class = 'login-register';
	   $a1 = 'active';
	} else if(arg(1)=='register' || arg(0)=='applications' || arg(2)=='edit'){
      $class = 'register';
	} else if(arg(0)=='careers'){
      $class = 'careers';
	  	   $a2 = 'active';
	}  else if(arg(0)=='careers'){
      $class = 'careers';
	  	   $a3 = 'active';
	}

	if(arg(2)=='edit'){
		$a4='active';
	}
	if(arg(0)=='applications'){
		$a5='active';
	}
   ?>
   <?php print render($page['highlighted']); ?>
	<?php $breadcrumb=str_replace('href="//"','href="/"',$breadcrumb); ?>
      <div class="breadcrumbs"><?php print $breadcrumb; ?></div>
      <div class="<?php print $class;?>">
      <div class="columns">

          <div class="col1">
                  <div class="in-container">
                    <div class="left-menu">
					<?php if($user->uid!=''){?>
					<h1>Welcome <br><span class="name"><?php print $user->name;?></span></h1>
					<?php }?>
                      <ul>
 						<?php if($user->uid==''){?>
                        <li class="<?php print $a1;?>">
						<a href="<?php print $base_url;?>/user">
                        <span class="login ui-icon">
						</span>LOGIN<span class="ui-icon left-arrow"></span></a>
						</li>
						<?php } ?>

                        <li class="<?php print $a2;?>"><a href="<?php print $base_url.'/careers';?>">
                        <span class="job-listing ui-icon"></span>JOBS<span class="ui-icon left-arrow"></span></a></li>
						<?php if($user->uid!=''){?>
						<li class="<?php print $a5;?>"><a href="<?php print $base_url.'/applications/'.$user->uid;?>">
                        <span class="login ui-icon"></span>MY APPLICATIONS<span class="ui-icon left-arrow"></span></a></li>

						<li class="<?php print $a4;?>"><a href="<?php print $base_url.'/user/'.$user->uid.'/edit/main';?>">
                        <span class="my-profile ui-icon"></span>EDIT MY PROFILE<span class="ui-icon left-arrow"></span></a></li>
						<li><a href="<?php print $base_url;?>/user/logout">
                        <span class="logout ui-icon"></span>LOGOUT<span class="ui-icon left-arrow"></span></a></li>
						<?php } ?>

                      </ul>
                    </div>
                  </div>
                </div>
          <div class="col2">
            <?php print $messages;
             print render($page['help']); ?>
            <?php if ($action_links): ?>
              <ul class="action-links"><?php print render($action_links); ?></ul>
            <?php endif; ?>
            <?php print render($page['content']); ?>
          </div>
</div>
</div>
</div>

  </div>
  </div>
  </div>
  <!--  /Content Section -->
  <!-- Footer -->
  <?php  print $mod_footer;?>
<!-- /Footer -->
</div>
