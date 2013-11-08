<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php find_selected_page(); //Check if page or subject are selected, if so set it?>
<?php confirm_logged_in(); //check for authorization?>
<?php 
	if(!$current_subject) {
		//if ID is missing or cant be found in db
		redirect_to("manage_content.php");
	}
?>
<?php $layout_context = "admin"?>
<?php
if (isset($_POST['submit'])) {
	// Process the form
	
	// validations
	$required_fields = array("menu_name", "position", "visible");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("menu_name" => 30);
	validate_max_lengths($fields_with_max_lengths);
	
	if (empty($errors)) {
		
		// Perform Update

		$id = $current_subject["id"];
		$menu_name = mysql_prep($_POST["menu_name"]);
		$position = (int) $_POST["position"];
		$visible = (int) $_POST["visible"];
	
		$query  = "UPDATE subjects SET ";
		$query .= "menu_name = '{$menu_name}', ";
		$query .= "position = {$position}, ";
		$query .= "visible = {$visible} ";
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);

		if ($result && mysqli_affected_rows($connection) >= 0) {
			// Success
			$_SESSION["message"] = "Subject updated.";
			redirect_to("manage_content.php");
		} else {
			// Failure
			$message = "Subject update failed.";
		}
	
	}
} else {
	// This is probably a GET request
	
} // end: if (isset($_POST['submit']))

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
					<div class="panel-footer">
						<a href="new_subject.php"><span class="glyphicon glyphicon-pencil"></span> Create a new subject</a>
					</div>
				</div>
			</aside>
			<!-- Main content-->
			<section class="col-md-9" role="main">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title">Edit the <?php echo htmlentities($current_subject["menu_name"]); ?> Subject</h2>
						Here you can update your excisting subject.
					</div>
					<div class="panel-body">
						<form role="form" action="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]);?>" method="post">
							<p class="text-danger message"><?php if(!empty($message)) {echo htmlentities($message);} //If message is not empty display it here. This is a variable, not a part of session.?></p>
							<p class="message"><?php echo form_errors($errors); ?></p>
							<div class="form-group">
								<label for="menu_name">Menu name:</label>
								<input type="text" class="form-control" name="menu_name" id="menu_name" value="<?php echo htmlentities($current_subject["menu_name"]); ?>" />
							</div>
							<div class="form-group">
								<label for="position">Position:</label>
								<select class="form-control" name="position" id="position">
								<?php 
								$subject_set = find_all_subjects(false);
								$subject_count = mysqli_num_rows($subject_set);
									for($count=1; $count<=($subject_count); $count++) {
										echo "<option value=\"{$count}\"";
										if($current_subject["position"]==$count) {
											echo " selected";
										}
										echo ">{$count}</option>";
									}
								?>
								</select>
							</div>
							<div class="form-group">
								<label for="">Visible:</label>
								<input type="radio" name="visible" value="0" <?php if($current_subject["visible"]==0) {echo "checked";} ?> /> No
								<input type="radio" name="visible" value="1" <?php if($current_subject["visible"]==1) {echo "checked";} ?> /> Yes
							</div>
							<input type="submit" name="submit" value="Update Subject" class="btn btn-primary btn-lg"/>
							<?php 
							//In case the user wants to delete subjects that are populated with child pages, make him delete those pages first.
							$pages_set = find_pages_for_subjects($current_subject["id"], false);
							if (mysqli_num_rows($pages_set)>0) {
								echo "<a class=\"btn btn-danger btn-lg\" disabled=\"disabled\">Cannot delete subjects with child pages</a>";
							} else if (mysqli_num_rows($pages_set)==0) {
								echo "<a data-toggle=\"modal\" href=\"#myModal\" class=\"btn btn-danger btn-lg\">Delete Subject</a>";
							}
						?>
						<a href="manage_content.php" class="btn btn-default btn-lg">Cancel</a>
						</form>
						<!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
						  <div class="modal-content">
						    <div class="modal-header">
						      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						      <h4 class="modal-title">Are you sure you want to delete <?php echo $current_subject["menu_name"]; ?>?</h4>
						    </div>
						    <div class="modal-body">
						      <button type="button" class="btn btn-default btn-block" data-dismiss="modal">No, don't delete it.</button>
						      <a href="delete_subject.php?subject=<?php echo urlencode($current_subject["id"]);?>" type="button" class="btn btn-danger btn-block">Yes, delete <?php echo $current_subject["menu_name"]; ?>.</a>
						    </div>
						  </div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
						  </div><!-- /.modal -->
					</div>
				</div>
			</section>
		</div>
<?php include("../includes/layouts/footer.php"); ?>