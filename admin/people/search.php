<?php 
	include_once("../../PeoplePods.php");		
	$POD = new PeoplePod(array('debug'=>0,'lockdown'=>'adminUser','authSecret'=>@$_COOKIE['pp_auth']));
	$POD->changeTheme('admin');
	

	$result_mode = 'fullscreen';
	if (isset($_GET['result_mode'])) {
		$result_mode = $_GET['result_mode'];
	}
	
	$mode = '';
	$q = '';

	if (isset($_GET['q'])) { 
		$q = $_GET['q'];
	}
	if (isset($_GET['mode'])) { 
		$mode = $_GET['mode'];
	}
	$offset = 0;
	if (isset($_GET['offset'])) { $offset = $_GET['offset']; }
	if ($q) {
			
		$users = $POD->getPeople(array('nick:like'=>"%$q%"));
		if ($users->count() == 1 && $result_mode=="fullscreen") {
			print header("Location: index.php?id=" . $users->getNext()->get('id'));
		} else if ($users->count() == 0) {	
			$message = "No user found";
		} else {
			$message = $users->count() . " members found";
		}
		$mode = "search";
	} else if ($mode == "" || $mode=="last") {
	
		$users = $POD->getPeople(array('1'=>1),'lastVisit DESC',24,$offset);
		$title = "Recent Visitors";
		$mode = "last";
	} else if ($mode == "newest") { 
		$users = $POD->getPeople(array('1'=>1),'memberSince DESC',24,$offset);
		$title = "Newest Members";
	
	
	}


	if ($result_mode=="fullscreen") { 
		$POD->header();
		
		 include("tools.php"); ?>	

		<div class="list_panel">
			<h1><?php echo $title; ?></h1>
	
				<?php $users->output('short_grid','people_header','table_pager',null,'No people found'); ?>
				
		</div>			
	
		<?php

		$POD->footer();
	
} else {
		
		if (isset($message)) { ?>
		
			<div class="info">
				<?php echo $message; ?>
			</div>
		
		<?php } 
		
		if ($users->count() > 0 ) { ?>

		<?php	 while ($user = $users->getNext()) { 
			 	$user->output('addMember');
			 }
				 
		} else {
			echo '<h3 class="column_padding">Oops, no people found.</h3>';
		}
		
		
		
		
} 


