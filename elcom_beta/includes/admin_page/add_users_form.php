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
        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($_SESSION['users_columns_values']['first_name'])?>" placeholder="Your first name">
    </div>

</div>
<div class="form-group">
    <div class="col-sm-12">
        <label class="control-label" for="pwd">Last Name:</label>
    </div>

    <div class="col-sm-12">
        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($_SESSION['users_columns_values']['last_name'])?>" placeholder="Your last name">
    </div>

</div>
<div class="form-group">
    <div class="col-sm-12">
        <label class="control-label" for="username">Username:</label>
    </div>

    <div class="col-sm-12">
        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['users_columns_values']['username'])?>" placeholder="Enter username or email">
    </div>

</div>
<div class="form-group">
    <div class="col-sm-12">
        <label class="control-label" for="pwd">Password:</label>
    </div>

    <div class="col-sm-12">
        <input type="text" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($_SESSION['users_columns_values']['password'])?>" placeholder="Enter password">
    </div>

</div>
<div class="form-group">
    <div class="col-sm-12">
        <label class="control-label" for="email">Email:</label>
    </div>

    <div class="col-sm-12">
        <input type="text" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['users_columns_values']['email'])?>" placeholder="Enter email">
    </div>

</div>

<div class="form-group">
    <div class="col-sm-offset-4 col-sm-10">
        <button type="submit" name="add" class="btn btn-default">Add</button>
        <button type="submit" name="clear" class="btn btn-default" style="margin-left: 150px;">Clear</button>
    </div>
</div>