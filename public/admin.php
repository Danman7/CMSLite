<?php require_once("../includes/session.php");?>
<?php require_once("../includes/functions.php");?>
<?php confirm_logged_in(); //check for authorization?>
<?php $layout_context = "admin" ?>
<?php include("../includes/layouts/header.php"); ?>
	<div class="container">
		<div class="row">
			<!-- Main content-->
			<section class="col-md-12" role="main">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title">Admin Panel</h2>
						Welcome to the admin area <?php echo htmlentities($_SESSION["username"]); ?>!
					</div>
					<div class="panel-body">
						<p>You have successfully logged in as administrator <?php echo htmlentities($_SESSION["username"]); ?>. You can <a href="edit_admin.php?id=<?php echo urlencode($_SESSION["admin_id"]);?>"> edit your profile</a> from your profile page.</p>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title">Basic Tutorial</h2>
					</div>
					<div class="panel-body">
						<p>Logged in to the admin panel just fine? Good. Now what?</p>
						<p>CMSLite has two simple functions: <strong>manage content and manage people who have access to this content</strong>. How can you do that?</p>
						<p>You can go to <a href="manage_content.php">Manage Content</a> and select a page or subject to edit or delete. There you can also create new subjects or pages for your existing subject.</p>
						<p><strong>Subjects are basically categories you organize your pages into</strong>. You can only insert content into pages and you cannot delete Subjects with child pages in them. Every subject has:</p>
							<ol>
							 	<li>its menu name, which shows when the user browses the navigation</li>
							 	<li>its position which is used to rearrange subject order in the navigation</li>
							 	<li>its visibility so you can hide certain content from public users</li>
							</ol> 
						<p>Same thing goes for pages, with the inclusion of content. For now all you can do is add new lines to the content with "Enter". No stylization for now.</p>
						<p>You can go to <a href="manage_admins.php">Manage Admins</a> and add, edit and delete admins from the table. For now all admins can have is a usernames and password.</p>
					</div>
				</div>
			</section>
		</div>
	</div>
<?php include("../includes/layouts/footer.php"); ?>