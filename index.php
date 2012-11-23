<?php
/***********************************************
 * This file is part of PeoplePods
 * (c) xoxco, inc
 * http://PeoplePods.net http://xoxco.com
 *
 * /index.php
 * This file just redirects to the admin or install tools
 /**********************************************/
//todo trying out the excellent moor library to help out (simplify and flexify) the routing issues of this project
//also has the benefit of being able to slowly tailor it to the current PeoplePods implementation
//the approach is to hardwire requests to this directory through http, while allowing the previous implementation
//using a predominantly .htaccess-based page controller still function in the direcotry above; for now.
//to start, I hope to match the current PeoplePods implementation use of .htaccess
//then replace it completely with this more flexible and robust option in time
require_once ("lib/moor/Moor.php");
require_once ("PeoplePods.php");

//immediately create a $POD object to test against
$POD = new PeoplePod( array("authSecret" => @$_COOKIE["pp_auth"] ));

//immediately set a handler for pages not routed by either .htaccess or in Moor
Moor::setNotFoundCallback('default404');
//Moor::enableDebug(  );

//test
/*if ($POD -> success(  )) {
	//send to dashboard using .htaccess route
	header( "Location: dashboard");
	exit;
} else {
	//header( "install");//todo it might just be worth removing the install directory after first installation
	header( "Location: unauthorized");
	exit;
}*/


//set up cursory routes for testing

//current routing table through .htaccess is as follows:
/*
 * # BEGIN PeoplePods RULES
 #####################################
 # turn the RewriteEngine on so that these fancy rewrite rules work
 RewriteEngine On

 RewriteRule ^edit$	/PeoplePods/pods/core_usercontent/edit.php	[QSA,L] # contenttype_document_add
 RewriteRule ^show$	/PeoplePods/pods/core_usercontent/list.php	[QSA,L] # contenttype_document_list
 RewriteRule ^show/(.*)	/PeoplePods/pods/core_usercontent/view.php?stub=$1	[QSA,L] # contenttype_document_view
 RewriteRule ^api/2/(.*)	/PeoplePods/pods/core_api_simple/index_version2.php?method=$1	[QSA,L] # core_api_simple
 RewriteRule ^api$	/PeoplePods/pods/core_api_simple/index_version1.php	[QSA,L] # core_api_simple
 RewriteRule ^join	/PeoplePods/pods//core_authentication/join.php	[QSA,L] # core_authentication_creation
 RewriteRule ^verify	/PeoplePods/pods/core_authentication/verify.php	[QSA,L] # core_authentication_creation
 RewriteRule ^login	/PeoplePods/pods/core_authentication/login.php	[QSA,L] # core_authentication_login
 RewriteRule ^logout	/PeoplePods/pods/core_authentication/logout.php	[QSA,L] # core_authentication_login
 RewriteRule ^password_reset/(.*)	/PeoplePods/pods/core_authentication/password.php?resetCode=$1	[QSA,L] # core_authentication_login
 RewriteRule ^password_reset$	/PeoplePods/pods/core_authentication/password.php	[QSA,L] # core_authentication_login
 RewriteRule ^$	/PeoplePods/pods/dashboard/index.php	[QSA,L] # core_dashboard
 RewriteRule ^replies	/PeoplePods/pods/dashboard/index.php?replies=1	[QSA,L] # core_dashboard
 RewriteRule ^feeds/(.*)	/PeoplePods/pods/core_feeds/feed.php?args=$1	[QSA,L] # core_feeds
 RewriteRule ^lists/(.*)	/PeoplePods/pods/core_feeds/list.php?args=$1	[QSA,L] # core_feeds
 RewriteRule ^lists$	/PeoplePods/pods/core_feeds/list.php	[QSA,L] # core_feeds
 RewriteRule ^feeds$	/PeoplePods/pods/core_feeds/feed.php	[QSA,L] # core_feeds
 RewriteRule ^files/(.*)/(.*)	/PeoplePods/pods/core_files/index.php?id=$1&size=$2	[QSA,L] # core_files
 RewriteRule ^friends$	/PeoplePods/pods/core_friends/index.php	[QSA,L] # core_friends
 RewriteRule ^friends/(.*)	/PeoplePods/pods/core_friends/index.php?mode=$1	[QSA,L] # core_friends
 RewriteRule ^groups$	/PeoplePods/pods/core_groups/index.php	[QSA,L] # core_groups
 RewriteRule ^groups/(.*)/(.*)	/PeoplePods/pods/core_groups/group.php?stub=$1&command=$2	[QSA,L] # core_groups
 RewriteRule ^groups/(.*)	/PeoplePods/pods/core_groups/group.php?stub=$1	[QSA,L] # core_groups
 RewriteRule ^invite	/PeoplePods/pods/core_invite/index.php	[QSA,L] # core_invite
 RewriteRule ^pages/(.*)	/PeoplePods/pods/core_pages/view.php?stub=$1	[QSA,L] # core_pages
 RewriteRule ^inbox$	/PeoplePods/pods/core_private_messaging/inbox.php	[QSA,L] # core_private_messaging
 RewriteRule ^inbox/conversationwith/(.*)	/PeoplePods/pods/core_private_messaging/thread.php?username=$1	[QSA,L] # core_private_messaging
 RewriteRule ^people/(.*)	/PeoplePods/pods/core_profiles/profile.php?username=$1	[QSA,L] # core_profiles
 RewriteRule ^editprofile	/PeoplePods/pods/core_profiles/editprofile.php	[QSA,L] # core_profiles
 RewriteRule ^search	/PeoplePods/pods/core_search/search.php	[QSA,L] # core_search
 RewriteRule ^openid$	/PeoplePods/pods/openid_connect/index.php	[QSA,L] # openid_connect
 RewriteRule ^openid/(.*)	/PeoplePods/pods/openid_connect/index.php?mode=$1	[QSA,L] # openid_connect

 #####################################
 # END PeoplePods RULES
 * */

