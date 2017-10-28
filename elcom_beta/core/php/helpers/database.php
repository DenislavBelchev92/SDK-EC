<?php
include_once "C:/xampp/htdocs/elcom_beta/core/php/init.php";

/* Class for creating db and manipulating databases*/
/*FIX-ME 
Only one dynamic input in the constructor is database name!
Others should be also included!
*/
class elcom_database {
  public $host =     DB_HOST;
  public $username = DB_USER;
  public $password = DB_PASSWORD;

  public $db_con;
  public $error;

  public function __construct($db_name) {
    $this->connect($db_name);
  }

  private function connect($db_name){
    $this->db_con = new mysqli($this->host, $this->username, $this->password, $db_name);

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
  public function select($query) {
	// Checks if $result is true and if not die with error
	// This is only to check the SQL syntax, doesn't mean that we have result!
    $result = $this->db_con->query($query) or die($this->db_con->error.__LINE__);
    if($result->num_rows > 0) {
      return $result;
    } else {
      return false;
    }
  }

  /* FIX-ME 
  All below functions - Insert, Update, Delete etc have a static URL answer*/

  /*
  * Insert
  */

  public function insert($table_name, $columns_arr, $values_arr) {

  	//$table_name = "users";
	//$columns_arr = array("as","ti","toi");
	//$values_arr = array('ala', 1, 2);
/*
* { - Create query - end
*/ 
	$query  = "INSERT into ";
	$query .= " $table_name ( ";
	
	$columns_str = implode(", ",$columns_arr);

	$query .= "{$columns_str}) ";
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

	echo "Query is $query ";
/*
* } - Create query - end
*/ 
    $insert_row = $this->db_con->query($query) or die($this->db_con->error.__LINE__);
    if($insert_row) {
		echo "Query is $query ";
      //redirect_to("index.php?insert_row_message=".urlencode('Record added'));
    } else {
      die("Error : (". $this->db_con->errno. ") ". $this->db_con->error);
	}
  }

  /*
  * Update
  */

  public function update($query) {
    $update_row = $this->db_con->query($query) or die($this->db_con->error.__LINE__);
    if($update_row) {
      header("Location: index.php?insert_row_message=".urlencode('Record updated'));
    } else {
      die("Error : (". $this->db_con->errno. ") ". $this->db_con->error);
    }
  }

  /*
  * Delete
  */

  public function delete($query) {
    $delete_row = $this->db->query($query) or die($this->db->error.__LINE__);
    if($delete_row) {
      header("Location: index.php?insert_row_message=".urlencode('Record deleted'));
    } else {
      die("Error : (". $this->db->errno. ") ". $this->db->error);
    }
  }

}

?>
