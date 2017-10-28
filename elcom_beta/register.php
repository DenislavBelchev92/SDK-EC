<?php
//$expire = time() + (60*60*24*7);
//setcookie('test', 21, $expire);
include_once "core/php/init.php";

$current_page = "register.html";
$users_db = new users_database();

//$cols = array('first_name');
//$vals = array('Deni');
//$users_db->update_user('Denis', $cols, $vals);

if (isset($_POST['submit'])) {

	$message = "";
	$errors = array();
	
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);	
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$email = trim($_POST['email']);
	
	// Check relevant fields
	$fields_required = array("first_name","last_name","username", "password", "email");
	foreach($fields_required as $field) {
		$value = trim($_POST[$field]);
		if(!has_presence($value)){
			$error = $field . '_input_missing';
			$errors['$error'] = ucfirst($field) . 'cannot be blank!';
		}
	}

	// Check if input within valida range
	user_login_input_validate($username, $password, $errors);

	if (empty($errors)){
		$vals_array = array($first_name, $last_name, $username, $password, $email);
		$users_db->insert_user($vals_array);
	}

} else {
	$username="";
	$message = "It won't hurt";
}
?>

<html lang="bg">
	<!-- Include the head(metatags and title) -->
	<?php include 'includes/head.html' ?>
	
<body>
<div class="page"> 
	<!-- Include the navigation bars -->
	<?php include 'includes/navbar.html' ?>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
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
			
			<div class="col-md-6">
				<div class="">
					<h2>Register</h2>
					<form class="form-horizontal" action="register.php" method="POST">
						<div class="form-group">
							<div class="col-sm-12">
								<label class="control-label" for="username">First Name:</label>
							</div>
							<div class="col-sm-12">
								<input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name)?>" placeholder="Enter username or email">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<label class="control-label" for="pwd">Last Name:</label>
							</div>
							<div class="col-sm-12">          
								<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter password">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<label class="control-label" for="username">Username:</label>
							</div>
							<div class="col-sm-12">
								<input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username)?>" placeholder="Enter username or email">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<label class="control-label" for="pwd">Password:</label>
							</div>
							<div class="col-sm-12">          
								<input type="password" class="form-control" id="pwd" name="password" placeholder="Enter password">
							</div>
						</div>						
						<div class="form-group">
							<div class="col-sm-12">
								<label class="control-label" for="pwd">Email:</label>
							</div>
							<div class="col-sm-12">          
								<input type="text" class="form-control" id="email" name="email" placeholder="Enter email">
							</div>
						</div>

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
<?php include 'includes/footer.html' ?>