//get the directory to which we need to send redirects
$siteRoot = $POD->siteInstallRoot( FALSE );
 
Moor::
	setUrlPrefix( $siteRoot )->
	route("/", "dashboard") -> //needs to go to /PeoplePods/pods/dashboard/index.php	[QSA,L] # core_dashboard
	route("/dashboard", "dashboard") -> //needs to go to /PeoplePods/pods/dashboard/index.php	[QSA,L] # core_dashboard //alius of dashboard
	//the following is a slight modification of dashboard path, but the url is used quite a bit //todo rectify and simplify this following path
	route("/replies", "replies") -> //needs to go to /PeoplePods/pods/dashboard/index.php?replies=1	[QSA,L] # core_dashboard 
	route("/unauthorized", "unauthorized") -> //needs to go to /PeoplePods/pods/unauthorized_landing_page/index.php
	route("/authentication", "authentication") -> //needs to go to
	route("/login", "login") -> //needs to go to /PeoplePods/pods/core_authentication/login.php	[QSA,L] # core_authentication_login
	route("/logout", "logout") -> //needs to go to /PeoplePods/pods/core_authentication/logout.php	[QSA,L] # core_authentication_login
	route("/password_reset/:resetCode", "passReset") -> //needs to go to /PeoplePods/pods/core_authentication/password.php?resetCode=$1	[QSA,L] # core_authentication_login
	route("/password_reset", "passReset") -> //needs to go to /PeoplePods/pods/core_authentication/password.php	[QSA,L] # core_authentication_login
	route("/join", "joinUs") -> //needs to go to /PeoplePods/pods/core_authentication/join.php	[QSA,L] # core_authentication_creation
	route("/verify", "verify") -> //needs to go to /PeoplePods/pods/core_authentication/verify.php	[QSA,L] # core_authentication_creation
	route("/edit", "edit") -> //needs to go to /PeoplePods/pods/core_usercontent/edit.php	[QSA,L] # contenttype_document_add
	route("/show", "content") -> //needs to go to /PeoplePods/pods/core_usercontent/list.php	[QSA,L] # contenttype_document_list
	route("/show/:stub", "content") -> //needs to go to /PeoplePods/pods/core_usercontent/view.php?stub=$1	[QSA,L] # contenttype_document_view
	route("/files/:id/:size", "files") -> //needs to go to /PeoplePods/pods/core_files/index.php?id=$1&size=$2	[QSA,L] # core_files
	route("/files", "files") -> 
	route("/friends", "friends") ->
	route("/feeds/:args", "feeds") -> //needs to go to /PeoplePods/pods/core_feeds/feed.php?args=$1	[QSA,L] # core_feeds
	route("/feeds", "feeds") -> //needs to go to /PeoplePods/pods/core_feeds/feed.php	[QSA,L] # core_feeds
	route("/lists/:args", "listFeeds") -> //needs to go to /PeoplePods/pods/core_feeds/list.php?args=$1	[QSA,L] # core_feeds
	route("/lists", "listFeeds") -> //needs to go to /PeoplePods/pods/core_feeds/list.php	[QSA,L] # core_feeds
	route("/groups", "groups") -> 
	route("/groups/:stub/:command", "groups") -> //needs to go to /PeoplePods/pods/core_groups/group.php?stub=$1&command=$2	[QSA,L] # core_groups
	route("/groups/:stub", "groups") -> //needs to go to /PeoplePods/pods/core_groups/group.php?stub=$1	[QSA,L] # core_groups
	route("/groups", "groups") -> //needs to go to /PeoplePods/pods/core_groups/index.php	[QSA,L] # core_groups
	route("/invite", "invite") -> //needs to go to /PeoplePods/pods/core_invite/index.php	[QSA,L] # core_invite
	route("/pages", "pages") -> 
	route("/pages/:stub", "view") -> //needs to go to /PeoplePods/pods/core_pages/view.php?stub=$1	[QSA,L] # core_pages
	route("/patients", "patients") -> 
	route("/pm", "private_messaging") -> 
	route("/inbox/conversationwith/:username", "conversation") -> //needs to go to /PeoplePods/pods/core_private_messaging/thread.php?username=$1	[QSA,L] # core_private_messaging
	route("/inbox", "inbox") -> //needs to go to /PeoplePods/pods/core_private_messaging/inbox.php	[QSA,L] # core_private_messaging
	route("/people/:username", "profile") -> //needs to go to /PeoplePods/pods/core_profiles/profile.php?username=$1	[QSA,L] # core_profiles
	route("/editprofile", "editProfile") -> //needs to go to /PeoplePods/pods/core_profiles/editprofile.php	[QSA,L] # core_profiles
	route("/search", "search") -> //needs to go to /PeoplePods/pods/core_search/search.php	[QSA,L] # core_search
	route("/content", "user_content") -> 
	route("/dashboard/:healer", "healer_dashboard") -> //fixme work out this path and its handling
	route("/fb", "fb_connect") -> 
	route("/gravatars", "gravatars") -> 
	route("/landing_page", "landing_page") -> 
	route("/openid/:mode", "openId") -> //needs to go to /PeoplePods/pods/openid_connect/index.php?mode=$1	[QSA,L] # openid_connect
	route("/openid", "openId") -> //needs to go to /PeoplePods/pods/openid_connect/index.php	[QSA,L] # openid_connect
	route("/placekitten", "placekitten") -> 
	route("/twitter", "twitter") -> 
	route("/friends/:mode", "friends") -> //needs to go to /PeoplePods/pods/core_friends/index.php?mode=$1	[QSA,L] # core_friends
	route("/friends", "friends") -> //needs to go to /PeoplePods/pods/core_friends/index.php	[QSA,L] # core_friends
	route("/admin/:id/", "admin") -> 
	route("/api", "api1") -> //needs to go to /PeoplePods/pods/core_api_simple/index_version1.php	[QSA,L] # core_api_simple
	route("/api/:whichOne/:method", "api2") -> //needs to go to /PeoplePods/pods/core_api_simple/index_version2.php?method=$1	[QSA,L] # core_api_simple
	route("/tos", "terms_of_service" )-> //cursory terms of service link
	route("/install", "install") -> //todo needs to go to /PeoplePods/install/, but only the first run though...
