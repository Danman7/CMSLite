<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); //check for authorization?>
<?php $layout_context = "admin" ?>
<?php find_selected_page(); ?>

<?php
  if (!$current_page) {
    redirect_to("manage_content.php");
  }
?>

<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  $id = $current_page["id"];
  $menu_name = mysql_prep($_POST["menu_name"]);
  $position = (int) $_POST["position"];
  $visible = (int) $_POST["visible"];
  $content = mysql_prep($_POST["content"]);

  // validations
  $required_fields = array("menu_name", "position", "visible", "content");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("menu_name" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    
    // Perform Update

    $query  = "UPDATE pages SET ";
    $query .= "menu_name = '{$menu_name}', ";
    $query .= "position = {$position}, ";
    $query .= "visible = {$visible}, ";
    $query .= "content = '{$content}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
      $_SESSION["message"] = "Page updated.";
      redirect_to("manage_content.php?page={$id}");
    } else {
      // Failure
      $_SESSION["message"] = "Page update failed.";
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
					<h2 class="panel-title">Edit <?php echo htmlentities($current_page["menu_name"]); ?> Page</h2>
				</div>
				<div class="panel-body">
					<!--Page Update Form-->
					<form role="form" action="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>" method="post">
					<p class="text-danger"><?php echo message(); ?></p>
					<?php $errors = errors(); ?>
					<p class="message"><?php echo form_errors($errors); ?></p>
						<div class="form-group">
							<label for="menu_name">Menu name:</label>
							<input type="text" class="form-control" name="menu_name" id="menu_name" value=" <?php echo htmlentities($current_page["menu_name"]); ?>" />
						</div>
						<div class="form-group">
							<label for="position">Position:</label>
							<select class="form-control" name="position" id="position">
							<?php
					          $page_set = find_pages_for_subjects($current_page["subject_id"], false);
					          $page_count = mysqli_num_rows($page_set);
					          for($count=1; $count <= $page_count; $count++) {
					            echo "<option value=\"{$count}\"";
					            if ($current_page["position"] == $count) {
					              echo " selected";
					            }
					            echo ">{$count}</option>";
					          }
					        ?>
							</select>
						</div>
						<div class="form-group">
							<label for="">Visible:</label>
							<input type="radio" name="visible" value="0" <?php if ($current_page["visible"] == 0) { echo "checked"; } ?> /> No
							<input type="radio" name="visible" value="1" <?php if ($current_page["visible"] == 1) { echo "checked"; } ?> /> Yes
						</div>
						<div class="form-group">
							<label for="">Content:</label>
							<textarea name="content" class="form-control" rows="5"><?php echo htmlentities($current_page["content"]); ?></textarea>
						</div>
						<input type="submit" name="submit" value="Edit Page" class="btn btn-primary btn-lg"/>
						<a data-toggle="modal" href="#myModal" class="btn btn-danger btn-lg">Delete Page</a>
						<a href="manage_content.php?subject=<?php echo urlencode($current_subject["id"]); ?>" class="btn btn-default btn-lg">Cancel</a>
					</form>
					<!--Modal for "are you sure you want to delete this page"-->
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Are you sure you want to delete <?php echo $current_page["menu_name"]; ?>?</h4>
							</div>
							<div class="modal-body">
								<button type="button" class="btn btn-default btn-block" data-dismiss="modal">No, don't delete it.</button>
								<a href="delete_page.php?page=<?php echo urlencode($current_page["id"]); ?>" type="button" class="btn btn-danger btn-block">Yes, delete <?php echo $current_page["menu_name"]; ?>.</a>
							</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
				</div>
			</div>
		</section>
	</div>
<?php include("../includes/layouts/footer.php"); ?>