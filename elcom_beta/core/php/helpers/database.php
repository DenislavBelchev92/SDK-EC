<?php
include_once "C:/xampp/htdocs/elcom_beta/core/php/init.php";
include_once "C:/xampp/htdocs/elcom_beta/core/php/defines/sql_defs.php";

/* Class for creating connection and manipulating databases*/
/*FIX-ME 
Only one dynamic input in the constructor is database name!
Others should be also included!
*/
class elcom_database {
  public $host =     DB_HOST;
  public $username = DB_USER;
  public $password = DB_PASSWORD;

  public $link;
  public $error;

  public function __construct($db_name) {
    $this->connect($db_name);
  }

  private function connect($db_name){
    $this->link = new mysqli($this->host, $this->username, $this->password, $db_name);

    //if(mysqli_connect_errno()) {
    //  echo 'Failed to connect to the main database with error'.mysqli_connect_error();
    //}

	/*FIX-ME better connection check*/
    if(!$this->link) {
      $this->error = "Connection to the Database failed: ".$this->link->connect_error;
      return false;
    }

	/*Make the database to support Cyrilic*/
	/*FIX-ME Not sure that it's needed*/
    mysqli_set_charset($this->link, 'UTF8');

  }

  /*
  * Select
  */
  public function select($query) {
    $result = $this->link->query($query) or die($this->link->error.__LINE__);
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

  public function insert($query) {
    $insert_row = $this->link->query($query) or die($this->link->error.__LINE__);
    if($insert_row) {
      header("Location: index.php?insert_row_message=".urlencode('Record added'));
    } else {
      die("Error : (". $this->linl->errno. ") ". $this->link->error);
    }
  }


  /*
  * Update
  */

  public function update($query) {
    $update_row = $this->link->query($query) or die($this->link->error.__LINE__);
    if($update_row) {
      header("Location: index.php?insert_row_message=".urlencode('Record updated'));
    } else {
      die("Error : (". $this->linl->errno. ") ". $this->link->error);
    }
  }

  /*
  * Delete
  */

  public function delete($query) {
    $delete_row = $this->link->query($query) or die($this->link->error.__LINE__);
    if($delete_row) {
      header("Location: index.php?insert_row_message=".urlencode('Record deleted'));
    } else {
      die("Error : (". $this->linl->errno. ") ". $this->link->error);
    }
  }

}

?>
