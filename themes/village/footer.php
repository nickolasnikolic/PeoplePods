<?php
/***********************************************
* This file is part of PeoplePods
* (c) xoxco, inc  
* http://peoplepods.net http://xoxco.com
*
* theme/footer.php
* Defines what is in the footer of every page, used by $POD->footer()
*
* Documentation for this pod can be found here:
* http://peoplepods.net/readme/themes
/**********************************************/
?>

		<div class="clearer"></div>
	</section> <!-- main -->
	<footer class="grid">
		<div class="column_4">
			<div>
				By using this site you agree to not be lame.
			</div>
		</div>
		<div class="column_4">
			<div style="text-align: center;">
				Proudly powered by <a href="http://peoplepods.net" title="PeoplePods">PeoplePods</a>
			</div>
		</div>
		<div class="column_4">
			<div>
				<a href="<?php $POD->siteRoot(); ?>">Home</a>
				<?php if ($POD->libOptions('enable_contenttype_document_list')) { ?> | <a href="<?php $POD->siteRoot(); ?>/show">What's New?</a><?php } ?>
				<?php if ($POD->libOptions('enable_core_groups')) { ?> | <a href="<?php $POD->siteRoot(); ?>/groups">Groups</a><?php } ?>
				<?php if ($POD->isAuthenticated()) { ?>
					<?php if ($POD->currentUser()->get('adminUser')) { ?>
						| <a href="<?php $POD->podRoot(); ?>/admin">Admin Tools</a>
					<?php } ?>
				<?php } ?>	
			</div>
		</div>
		<div class="clearer"></div>
	</footer>
</body>
</html>
