<?php

include_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/init.php";

/*
 * Create empty user
 */
$user = new User;

if (isset($_POST['submit'])) {

    $user=User::instantiate_from_post_variables();

    $user->validate_user_properties();

    if(empty($Session->get_all_form_field_errors())) {
        /*
         * ADD USER
         */
        $user->save();

        $Session->set_message("User $user->username was successfully registered");

    } else {
        $Session->set_message("There were same errors in the form");

    }

} else {
    $Session->set_message("About to be registered");
}

?>

<!DOCTYPE html>
<html lang="bg">

<!-- Include the head(meta-tags and title) -->
<?php include $_SERVER['DOCUMENT_ROOT']."/elcom_beta/includes/common/head.html" ?>
	
<body>
<div class="page">
	<!-- Include the navigation bars -->
    <?php include $_SERVER['DOCUMENT_ROOT']."/elcom_beta/includes/common/navbar.html" ?>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<h2>
				<?php $Session->display_message();?>
				</h2>
			</div>
			
			<div class="col-md-6">
				<div class="">
					<h2>Register</h2>
					<form class="form-horizontal" action="register.php" method="POST">

                        <?php include $_SERVER['DOCUMENT_ROOT']."/elcom_beta/includes/common/user_create_main_form.php" ?>

						<div class="form-group">        
							<div class="col-sm-offset-5 col-sm-10">
								<button type="submit" name="submit" class="btn btn-default">Register</button>
							</div>
						</div>

					</form>

				</div>
			</div>
		</div>
	</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/elcom_beta/includes/common/footer.php" ?>
