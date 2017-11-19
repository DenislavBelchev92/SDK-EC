<?php

include_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/init.php";

/*
 * Create an empty user
 */
$user = new User;

if (isset($_POST['submit'])) {

    $user=User::instantiate_from_post_variables();

    $user->validate_user_properties();

    if (User::authenticate($user->username, $user->password)) {
        $Session->login($user);
//        redirect_to("index.php");
        /*
         * If valid redirect to the previous page the user was.
         */
        redirect_to($_SERVER['HTTP_REFERER']);
    } else {
        $Session->set_message("There is not such username registered with this password!");
    }

} else {
    $Session->set_message("Please Log in.");
}
?>

<!DOCTYPE html>
<html lang="bg">
	<!-- Include the head(metatags and title) -->
	<?php include $_SERVER['DOCUMENT_ROOT']."/elcom_beta/includes/common/head.html" ?>
	
<body>
<div class="page">

	<!-- Include the navigation bars -->
	<?php include $_SERVER['DOCUMENT_ROOT']."/elcom_beta/includes/common/navbar.html" ?>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8">
				<h2>
                    <?php $Session->display_message();?>
				</h2>
			</div>
			
			<div class="col-md-4">
				<div class="">
					<h2>Login</h2>
					<form class="form-horizontal" action="login.php" method="POST">
						<div class="form-group">
							<div class="col-sm-2" style="text-align: left;">
								<label class="control-label" for="username">User:</label>
							</div>
							<div class="col-sm-9" style="margin-left: 10px;">
								<input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user->username)?>" placeholder="Enter username or email">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-2">
								<label class="control-label" for="pwd">Password:</label>
							</div>
							<div class="col-sm-9" style="margin-left: 10px;">          
								<input type="password" class="form-control" id="pwd" name="password" placeholder="Enter password">
							</div>
						</div>

						<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-10" style="padding-left: 25px;">
								<div class="checkbox">
									<label><input type="checkbox" name="remember"> Remember me</label>
								</div>
							</div>
						</div>
						<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-10" style="padding-left: 25px;">
								<button type="submit" name="submit" class="btn btn-primary">  Log in</button>
							</div>
						</div>
					</form>

					<div class="pull-left">
						<a href="register.php">Register</a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/elcom_beta/includes/common/footer.php" ?>
