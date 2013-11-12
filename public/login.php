<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$username = "";

if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("username", "password");
  validate_presences($required_fields);
  
  if (empty($errors)) {
    // Attempt Login

		$username = $_POST["username"];
		$password = $_POST["password"];
		
		$found_admin = attempt_login($username, $password);

    if ($found_admin) {
	      // Success
				// Mark user as logged in
				$_SESSION["admin_id"] = $found_admin["id"];
				$_SESSION["username"] = $found_admin["username"];
	      redirect_to("admin.php");
	    } else {
	      // Failure
	      $_SESSION["message"] = "Username/password not found.";
	    }
  	}
} else {
	  
}
?>
<?php $layout_context = "public"?>
<?php include("../includes/layouts/header.php"); ?>
<div class="container">
	<div class="row">
		<!-- Main content-->
		<section class="col-md-4 col-md-offset-4" role="main">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title">Login</h2>
				</div>
				<div class="panel-body">
					<!--New Admin Form-->
					<form role="form" action="login.php" method="post">
					<p class="text-danger"><?php echo message(); ?></p>
					<p class="message"><?php echo form_errors($errors); ?></p>
						<div class="form-group">
							<label for="username">Username:</label>
							<input type="text" class="form-control" name="username" id="username" value="<?php echo htmlentities($username); ?>" />
						</div>
						<div class="form-group">
							<label for="password">Password:</label>
							<input type="password" class="form-control" name="password" id="password">
						</div>
						<div class="form-group">
							<input type="submit" name="submit" value="Login" class="btn btn-primary btn-lg btn-block"/>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
<?php include("../includes/layouts/footer.php"); ?>