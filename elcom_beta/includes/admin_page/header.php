<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 10/8/2017
 * Time: 9:09 AM
 */

include_once $_SERVER['DOCUMENT_ROOT'] . "/elcom_beta/core/php/init.php";

$current_page="admin/index.php";
$local_path="index.php";

$users_page_name = "Users";
$callouts_page_name = "Callouts";

$tables_to_modify = array("{$users_page_name}","{$callouts_page_name}");
$modify_options = array("Add","Update_Delete");
$modify_options_links = array(
    "Add" => "add_users.php",
    "Update_Delete" => "manage_users.php",
);

?>

<!DOCTYPE html>
<html lang="bg">

<head>
    <title>Admin Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--  Core CSS -->
    <link href="../../bootstrap/css/bootstrap.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body>