run();

function dashboard(  ) {
	//header( "Location: /test/PeoplePods/pods/dashboard/index.php");
	var_dump( $_SERVER );
	exit;
}# core_dashboard //needs to go to /PeoplePods/pods/dashboard/index.php	[QSA,L] # core_dashboard

function replies(  ){ //slightly modified alius of dashboard. more work to be done here
	header( "Location: /test/PeoplePods/pods/dashboard/index.php?replies=1");
	exit;
}//dashboard" )-> //needs to go to /PeoplePods/pods/dashboard/index.php?replies=1	[QSA,L] # core_dashboard

function unauthorized(  ) {
	header( "Location: /test/PeoplePods/pods/unauthorizes_landing_page/index.php");
	exit;
}//needs to go to /PeoplePods/pods/unauthorizes_landing_page/index.php


function authentication(  ){
	header( "Location: /test/PeoplePods/pods/core_authentication/login.php");
	exit;
}//authentication" )-> //needs to go to Location: /test/PeoplePods/PeoplePods/pods/core_authentication/login.php //just an alternate route


function login(  ) {
	header( "Location: /test/PeoplePods/pods/core_authentication/login.php");
	exit;
}//login" )-> //needs to go to /PeoplePods/pods/core_authentication/login.php	[QSA,L] # core_authentication_login

