<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php confirm_logged_in(); //check for authorization?>
<?php $layout_context = "admin" //Note that this page is on the admin panel and use PHP to adjust CSS and navigation.?>
<?php find_selected_page(); ?>

<?php
  // Can't add a new page unless we have a subject as a parent!
  if (!$current_subject) {
    // subject ID was missing or invalid or 
    // subject couldn't be found in database
    redirect_to("manage_content.php");
  }
?>

<?php
if (isset($_POST['submit'])) {
	// Process the form

	// validations
	$required_fields = array("menu_name", "position", "visible", "content");
	validate_presences($required_fields);

	$fields_with_max_lengths = array("menu_name" => 30);
	validate_max_lengths($fields_with_max_lengths);

	if (empty($errors)) {
	// Perform Create

	// make sure you add the subject_id!
	$subject_id = $current_subject["id"];
	$menu_name = mysql_prep($_POST["menu_name"]);
	$position = (int) $_POST["position"];
	$visible = (int) $_POST["visible"];
	// be sure to escape the content
	$content = mysql_prep($_POST["content"]);

	$query  = "INSERT INTO pages (";
	$query .= "  subject_id, menu_name, position, visible, content";
	$query .= ") VALUES (";
	$query .= "  {$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}'";
	$query .= ")";
	$result = mysqli_query($connection, $query);

	if ($result) {
			// Success
			$_SESSION["message"] = "Page created.";
			redirect_to("manage_content.php?subject=" . urlencode($current_subject["id"]));
		} else {
			// Failure
			$_SESSION["message"] = "Page creation failed.";
		}
	}
} else {
  
}
?>

<?php include("../includes/layouts/header.php"); ?>
<div class="container">
	<div class="row">
		<!-- Sidebar navigation-->
		<aside class="col-md-3">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title">Subjects and Pages</h2>
				</div>
				<div class="panel-body">
					<?php echo navigation($current_subject, $current_page); ?>
				</div>
			</div>
		</aside>
		<!-- Main content-->
		<section class="col-md-9" role="main">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title">Create New Page</h2>
					Create a new page for the <?php echo htmlentities($current_subject["menu_name"]); ?> subject.
				</div>
				<div class="panel-body">
					<!--Page CreationForm-->
					<form role="form" action="new_page.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post">
					<p class="text-danger"><?php echo message(); ?></p>
					<?php $errors = errors(); ?>
					<p class="message"><?php echo form_errors($errors); ?></p>
						<div class="form-group">
							<label for="menu_name">Menu name:</label>
							<input type="text" class="form-control" name="menu_name" id="menu_name" value="" />
						</div>
						<div class="form-group">
							<label for="position">Position:</label>
							<select class="form-control" name="position" id="position">
							<?php
								$page_set = find_pages_for_subjects($current_subject["id"], false);
								$page_count = mysqli_num_rows($page_set);
								for($count=1; $count <= ($page_count + 1); $count++) {
									echo "<option value=\"{$count}\">{$count}</option>";
								}
					        ?>
							</select>
						</div>
						<div class="form-group">
							<label for="">Visible:</label>
							<input type="radio" name="visible" value="0"/> No
							<input type="radio" name="visible" value="1"/> Yes
						</div>
						<div class="form-group">
							<label for="">Content:</label>
							<textarea name="content" class="form-control" rows="5"></textarea>
						</div>
						<input type="submit" name="submit" value="Create Page" class="btn btn-primary btn-lg"/>
						<a href="manage_content.php?subject=<?php echo urlencode($current_subject["id"]); ?>" class="btn btn-default btn-lg">Cancel</a>
					</form>
				</div>
			</div>
		</section>
	</div>
<?php include("../includes/layouts/footer.php"); ?>