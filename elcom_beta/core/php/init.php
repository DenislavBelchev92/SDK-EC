<?php
    session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/defines/init_defs.php";

	require_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/helpers/database.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/helpers/users_database.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/helpers/callouts_database.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/helpers/users.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/helpers/general.php";

	$_SESSION['user_is_logged'] = false;
		
	$errors = array();

	$users_db = new users_database();
	$callouts_db = new callouts_database();
?>