function logout(  ){
	header( "Location: /test/PeoplePods/pods/core_authentication/logout.php");
	exit;
}//logout" )-> //needs to go to /PeoplePods/pods/core_authentication/logout.php	[QSA,L] # core_authentication_login

function passReset( $resetCode ) {
	if( isset( $resetCode ) ){
		header( "Location: /test/PeoplePods/pods/core_authentication/password.php?resetCode=$resetCode");
		exit;
	}else{
		header( "Location: /test/PeoplePods/pods/core_authentication/password.php");
		exit;	
	}
}//passReset" )-> //needs to go to /PeoplePods/pods/core_authentication/password.php?resetCode=$1	[QSA,L] # core_authentication_login

function joinUs(  ){
	header( "Location: /test/PeoplePods/pods/core_authentication/join.php");
	exit;
}//join" )-> //needs to go to /PeoplePods/pods/core_authentication/join.php	[QSA,L] # core_authentication_creation

function verify(  ){
	header( "Location: /test/PeoplePods/pods/core_authentication/verify.php");
	exit;
}//verify" )-> //needs to go to /PeoplePods/pods/core_authentication/verify.php	[QSA,L] # core_authentication_creation

function edit(  ){
	header( "Location: /test/PeoplePods/pods/core_usercontent/edit.php");
	exit;
}//edit" )-> //needs to go to /PeoplePods/pods/core_usercontent/edit.php	[QSA,L] # contenttype_document_add

function content( $stub ) {
	if( isset( $stub ) ){
		header( "Location: /test/PeoplePods/pods/core_usercontent/view.php?stub=$stub");
		exit;
 	}else{
		header( "Location: /test/PeoplePods/pods/core_usercontent/list.php");
		exit;
	}
}//content" )-> //needs to go to /PeoplePods/pods/core_usercontent/list.php	[QSA,L] # contenttype_document_list

function feeds( $args ) {
	if( isset( $args ) ){
		header( "Location: /test/PeoplePods/pods/core_feeds/feed.php?args=$args");
		exit;
	}else{
		header( "Location: /test/PeoplePods/pods/core_feeds/feed.php");
		exit;
	}
}//feeds" )-> //needs to go to /PeoplePods/pods/core_feeds/feed.php?args=$args	[QSA,L] # core_feeds

//original path in .htaccess
function listFeeds( $args ) {
	if( isset( $args ) ){
		header( "Location: /test/PeoplePods/pods/core_feeds/list.php?args=$args");
		exit;
	}else{
		header( "Location: /test/PeoplePods/pods/core_feeds/list.php");
		exit;
	}
}//list" )-> //needs to go to /PeoplePods/pods/core_feeds/list.php	[QSA,L] # core_feeds

function files( $id, $size ) {
	if( isset( $id ) && isset( $size ) ){
		header( "Location: /test/PeoplePods/pods/core_files/index.php?id=$id&size=$size"); //todo recheck this path from the original .htaccess rule, specifically, see if both $id and $size are required.
		exit;
	}else{
		header( "Location: /test/PeoplePods/pods/core_files/index.php");
		exit;
	}
}//files" )-> //needs to go to /PeoplePods/pods/core_files/index.php?id=$id&size=$size	[QSA,L] # core_files



function groups( $stub = null, $command = null ) {
	if( isset( $stub ) && isset( $command ) ){
		header( "Location: /test/PeoplePods/pods/core_groups/group.php?stub=$stub&command=$command");
		exit;
	}else if( $stub ) {
		header( "Location: /test/PeoplePods/pods/core_groups/group.php?stub=$stub");
		exit;
	}else{
		header( "Location: /test/PeoplePods/pods/core_groups/index.php");
		exit;
	}
}//groups" )-> //needs to go to /PeoplePods/pods/core_groups/group.php?stub=$stub&command=$command	[QSA,L] # core_groups # optional params

function invite(  ){
	header( "Location: /test/PeoplePods/pods/core_invite/index.php");
	exit;
}//invite" )-> //needs to go to /PeoplePods/pods/core_invite/index.php	[QSA,L] # core_invite

function pages(  ){
	header( "Location: /test/PeoplePods/pods/core_pages/view.php?stub=$stub");
	exit;
}//pages" )->

function view(  ){
	header( "Location: /test/PeoplePods/pods/core_pages/view.php?stub=$stub");
	exit;
}//view" )-> //needs to go to /PeoplePods/pods/core_pages/view.php?stub=$stub	[QSA,L] # core_pages

function patients(  ){
	header( "Location: /test/PeoplePods/pods/dashboard/index.php");
	exit;
}//patients" )->

