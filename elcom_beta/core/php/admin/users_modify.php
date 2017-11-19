<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 10/12/2017
 * Time: 8:44 AM
 */

include_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/init.php";

/*
 *  IF ABOUT TO ADD USER
 */
echo "<pre>";


if (isset($_POST['add'])) {
    $user=User::instantiate_from_post_variables();

    $user->validate_user_properties();

    if(empty($Session->get_all_form_field_errors())) {
        /*
         * ADD USER
         */
        $user->save();

        $Session->set_message("User $user->username was successfully added");

    } else {
        $Session->set_message("There were same errors in the form");
    }
} if (isset($_POST['update'])) {
    $user_id_to_be_modified = $Session->get_user_id_to_modify();

    if ($user_id_to_be_modified) {

        $user_posted    =   User::update_from_post_variables(User::get_by_id($user_id_to_be_modified));

        $user_posted->validate_user_properties(USER_VALIDATE_ONLY_UNIQUE_IS_ID);
        if(empty($Session->get_all_form_field_errors())) {
            /*
             * UPDATE USER
             */
            $user_posted->save();

            $Session->set_message("User $user_posted->username was successfully updated");

        } else {

            print_r($Session->get_all_form_field_errors());

            $Session->set_message("There were same errors in the form");

        }
    } else {
        $Session->set_message("No user was selected!");
    }

} else if (isset($_POST['delete'])) {
    $user_id_to_be_modified = $Session->get_user_id_to_modify();
    if ($user_id_to_be_modified) {
        $user = User::get_by_id($user_id_to_be_modified);

        $user->delete();

        $Session->set_message("User $user->username was successfully deleted!");
    } else {
        $Session->set_message("No user was selected!");
    }

    $Session->free_user_id_to_modify();
} if (isset($_POST['clear'])) {

    $Session->free_user_id_to_modify();
    if(isset($_GET['user_selected'])){
        unset($_GET['user_selected']);
    }
    $url = explode("?", $_SERVER['HTTP_REFERER']);
    redirect_to($url[0]);
} else {

}

redirect_to($_SERVER['HTTP_REFERER']);

echo "</pre>";
?>