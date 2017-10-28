<?php
//$expire = time() + (60*60*24*7);
//setcookie('test', 21, $expire);
include_once "core/php/init.php";

$current_page = "login.html";

if (isset($_POST['submit'])) {


	
	$message = "";
	$errors = array();
	
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	// Check relevant fields
	$fields_required = array("username", "password");
	foreach($fields_required as $field) {
		$value = trim($_POST[$field]);
		if(!has_presence($value)){
			$error = $field . '_input_missing';
			$errors['$error'] = ucfirst($field) . 'cannot be blank!';
		}
	}

	// Check if input whitin valida range
	user_login_input_validate($username, $password, $errors);
		
	if (empty($errors)){	
		// Check if user is in the DB
		if (!user_exists($users_db, $username)){
			$errors['user_not_found'] = "We cant find you $username . Are you registered?";
		} else {
			$query = "SELECT * FROM users WHERE username='$username'";
			$users_returned = $users_db->select($query);
			while($user = $users_returned->fetch_assoc()) {
				// FIX-ME Nothing for now
				$message .= $user['first_name'];
				$message .= " ";
				$message .=  $user['last_name'];

			}
			$message .= " Hello!";
			$_SESSION['user_is_logged'] = true;
		}
	}

} else {
	$username="";
	$message = "Please Log In";
}
?>

<!DOCTYPE html>
<html lang="bg">
	<!-- Include the head(metatags and title) -->
	<?php include 'includes/head.html' ?>
	
<body>
<div class="page"> 
	<!-- Include the navigation bars -->
	<?php include 'includes/navbar.html' ?>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8">
				<h2>
				<?php
				
					if(!empty($errors)) {
						echo function_form_print_errors($errors);
					} else {
						echo $message;
					}
				?>
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
								<input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username)?>" placeholder="Enter username or email">
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
							<div class="col-sm-offset-2 col-sm-10">
								<div class="checkbox">
									<label><input type="checkbox" name="remember"> Remember me</label>
								</div>
							</div>
						</div>
						<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" name="submit" class="btn btn-default">Log in</button>
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
<?php include 'includes/footer.html' ?>
