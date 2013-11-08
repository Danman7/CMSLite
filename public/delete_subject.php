<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); //check for authorization?>
<?php find_selected_page(); //Check if page or subject are selected, if so set it?>
<?php 
	$current_subject = find_subject_by_id($_GET["subject"], false);
	if(!$current_subject) {
		//if subject is missing or cant be found in db
		redirect_to("manage_content.php");
	}

	$id = $current_subject["id"];
	$query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
	$result = mysqli_query($connection, $query);
	if ($result && mysqli_affected_rows($connection)==1) {
		// Success
		$_SESSION["message"] = "Subject deleted.";
			redirect_to("manage_content.php");
	} else {
		$_SESSION["message"] = "Subject deletetion failed.";
			redirect_to("manage_content.php?subject={$id}");
	}
?>