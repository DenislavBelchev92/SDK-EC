<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 11/19/2017
 * Time: 11:32 PM
 */
include_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/init.php";

/*
 * Create an empty user
 */
if (isset($_POST['submit'])) {

    $Session->save_callout_filter($_POST['area']);

    redirect_to($_SERVER['HTTP_REFERER']);

} else {
//    $Session->set_message("Please Log in.");
}
?>