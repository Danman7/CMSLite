<?php if(!isset($layout_context)) {$layout_context = "public";} //The CMS uses a layout variable to determine whether the user is in the admin or public section.?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php if ($layout_context == "admin") {echo "Admin Panel";} else {echo "Website";} ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- jQuery -->
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<!-- CSS -->
	<link rel="stylesheet" href="css/styles.css">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<!-- Local JS -->
	<script src="js/scripts.js"></script>
	<script src="js/modal.js"></script>
	<script src="js/transition.js"></script>
</head>
<body <?php if ($layout_context == "public") {echo "class=\"public_body\"";} ?>>
	<header>
		<nav class="navbar navbar-default navbar-static-top <?php if ($layout_context == "public") {echo "navbar-inverse";}?>" role="navigation">
			<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex7-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php"><?php if ($layout_context == "admin") {echo "Admin Panel";} else {echo "Website";} ?></a>
	        </div>
			<ul class="nav navbar-nav">
				<?php if ($layout_context == "admin") {
						$output = "<li><a href=\"admin.php\"><span class=\"glyphicon glyphicon-home\"></span> Admin Panel</a></li>";
						$output .= "<li><a href=\"manage_content.php\"><span class=\"glyphicon glyphicon-edit\"></span> Manage Content</a></li>";
						$output .= "<li><a href=\"manage_admins.php\"><span class=\"glyphicon glyphicon-user\"></span> Manage Administrators</a></li>";
						echo $output;
					}
				?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php if ($layout_context == "admin") {
					if (logged_in()) {
						echo "<li><a href=\"edit_admin.php?id=".urlencode($_SESSION["admin_id"])."\">"
					.htmlentities($_SESSION["username"])."</a></li><li><a href=\"logout.php\"><span class=\"glyphicon glyphicon-log-out\"></span> Logout</a></li>";
					} else {
						echo "<li><a href=\"login.php\"><span class=\"glyphicon glyphicon-log-in\"></span> Login</a></li>";
					}
				}
				?>
			</ul>
			</div>
		</nav>
	</header>