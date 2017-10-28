<?php
//  include_once "../core/php/init.php";
/*
* Useful for future
* # 1 #
* Checks if variable is in array
* arr = array("1", "2", "3");
* if (in_array(3, $arr));
* 
* # 2 #
* regular expressions
* if (preg_match("/@/", "dbelchev@abv.bg"))
*
* # 3 #
* str position 
* if (strpos("@", $user_email) === false)
* NOTE: Very important to be "===" because if @ is in the beginning strpos will return 0
* abd this will still be true for "0 == false"
*/
function user_exists($db, $username) {
	$username = mysql_sanitize($username);

	//$query = "SELECT COUNT(user_id) FROM users WHERE username='$username'";
	$query = "SELECT * FROM users WHERE username='$username'";
	$nof_users_returned = $db->db_con->query($query);

	if ($nof_users_returned->num_rows == 0) {
		$nof_users_returned->free_result();
		return false;
	}
	$nof_users_returned->free_result();
	return true;
}




?>