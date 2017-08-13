<?php
function user_exists($username) {
	$username = sanitize($username);
	$query = mysqli_query("SELECT COUNT('user_id') FROM 'users' WHERE 'username' = '$username'");

	//if($query !== false) {
	
		return (mysqli_result($query, 0) == 1) ? true : false;
	
	//}
	//echo "problem";
	//return false;
}
?>