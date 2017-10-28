<?php
include_once "../init.php";

$users_register_db = new elcom_database('users_register');	

if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	//$users_register_db->select("SELECT * FROM 'users' WHERE 'username' = '$username'");
	if (empty($username) === true || empty($password) === true) {
		$errors[] = 'You need to fill both fields';
	} else if (user_exists($users_register_db->link, $username) === false){
		$errors[] = 'We cant find you $username . Are you registered?';
	} else {
		print_r($_POST);
		echo "user {$username}";
	}
}
?>