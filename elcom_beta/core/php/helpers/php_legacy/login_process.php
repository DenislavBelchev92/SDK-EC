<?php
include_once "header.php";
include_once("../defines/sql_defs.php");
include_once "database.php";
include_once "form_processing_helpers.php";

$db = new Database();

if(isset($_POST['login'])) {

    // Make validity checks
    $username = process_form_input($_POST['username'], $db->link);
    $password = process_form_input($_POST['password'], $db->link);

    // Encrypt the password
    $password_crypted = encrypt($password);

    // Create the querry and get the result from the database
    $sql_querry_get_user = "SELECT * FROM users WHERE username='$username'";
    $querry_result_get_user = $db->select($sql_querry_get_user);

    $row_get_user = mysqli_fetch_array($querry_result_get_user);
    $db_id = $row_get_user ['id'];
    $db_password = $row_get_user ['password'];

    if($password == $db_password) {
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $db_id;
        header('Location: ../../../pages/index.php');
    } else {
        echo "LOGIN FAILED!";
        include_once("logout.php");
    }
}
?>
