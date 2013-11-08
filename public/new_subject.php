<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); //check for authorization?>
<?php $layout_context = "admin" //Note that this page is on the admin panel and use PHP to adjust CSS and navigation.?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page(); //Check if page or subject are selected, if so set it?>
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
						<h2 class="panel-title">Create New Subject</h2>
						Create a new subject for your pages to be categorized under.
					</div>
					<div class="panel-body">
						<form role="form" action="create_subject.php" method="post">
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
								$subject_set = find_all_subjects(false);
								$subject_count = mysqli_num_rows($subject_set);
									for($count=1; $count<=($subject_count+1); $count++) {
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
							<input type="submit" name="submit" value="Create Subject" class="btn btn-primary btn-lg"/>
							<a href="manage_content.php" class="btn btn-default btn-lg">Cancel</a>
						</form>
					</div>
				</div>
			</section>
		</div>
<?php include("../includes/layouts/footer.php"); ?>