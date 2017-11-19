<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 10/16/2017
 * Time: 8:00 AM
 */
?>

<?php
/*
 * First Name
 */
$current_field_errors = $Session->get_form_field_errors('first_name')
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/includes/common/user_create_main_form.php";
?>

<div class="form-group">
    <div class="col-sm-10" >
        <div class="col-sm-offset-3" style="display: inline-block">
            <button type="submit" name="update" class="btn btn-default">Update User</button>
        </div>
        <div class="col-sm-offset-1" style="display: inline-block">
            <button type="submit" name="clear" class="btn btn-default">Clear Fields</button>
        </div>
        <div class="col-sm-offset-1" style="display: inline-block">
            <button type="submit" name="delete" class="btn btn-default">Delete User</button>
        </div>
    </div>


</div>
