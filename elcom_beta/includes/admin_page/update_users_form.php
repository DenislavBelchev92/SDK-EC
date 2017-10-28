<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 10/16/2017
 * Time: 8:00 AM
 */
?>

<div class="form-group">
    <div class="col-sm-12">
        <label class="control-label" for="username">First Name:</label>
    </div>

    <div class="col-sm-12">
        <div class="input-group">
            <input type="text" disabled class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($_SESSION['users_columns_values']['first_name'])?>" placeholder="Your first name">
            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
        </div>
    </div>

</div>
<div class="form-group">
    <div class="col-sm-12">
        <label class="control-label" for="pwd">Last Name:</label>
    </div>

    <div class="col-sm-12">
        <div class="input-group">
            <input type="text" disabled class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($_SESSION['users_columns_values']['last_name'])?>" placeholder="Your last name">
            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <label class="control-label" for="username">Username:</label>
    </div>

    <div class="col-sm-12">
        <div class="input-group">
            <input type="text" disabled class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['users_columns_values']['username'])?>" placeholder="Enter username or email">
            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
        </div>
    </div>

</div>
<div class="form-group">
    <div class="col-sm-12">
        <label class="control-label" for="pwd">Password:</label>
    </div>

    <div class="col-sm-12">
        <div class="input-group">
            <input type="text" disabled class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($_SESSION['users_columns_values']['password'])?>" placeholder="Enter password">
            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
        </div>
    </div>

</div>
<div class="form-group">
    <div class="col-sm-12">
        <label class="control-label" for="email">Email:</label>
    </div>

    <div class="col-sm-12">
        <div class="input-group">
            <input type="text" disabled class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['users_columns_values']['email'])?>" placeholder="Enter email">
            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
        </div>
    </div>

</div>

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
