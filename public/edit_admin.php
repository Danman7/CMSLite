<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); //check for authorization?>
<?php confirm_logged_in(); //check for authorization?>
<?php $layout_context = "admin" ?>

<?php
  $admin = find_admin_by_id($_GET["id"]);
  if (!$admin) {
  	redirect_to("manage_admins.php");
  }
?>

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
	$id = $admin["id"];
	$username = mysql_prep($_POST["username"]);
	$hashed_password = password_encrypt($_POST["password"]);

	$query  = "UPDATE admins  SET ";
	$query .= "username = '{$username}', ";
	$query .= "hashed_password = '{$hashed_password}' ";
	$query .= "WHERE id = {$id} ";
	$query .= "LIMIT 1";
	$result = mysqli_query($connection, $query);

	if ($result && mysqli_affected_rows($connection)==1) {
			// Success
			$_SESSION["message"] = "Admin details updated.";
			redirect_to("manage_admins.php");
		} else {
			// Failure
			$_SESSION["message"] = "Admin update failed.";
		}
	}
} else {
  
}
?>

<?php include("../includes/layouts/header.php"); ?>
<div class="container">
	<div class="row">
		<!-- Main content-->
		<section class="col-md-12" role="main">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title">Edit admin details for <?php echo htmlentities($admin["username"]); ?></h2>
				</div>
				<div class="panel-body">
					<!--Admin Update Form-->
					<form role="form" action="edit_admin.php?page=<?php echo urlencode($admin["id"]); ?>" method="post">
					<p class="text-danger"><?php echo message(); ?></p>
					<?php $errors = errors(); ?>
					<p class="message"><?php echo form_errors($errors); ?></p>
						<div class="form-group">
							<label for="username">Username:</label>
							<input type="text" class="form-control" name="username" id="username" value="<?php echo htmlentities($admin["username"]);?>" />
						</div>
						
						<div class="form-group">
							<label for="password">Password:</label>
							<input type="password" class="form-control" name="password" id="password">
							<p class="text-info">You will have to either change or re-enter your password.</p>
						</div>
						<div class="form-group">
							<input type="submit" name="submit" value="Edit Admin" class="btn btn-primary btn-lg"/>
							<a href="manage_admins.php" class="btn btn-default btn-lg">Cancel</a>
						</div>
					</form>
					<!--Modal for "are you sure you want to delete this page"-->
				</div>
			</div>
		</section>
	</div>
<?php include("../includes/layouts/footer.php"); ?>