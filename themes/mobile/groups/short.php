<?php
/***********************************************
* This file is part of PeoplePods
* (c) xoxco, inc  
* http://peoplepods.net http://xoxco.com
*
* theme/groups/short.php
* Default short output template for group objects
* Used in lists of groups
*
* Documentation for this pod can be found here:
* http://peoplepods.net/readme/group-object
/**********************************************/
?>
<li class="group">
	<header class="group_name">
		<h1><?php $group->permalink(); ?></h1>
	</header>
	<article class="group_description">
			<?php $group->writeFormatted('description'); ?>	
	</article>
	<aside class="group_member_count">
		<?php echo $POD->pluralize($group->members()->totalCount(),'@number member','@number members'); ?>	| 
		<a href="<?php echo $group->permalink; ?>/join">Join</a>
	</aside>
	<div class="clearer"></div>
</li>