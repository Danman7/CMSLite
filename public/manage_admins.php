<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php confirm_logged_in(); //check for authorization?>
<?php
  $admin_set = find_all_admins();
?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
	<div class="container">
		<div class="row">
			<!-- Sidebar navigation-->
			<aside class="col-md-3">
				
			</aside>
			<!-- Main content-->
			<section class="col-md-12" role="main">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title">Manage Administrators</h2>
						Add new administrators or edit excising ones.
					</div>
					<div class="panel-body">
						 <?php echo message(); ?>
						 <table class="table">
						 	<th>Username</th>
						 	<th colspan="2">Actions</th>
						 	<?php while($admin = mysqli_fetch_assoc($admin_set)) { ?>
						 	<tr>
						 		<td><?php echo htmlentities($admin["username"]); ?></td>
						 		<td><a href="edit_admin.php?id=<?php echo urlencode($admin["id"]);?>"><span class="glyphicon glyphicon-wrench"></span> Edit</a></td>
						 		<td><a data-toggle="modal" href="#myModal"><span class="glyphicon glyphicon-remove"></span> Delete</a></td>
						 	</tr>
						 	<!--Modal for "are you sure you want to delete this admin"-->
							<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h4 class="modal-title">Are you sure you want to remove <?php echo htmlentities($admin["username"]); ?>?</h4>
									</div>
									<div class="modal-body">
										<button type="button" class="btn btn-default btn-block" data-dismiss="modal">No, don't remove <?php echo htmlentities($admin["username"]); ?>!</button>
										<a href="delete_admin.php?id=<?php echo urlencode($admin["id"]);?>" type="button" class="btn btn-danger btn-block">Yes, remove <?php echo htmlentities($admin["username"]); ?>.</a>
									</div>
									</div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
						 	<?php } ?>
						 	<tr><td colspan="3"><a href="new_admin.php"><span class="glyphicon glyphicon-user"></span> Add a new admin</a></td></tr>
						 </table>
					</div>
				</div>
			</section>
		</div>
<?php include("../includes/layouts/footer.php"); ?>