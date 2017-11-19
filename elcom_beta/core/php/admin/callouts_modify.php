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
    $callout=Lost_And_Found::instantiate_from_post_variables();
    $callout=Lost_And_Found::instantiate_from_post_variables();

    $callout->validate_callout_properties();

    if(empty($Session->get_all_form_field_errors())) {
        /*
         * ADD USER
         */
        $callout->save();

        $Session->set_message("Callout was successfully added");

    } else {
        $Session->set_message("There were same errors in the form");
    }
} if (isset($_POST['update'])) {
    $callout_id_to_be_modified = $Session->get_callout_id_to_modify();

    if ($callout_id_to_be_modified) {

        $callout_posted    =   Lost_And_Found::update_from_post_variables(Lost_And_Found::get_by_id($callout_id_to_be_modified));

        $callout_posted->validate_callout_properties(VALIDATE_ONLY_UNIQUE_IS_ID);
        if(empty($Session->get_all_form_field_errors())) {
            /*
             * UPDATE USER
             */
            $callout_posted->save();

            $Session->set_message("Callout was successfully updated");

        } else {

            print_r($Session->get_all_form_field_errors());

            $Session->set_message("There were same errors in the form");

        }
    } else {
        $Session->set_message("No callout was selected!");
    }

} else if (isset($_POST['delete'])) {
    $callout_id_to_be_modified = $Session->get_callout_id_to_modify();
    if ($callout_id_to_be_modified) {
        $callout = Lost_And_Found::get_by_id($callout_id_to_be_modified);

        $callout->delete();

        $Session->set_message("Callout was successfully deleted!");
    } else {
        $Session->set_message("No callout was selected!");
    }

    $Session->free_callout_id_to_modify();


} if (isset($_POST['clear'])) {

    $Session->free_user_id_to_modify();
    if(isset($_GET['selected_callout_id'])){
        unset($_GET['selected_callout_id']);
    }
    $url = explode("?", $_SERVER['HTTP_REFERER']);
    redirect_to($url[0]);
} else {

}

$url = explode("?", $_SERVER['HTTP_REFERER']);
redirect_to($url[0]);

echo "</pre>";
?>