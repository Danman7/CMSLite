<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php $layout_context = "public" //Define that this section is part of the public website. PHP will adjust navigation and CSS classes.?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page(true); //Check if page or subject are selected, if so set it?>
	<div class="container">
		<div class="row">
			<!-- Sidebar navigation-->
			<aside class="col-md-3">
				<?php echo public_navigation($current_subject, $current_page); ?>
			</aside>
			<!-- Main content-->
			<section class="col-md-9" role="main">
				<?php if ($current_page) { ?>
					<h2><?php echo htmlentities($current_page["menu_name"]); ?></h2>
				<?php } else { ?>
					<h2>Welcome to your website.</h2>
				<?php }	?>
				<?php if ($current_page) { ?>
					<?php echo nl2br(htmlentities($current_page["content"])); ?>
				<?php } else { ?>
					<p>This is the homepage.</p>
				<?php }	?>
			</section>
		</div>
	</div>
<?php include("../includes/layouts/footer.php"); ?>