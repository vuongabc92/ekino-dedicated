<?php
global $base_url;
unset($form['name']['#title']);
unset($form['name']['#description']);
unset($form['pass']['#title']);
unset($form['pass']['#description']);
?>
<div class="in-container">
<ul>
<li>
<h2>Login</h2>
<ul>
<li><p>Already registered? Please enter your user details below:</p></li>
<li><?php print render($form['name']);?></li>
<li><?php print render($form['pass']);?></li>
<li class="btn-log">
<?php print render($form['actions']);?>
</li>
<li>
Forgot Password, <a href="<?php print $base_url.'/user/password';?>"><b>Click here</b></a>
</li>
<div style="display:none;">
<?php print drupal_render_children($form); ?>
</div>
</ul>
</li>
<li>
		<h2>Register</h2>
		<ul>
			<li><p>If you have not created a profile with Thuraya before, click on link below to begin the process.</p></li><li>
			 </li><li class="btn-reg"><a href='<?php print $base_url;?>/user/register'><input type="Register now" onClick="document.location.href='<?php print $base_url;?>/user/register'" value="Register now" name="op" class="btn-register" id="Login1"></a></li>
		</ul>
	</li>
</ul>
</div>