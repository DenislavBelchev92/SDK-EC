<?php
include_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/init.php";
include_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/defines/sql_defs.php";

/* Class for creating db and manipulating databases*/
/*FIX-ME 
Only one dynamic input in the constructor is database name!
Others should be also included!
*/
class users_database {
	public $host =     DB_HOST;
	public $username = DB_USER;
	public $password = DB_PASSWORD;
	public $db_name  = DB_NAME_USERS;

	public $db_con;
	public $error;

	public function __construct() {
		$this->connect();
	}

	private function connect(){
		$this->db_con = new mysqli($this->host, $this->username, $this->password, $this->db_name);

		/*FIX-ME better db_con check*/
		if($this->db_con->connect_errno){
			die("Database connection failed - " . $this->db_con->connect_error . "(" . mysqli_connect_errno() . ")");
		}

		/*Make the database to support Cyrillic*/
		/*FIX-ME Not sure that it's needed*/
		mysqli_set_charset($this->db_con, 'UTF8');

	}

	/*
	* Select
	*/

	// Expected values:
	// username (string) - mandatory
	// columns to return (array) - optional 
	public function select_user($username, $columns_arr = array()) {

		/*
		* { - Create query - start
		*/
		$query  = "SELECT ";
		
		if (empty($columns_arr)) {
			$columns = " * ";
		} else {
			$columns = implode(", ",$columns_arr);
		}
		$query .= "{$columns}";
		$query .= " FROM users ";

		if ($username == "*")
		{
			// Do nothing
		} else
		{
            $query .= "WHERE username='{$username}'";
		}

		/*
		* } - Create query - end
		*/ 
		$selected_user_row = $this->db_con->query($query) or die($this->db_con->error.__LINE__);
		
		if($selected_user_row)
		{
			if ($selected_user_row->num_rows == 0) {
				die("User NOT FOUND!");
			} else {
				return $selected_user_row;
			}
		} else
		{
		    die("Error : (". $this->db_con->errno. ") ". $this->db_con->error . "in get_table_specific_rules");
		}
	}
	/*
	* INSERT
	*/

	// Expected array input values - first_name, last_name, username, password, email
	public function insert_user($values_arr) {

		/*
		* { - Create query - end
		*/ 
		$query  = "INSERT into ";
		$query .= " users ( ";

		$query .= "first_name, last_name, username, password, email) ";
		$query .= "VALUES (";

		// Create Values string
		$values_str_arr = array();
		$arr_idx = 0;
		foreach ($values_arr as $value) {
			if (is_string($value)){
				$values_str_arr[$arr_idx] = "'{$value}'";
			} else {
				$values_str_arr[$arr_idx] = $value;
			}
			$arr_idx ++;
		}
		$values_str = implode(", ",$values_str_arr);

		$query .= "{$values_str}) ";

		/*
		* } - Create query - end
		*/ 
		$insert_row = $this->db_con->query($query) or die($this->db_con->error.__LINE__);
		if($insert_row) {
		    /*
		     * FIX ME. message update Redundant for know
		     */
            $_SESSION['message_info']['sql_status'] = true;
            $_SESSION['message_info']['message'] = "SUCCESS";
		} else {
            $_SESSION['message_info']['sql_status'] = true;
            $_SESSION['message_info']['message'] = "FAIL";
            array_push($_SESSION['message_info']['errors'], "Error when inserting user : (". $this->db_con->errno. ") ". $this->db_con->error );
		}
	}
	
	/*
	* Update
	*/

