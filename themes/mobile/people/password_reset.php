<?php
/***********************************************
* This file is part of PeoplePods
* (c) xoxco, inc  
* http://peoplepods.net http://xoxco.com
*
* theme/people/password_reset.php
* Used by the core_authentication pod to create the /password_reset page
*
* Documentation for this pod can be found here:
* http://peoplepods.net/readme/person-object
/**********************************************/
?>		
	<div id="login_join_form">
		
	<?php if ($user->get('resetCode')) { ?>	
		
		<!-- reset password form -->
		<h1>Reset Password</h1>
		
		<form method="post" action="<?php $POD->siteRoot(); ?>/password_reset" id="password_reset" class="valid">
			<input type="hidden" name="resetCode" value="<?php echo $_GET['resetCode']; ?>" />
			<p><label for="password">New Password:</label>
			<input id="password" name="password" class="required"></p>
			
			<p><label>&nbsp;</label><input type="submit" value="Reset Password" /></p>
		</form>
		

	<?php } else { ?>

		<!-- reset request form -->
		
		<h1>I forgot my password!</h1>
		
		<?php if ($user->get('msg')) { ?>
			<div class="info">
				<?php $user->write('msg'); ?>
			</div>
		<?php } ?>
	
		<form method="post" action="<?php $POD->siteRoot(); ?>/password_reset" id="password_reset" class="valid">
	
			<p>Which email address did you use when you signed up?</p>
			<p>
				<label for="email">Email:</label>
				<input id="email" name="email" class="required" />
			</p>
			
			<p><label>&nbsp;</label><input type="submit" value="Reset My Password" /></p>
		
		</form>
		
	<?php } ?>

	</div>