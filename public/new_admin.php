<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php confirm_logged_in(); //check for authorization?>
<?php
if (isset($_POST['submit'])) {
	// Process the form

	// validations
	$required_fields = array("username", "password");
	validate_presences($required_fields);

	$fields_with_max_lengths = array("username" => 30);
	validate_max_lengths($fields_with_max_lengths);

	if (empty($errors)) {
	// Perform Admin Creation
	$username = mysql_prep($_POST["username"]);
	$hashed_password = password_encrypt($_POST["password"]);

	$query  = "INSERT INTO admins (";
	$query .= "  username, hashed_password";
	$query .= ") VALUES (";
	$query .= "  '{$username}', '{$hashed_password}'";
	$query .= ")";
	$result = mysqli_query($connection, $query);

	if ($result) {
			// Success
			$_SESSION["message"] = "New administrator created.";
			redirect_to("manage_admins.php");
		} else {
			// Failure
			$_SESSION["message"] = "Admin creation failed.";
		}
	}
} else {
  
}
?>
<?php $layout_context = "admin"?>
<?php include("../includes/layouts/header.php"); ?>
<div class="container">
	<div class="row">
		<!-- Main content-->
		<section class="col-md-12" role="main">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title">New Administrator</h2>
					Add an admin to the website.
				</div>
				<div class="panel-body">
					<!--New Admin Form-->
					<form role="form" action="new_admin.php" method="post">
					<p class="text-danger"><?php echo message(); ?></p>
					<p class="message"><?php echo form_errors($errors); ?></p>
						<div class="form-group">
							<label for="username">Username:</label>
							<input type="text" class="form-control" name="username" id="username" value="" />
						</div>
						<div class="form-group">
							<label for="password">Password:</label>
							<input type="password" class="form-control" name="password" id="password">
						</div>
						<div class="form-group">
							<input type="submit" name="submit" value="Add New Admin" class="btn btn-primary btn-lg"/>
							<a href="manage_admins.php" class="btn btn-default btn-lg">Cancel</a>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
<?php include("../includes/layouts/footer.php"); ?>