<?php
/***********************************************
* This file is part of PeoplePods
* (c) xoxco, inc  
* http://peoplepods.net http://xoxco.com
*
* theme/stacks/footer.php
* Default header used by $stack->output()
*
* Documentation for this pod can be found here:
* http://peoplepods.net/readme/stack-output
/**********************************************/
?>
	<?php if ($this->count() == 0) { ?>
		<li class="empty_list">
			<?php if (isset($empty_message)) {
				echo $empty_message; 
			} else { ?>
				Nothing to show!
			<?php } ?>
		</li>
	<?php } ?>
</ul>
</section>