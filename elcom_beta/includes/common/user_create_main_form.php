<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 11/15/2017
 * Time: 9:03 PM
 */
?>

<?php
$is_manage_page = (stripos($_SERVER['REQUEST_URI'], "update") || stripos($_SERVER['REQUEST_URI'], "manage")) ? true : false;

    /*
     * First name
     */
$current_field_errors = $Session->get_form_field_errors('first_name');
?>
<div class="form-group  <?php if (!empty($current_field_errors)){echo 'has-error';}?>">
    <div class="col-sm-12">
        <label class="control-label" for="first_name">First Name:</label>
    </div>
    <div class="col-sm-12">
        <?php if ($is_manage_page): ?>
        <div class="input-group">
            <input type="text" class="form-control" disabled id="first_name" name="first_name" value="<?php echo $user->first_name?>" placeholder="Enter your first name">
            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
        </div>
        <?php else: ?>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user->first_name?>" placeholder="Enter your first name">
        <?php endif; ?>
    </div>
    <?php
    $Session::display_current_field_errors($current_field_errors);
    ?>
</div>



<?php
    /*
     * Last name
     */
$current_field_errors = $Session->get_form_field_errors('last_name')
?>
<div class="form-group <?php if (!empty($current_field_errors)){echo 'has-error';}?>">
    <div class="col-sm-12">
        <label class="control-label" for="last_name">Last Name:</label>
    </div>
    <div class="col-sm-12">
        <?php if ($is_manage_page): ?>
        <div class="input-group">
            <input type="text" class="form-control" disabled id="last_name" name="last_name" value="<?php echo $user->last_name?>" placeholder="Enter your last name">
            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
        </div>
        <?php else: ?>
        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user->last_name?>" placeholder="Enter your last name">
        <?php endif; ?>
    </div>
    <?php
    $Session::display_current_field_errors($current_field_errors);
    ?>
</div>


<?php
    /*
     * Username
     */
$current_field_errors = $Session->get_form_field_errors('username')
?>
<div class="form-group <?php if (!empty($current_field_errors)){echo 'has-error';}?>">
    <div class="col-sm-12">
        <label class="control-label" for="username">Username:</label>
    </div>
    <div class="col-sm-12">
        <?php if ($is_manage_page): ?>
            <div class="input-group">
                <input type="text" class="form-control" disabled id="username" name="username" value="<?php echo $user->username?>" placeholder="Enter username or email">
                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
            </div>
        <?php else: ?>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $user->username?>" placeholder="Enter username or email">

        <?php endif; ?>
    </div>
    <?php
    $Session::display_current_field_errors($current_field_errors);
    ?>
</div>

<?php
    /*
     * Password
     */
$current_field_errors = $Session->get_form_field_errors('password')
?>
<div class="form-group <?php if (!empty($current_field_errors)){echo 'has-error';}?>">
    <div class="col-sm-12">
        <label class="control-label" for="password">Password:</label>
    </div>
    <div class="col-sm-12">
        <?php if ($is_manage_page): ?>
            <div class="input-group">
                <input type="password" class="form-control" disabled id="pwd" name="password" value="" placeholder="Enter password">
                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
            </div>
        <?php else: ?>
            <input type="password" class="form-control" id="pwd" name="password" value="" placeholder="Enter password">
        <?php endif; ?>
    </div>
    <?php
    $Session::display_current_field_errors($current_field_errors);
    ?>
</div>

<?php
    /*
     * Email
     */
$current_field_errors = $Session->get_form_field_errors('email')
?>
<div class="form-group <?php if (!empty($current_field_errors)){echo 'has-error';}?>">
    <div class="col-sm-12">
        <label class="control-label" for="email">Email:</label>
    </div>
    <div class="col-sm-12">
        <?php if ($is_manage_page): ?>
            <div class="input-group">
                <input type="text" class="form-control" disabled id="email" name="email" value="<?php echo $user->email?>" placeholder="Enter email">
                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
            </div>
        <?php else: ?>
            <input type="text" class="form-control" id="email" name="email" value="<?php echo $user->email?>" placeholder="Enter email">
        <?php endif; ?>
    </div>
    <?php
    $Session::display_current_field_errors($current_field_errors);
    ?>

</div>

<?php
$Session->clear_form_field_errors();
?>