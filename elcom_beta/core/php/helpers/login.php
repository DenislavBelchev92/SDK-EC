<?php
	include_once "../init.php";
	
	if (user_exists('Denis')) {
		echo 'sa6testvuvam!';
	} else {
		die();
	}
	
	if (empty($_POST) === false) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		if (empty($username) === true || empty($password) === true) {
			$errors[] = 'You need to fill both fields';
		} else if (user_exists($username) === false){
			$errors[] = 'We cant find you. Are you registered?';
		} else {

		}
	}
?>