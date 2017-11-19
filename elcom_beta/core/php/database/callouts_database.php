<?php
include_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/defines/sql_defs.php";
include_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/init.php";

/* Class for creating db and manipulating databases*/
class Callouts_Database extends Database
{
    protected function open_connection(){
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME_CALLOUTS);

        if($this->db_connection->connect_errno){
            die("Database connection failed - " . $this->db_con->connect_error . "(" . mysqli_connect_errno() . ")");
        }
        if (!$this->db_connection->set_charset("utf8")) {
            die("Error loading character set utf8:" . $this->db_connection->error);
        }
    }
}
?>
