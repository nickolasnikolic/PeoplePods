<?php

	// this pod creates static pages
	include_once("content_type.php"); // this defines some variables for use within this pod

	$POD->registerPOD(
		"unknown_page_404_error",											// name
		"Unknown Page 404 Error",									// description
		array("^{$permalink}/(.*)"=> $pod_dir . '/view.php?stub=$1'),	// rewrite rules
		array(
			"content_permalink_{$content_type}"=>"/$permalink/{this.stub}",
			"content_editlink_{$content_type}"=>"/peoplepods/admin/content/?id={this.id}",
			"content_editpath_{$content_type}"=>"/peoplepods/admin/content/",
		)		// global variables
	);

?>