<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>

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
					<div class="panel-footer">
						<a href="new_subject.php"><span class="glyphicon glyphicon-pencil"></span> Create a new subject</a><br>
						<?php if ($current_subject) {?>
						<a href="new_page.php?subject=<?php echo urlencode($current_subject["id"]);?>"><span class="glyphicon glyphicon-pencil"></span> Create a new page for this subject</a>
						<?php } ?>
					</div>
				</div>
			</aside>
			<!-- Main content-->
			<section class="col-md-9" role="main">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<?php if ($current_subject) {?>
							<h2 class="panel-title">Manage Subject</h2>
							You can now edit the selected subject below.
						<?php } elseif ($current_page) { ?>
							<h2 class="panel-title">Manage Page</h2>
							You can now edit the selected page below.
						<?php } else { ?>	
							<h2 class="panel-title">Manage Content</h2>
							Select a subject or page from the left to edit, update or delete.
						<?php }	?>
					</div>
					<div class="panel-body">
						<p class="text-info message"><?php echo message();?></p>
						<?php if ($current_subject) {?>
							<?php ?>
							<h2><?php echo htmlentities($current_subject["menu_name"]); ?></h2>
							<p><a href="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]);?>" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit Subject</a></p>
							<p>Position: <?php echo $current_subject["position"]; ?></p>
							<p>Visible: <?php echo $current_subject["visible"] == 1 ? 'yes' : 'no'; ?></p>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Pages in this subject:</h3>
								</div>
								<div class="panel-body">
									<?php 
										$subject_pages = find_pages_for_subjects($current_subject["id"], false);
										while ($page = mysqli_fetch_assoc($subject_pages)) {
											echo "<li>";
											$safe_page_id = urlencode($page["id"]);
											echo "<a href=\"manage_content.php?page={$safe_page_id}\">";
											echo htmlentities($page["menu_name"]);
											echo "</a></li>";
										}
									?>
								</div>
							</div>
						<?php } elseif ($current_page) { ?>
							<h2><?php echo htmlentities($current_page["menu_name"]); ?></h2>
							<p><a href="edit_page.php?page=<?php echo urlencode($current_page["id"]);?>" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit Page</a></p>
							<p>Position: <?php echo $current_page["position"]; ?></p>
							<p>Visible: <?php echo $current_page["visible"] == 1 ? 'yes' : 'no'; ?></p>
							<?php echo htmlentities($current_page["content"]); ?>
						<?php } else { ?>
							<p>Please select a subject or a page to edit, from the navigation on the left.</p>
						<?php }	?>
					</div>
				</div>
			</section>
		</div>
	</div>
<?php include("../includes/layouts/footer.php"); ?>