function conversation( $username ) {
	header( "Location: /test/PeoplePods/pods/core_private_messaging/thread.php?username=$username");
	exit;
}//conversation" )-> //needs to go to /PeoplePods/pods/core_private_messaging/thread.php?username=$username	[QSA,L] # core_private_messaging

function inbox(  ){
	header( "Location: /test/PeoplePods/pods/core_private_messaging/inbox.php");
	exit;
}//inbox" )-> //needs to go to /PeoplePods/pods/core_private_messaging/inbox.php	[QSA,L] # core_private_messaging

function profile( $username ) {
	header( "Location: /test/PeoplePods/pods/core_profiles/profile.php?username=$username");
	exit;
}//profile" )-> //needs to go to /PeoplePods/pods/core_profiles/profile.php?username=$username	[QSA,L] # core_profiles

function editProfile(  ){
	header( "Location: /test/PeoplePods/pods/core_profiles/editprofile.php");
	exit;
}//editProfile" )-> //needs to go to /PeoplePods/pods/core_profiles/editprofile.php	[QSA,L] # core_profiles

function search(  ){
	header( "Location: /test/PeoplePods/pods/core_search/search.php");
	exit;
}//search" )-> //needs to go to /PeoplePods/pods/core_search/search.php	[QSA,L] # core_search

function user_content(  ){
	header( "Location: /test/PeoplePods/pods/core_usercontent/view.php");
	exit;
}//user_content" )->

function healer_dashboard(  ){
	include("/pods/healer_dashboard");
	exit;
}//doctor_dashboard" )->

function fb_connect(  ){
	header( "Location: /test/PeoplePods/pods/dashboard/index.php");
	exit;
}//fb_connect" )->

function gravatars(  ){
	header( "Location: /test/PeoplePods/pods/dashboard/index.php");
	exit;
}//gravatars" )->

function landing_page(  ){
	header( "Location: /test/PeoplePods/pods/dashboard/index.php");
	exit;
}//landing_page" )->

function openId( $mode ) {
	if( isset( $mode ) ){
		header( "Location: /test/PeoplePods/pods/openid_connect/index.php?mode=$mode");
		exit;
	}else{
		header( "Location: /test/PeoplePods/pods/openid_connect/index.php");
		exit;
	}
}//openId" )-> //needs to go to /PeoplePods/pods/openid_connect/index.php	[QSA,L] # openid_connect

function placekitten(  ){
	header( "Location: /test/PeoplePods/pods/dashboard/index.php");
	exit;
}//placekitten" )->

function twitter(  ){
	header( "Location: /test/PeoplePods/pods/dashboard/index.php");
	exit;
}//twitter" )->

function friends( $mode ) {
	if( isset( $mode ) ){
		header( "Location: /test/PeoplePods/pods/core_friends/index.php?mode=$mode");
		exit;
	}else{
		header( "Location: /test/PeoplePods/pods/core_friends/index.php" );
		exit;
	}
}//friends" )-> //needs to go to /PeoplePods/pods/core_friends/index.php?mode=$mode	[QSA,L] # core_friends

function admin(  ){
	header( "Location: /test/PeoplePods/admin/index.php");
	exit;
}//admin" )->

function api1(  ){//security needed here
	header( "Location: /test/PeoplePods/pods/core_api_simple/index_version1.php");
	exit;
}//api" )-> //needs to go to /PeoplePods/pods/core_api_simple/index_version1.php	[QSA,L] # core_api_simple

function api2( $method ) {//security needed here
	header( "Location: /test/PeoplePods/pods/core_api_simple/index_version2.php?method=$method");
	exit;
}//api" )-> //needs to go to /PeoplePods/pods/core_api_simple/index_version2.php?method=$method	[QSA,L] # core_api_simple


function terms_of_service(  ){
	header( "Location: /test/PeoplePods/pods/terms/view.php" );
	exit;
}

function install(  ){//todo check if database is present before routing to install
	if( !$POD->success() ){
		header( "Location: /test/PeoplePods/install/index.php");
		exit; 
	}else{
		header( "Location: /test/PeoplePods/unauthorized" );
		exit;
	}
	
}//install" )-> //todo needs to go to /PeoplePods/install/, but only the first run though...

//go ahead and declare it, this is a fairly long file. No need to get lost
function default404(){
	//header( "Location: /test/PeoplePods/pods/page_unknown/view.php" );
	//just a test...
	echo '<h1>I feel your pain.</h1>';
	echo '<p>and by your pain, I mean I also do not know what page you were seeking.</p>';
	var_dump( $_SERVER );
	exit;
}
?>