	// Expected array input values - first_name, last_name, username, password, email
	// Arguments that won't be changed should be passed as empty
	// Argument username is mandatory
	public function update_user($username, $updated_columns_array, $update_values_array) {
		
		//  This has two purposes
		//  1. It checks that username is valid.
		//	2. From the returned row we can extract all the columns in the database
		$user = $this->select_user($username)->fetch_assoc();
		
		$valid_cols_array = array();

		$valid_cols_idx = 0;
		while ($valid_col = current($user)) {
			$valid_cols_array[$valid_cols_idx] = key($user);
			next($user);
			$valid_cols_idx++;
		}
		
		/*
		* { - Create query - start
		*/ 
		
		$query = "UPDATE users SET ";	

		$values_str_arr = array();
		
		$arr_idx = 0;
		foreach ($updated_columns_array as $col) {

			if (in_array($col, $valid_cols_array)) {
				
				$update_value_idx = array_search($col, $updated_columns_array);
				$update_value = $update_values_array[$update_value_idx];
				
				$values_str_arr[$arr_idx] = "{$col} = ";
				if (is_string($update_value)){
					$values_str_arr[$arr_idx] .= "'{$update_value}'";
				} else {
					$values_str_arr[$arr_idx] .= $update_value;
				}
				echo "Current is col $col with val $update_value";
			} else {
				echo "Wrong column input $col";
				return FAIL;
			}
			
			$arr_idx++;
		}

		// Create update values string
		$values_str = implode(", ",$values_str_arr);
		
		$query .= "{$values_str} ";

		// Get the first element for now only
		$user = $this->select_user($username)->fetch_assoc();
		
		$query .= "WHERE user_id = {$user['user_id']}";

		/*
		* } - Create query - end
		*/ 

		/* Update user*/
		$updated_row = $this->db_con->query($query);

		if($updated_row && mysqli_affected_rows($this->db_con) == 1) {
            /*
             * FIX ME. message update Redundant for know
             */
            $_SESSION['message_info']['sql_status'] = true;
            $_SESSION['message_info']['message'] = "SUCCESS";
		} else {
		    if ( mysqli_affected_rows($this->db_con) == 0) {
                $_SESSION['message_info']['sql_status'] = true;
                $_SESSION['message_info']['message'] = "SUCCESS";
                array_push($_SESSION['message_info']['errors'], "Actually nothing was updated, was it?" );
            } else {
                $_SESSION['message_info']['sql_status'] = true;
                $_SESSION['message_info']['message'] = "FAIL";
                array_push($_SESSION['message_info']['errors'], "Error when updating user : (". $this->db_con->errno. ") ". $this->db_con->error );
            }

		}

	}

	/*
	* Delete
	*/

    public function delete_user($username) {

        //  This has two purposes
        //  1. It checks that username is valid.
        //	2. From the returned row we can extract all the columns in the database
        $user = $this->select_user($username)->fetch_assoc();

        /*
        * { - Create query - start
        */

        $query = "DELETE FROM users ";

        $query .= "WHERE user_id = {$user['user_id']} ";

        // Make sure only 1 user will be deleted
        $query .= "LIMIT 1";

        /*
        * } - Create query - end
        */

        /* Delete user*/
        $deleted_row = $this->db_con->query($query) or die($this->db_con->error.__LINE__);
        if($deleted_row && mysqli_affected_rows($this->db_con) == 1) {
            /*
             * FIX ME. message update Redundant for know
             */
            $_SESSION['message_info']['sql_status'] = true;
            $_SESSION['message_info']['message'] = "SUCCESS";
		} else {
            $_SESSION['message_info']['sql_status'] = true;
            $_SESSION['message_info']['message'] = "FAIL";
            array_push($_SESSION['message_info']['errors'], "Error when deleting user : (". $this->db_con->errno. ") ". $this->db_con->error );
        }

    }

/*
 * { Local Helper functions
 */

    public function get_users_db_columns() {
		$user = $this->select_user("Denis")->fetch_assoc();

		$valid_cols_array = array();

		$valid_cols_idx = 0;
		while ($valid_col = current($user)) {
			$valid_cols_array[$valid_cols_idx] = key($user);
			next($user);
			$valid_cols_idx++;
		}
		// Remove user_id column
        unset($valid_cols_array[0]);
		return $valid_cols_array;
	}
/*
 * }
 */

    /*
     * { Tables specific rules connection
     */

    public function get_table_specific_rules($table = "fields_rules_table_users", $field = "*" ) {

        /*
        * { - Create query - start
        */
        $query  = "SELECT *";
        $query .= " FROM {$table} ";

        if ($field === "*")
        {
            // Do nothing
        } else
        {
            $query .= "WHERE field_name='{$field}'";
        }

        /*
        * } - Create query - end
        */
        $result = $this->db_con->query($query) or die($this->db_con->error.__LINE__);

        if($result)
        {
            if ($result->num_rows == 0) {
                die("Field NOT FOUND!");
            } else {
                return $result;
            }
        } else
        {
            die("Error : (". $this->db_con->errno. ") ". $this->db_con->error . "in get_table_specific_rules");
        }
        /*
     * { Tables specific rules connection
     */
    }
}



?>
