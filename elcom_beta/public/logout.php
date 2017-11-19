<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 11/15/2017
 * Time: 10:32 PM
 */


include_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/init.php";

$Session->logout();

redirect_to("index.php");

?>

