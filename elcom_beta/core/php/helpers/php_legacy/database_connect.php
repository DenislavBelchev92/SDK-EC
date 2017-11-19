<?php
// Connect to the database
include_once("sql_defs.php");

$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

// Set the charset to include also Cyrillic
mysqli_set_charset($connection, 'UTF8');

// Check if the connection is executed properly
if(mysqli_connect_errno()) {
  echo 'Failed to connect to the common database with error'.mysqli_connect_error();
}
?>
