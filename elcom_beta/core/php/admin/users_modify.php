<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 10/12/2017
 * Time: 8:44 AM
 */

include_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/init.php";

$users_db = new users_database();

$all_users = $users_db->select_user("*", "");
$valid_users_columns = $users_db->get_users_db_columns();

/*
 * INIT Session errors and add to message info
 * sql_status - does the message carry also a result info from sql query.
 * message    - actual one-line message to be displayed in the info box.
 * errors     - array of all the errors occurred. Errors should be accumulated only in this file. INIT as empty array each time.
 */

$_SESSION['message_info']['sql_status'] = true;
$_SESSION['message_info']['errors'] = array();

/*
 *  IF CLEAR JUST REDIRECT
 */

if (isset($_POST['clear'])) {

    /*
    * Before redirect clear if clear is requested.
    */
    populate_form_fields($users_db, $valid_users_columns, true);
    /*
     * Update Session message
     */
    $_SESSION['message_info']['message'] = "FIELDS CLEARED";
    redirect_to($_SERVER['HTTP_REFERER']);
}

/*
 *  IF ABOUT TO ADD USER
 */
if (isset($_POST['add'])) {

    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);

    $users_columns_to_check = $valid_users_columns;

    $modify_option = "add";
} else if (isset($_POST['update'])) {

    /*
     *  IF ABOUT TO UPDATE USER
     */

    $modify_option = "update";

    /*
     * Create an associative array to be later passed when updating the user
     */
    $update_columns = array();
    $update_values = array();

    foreach ($valid_users_columns as $valid_users_col) {
        if (isset($_POST[$valid_users_col])) {
            array_push($update_columns, $valid_users_col);
            array_push($update_values, trim($_POST[$valid_users_col]));
        }
    }
    /*
     * If no fields are passed to be updated return
     */
    if (empty($update_columns)) {
        array_push($_SESSION['message_info']['errors'], "Nothing to update. Return and fill some fields." );

        /*
        * FIX ME! Prone to spoofing!
        */
        redirect_to($_SERVER['HTTP_REFERER']);
    }

    $users_columns_to_check = $update_columns;


} elseif (isset($_POST['delete'])) {

    /*
     *  IF ABOUT TO DELETE USER
     */
    $modify_option = "delete";

} else {

    /*
     *  SHOULD NOT ENTER THIS EVER!
     */
    $modify_option = NULL;
}

if(isset($modify_option)) {

    /*
     * First validate that all inputs valid for their field
     */

    if (validate_form_input_fields($users_db, $users_columns_to_check)){

        /*
         * FIX me. MSQL sanitize before passing!
         */
        switch($modify_option) {
            case "add":
                $values_array = array($first_name, $last_name, $username, $password, $email);
                $users_db->insert_user($values_array);
                break;
            case "update":
                $users_db->update_user($_SESSION['user_selected'], $update_columns, $update_values);
                break;
            case "delete":
                $users_db->delete_user($_SESSION['user_selected']);
                break;
            default: die("ne6to se naeba");
        }

        if (empty($errors)) {
            $_SESSION['message_info']['message'] = "SUCCESS";
        } else {
            /*
             * Return Fail but keep the errors accumulated.
             */
            $_SESSION['message_info']['message'] = "FAIL";
        }

        /*
        * FIX ME! Prone to spoofing!
        */
         redirect_to($_SERVER['HTTP_REFERER']);

    } else {
        /*
        * Return Fail but keep the errors accumulated.
        */


        $_SESSION['message_info']['message'] = "FAIL";


        /*
         * FIX ME! Prone to spoofing!
         */
         redirect_to($_SERVER['HTTP_REFERER']);
    }
}

?>