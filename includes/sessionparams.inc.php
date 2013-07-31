<?php
// set time limit
$limit = 60 * 60;
// get the time
$now = time();
// where to go if expired
$redirect = '../admin/index.php';
// if auth variable not set, redirect to login page
if(!isset($_SESSION['auth'])){
	header("Location:$redirect");
	exit;
	} elseif($now > $_SESSION['start'] + $limit){
	// if time limit has expired, destroy session and redirect
	// empty array
	$_SESSION = array();
	// invalidate cookie
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-86400, '/');
		}
	// end session and redirect
	session_destroy();
	header("Location:{$redirect}?expired=yes");
	exit;
	} else {
	// update start time, as session must not be expired yet
	$_SESSION['start'] = time();
	}
?>