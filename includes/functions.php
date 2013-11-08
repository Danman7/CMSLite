<?php
	//Redirection
	function redirect_to ($new_location) {
		header("Location: " . $new_location);
		exit;
	}

	//Prepare an sql request
	function mysql_prep($string) {
		global $connection;		
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}

	//Put the whole sidebar navigation in a function, takes 2 arguments - current subject or page
	function navigation($subject_array, $page_array) {
		$output = "<ul class=\"nav nav-pills nav-stacked\">";
		//Subjects db query
		$subject_set = find_all_subjects(false);
		//Use returned data from query about subjects (if any)
		while($subject = mysqli_fetch_assoc($subject_set)) {
			//Highlight selected
			$output .= "<li";
				if ($subject_array && $subject["id"]==$subject_array["id"]) {
					$output .= " class=\"active\"";
				}
			$output .= ">"; 
			$output .= "<a href=\"manage_content.php?subject=";
			$output .= urlencode($subject["id"]); 
			$output .= "\">";
			$output .= htmlentities($subject["menu_name"]); //Populate navigation with subjects
			$output .="</a>";
			//Pages db query
			$page_set = find_pages_for_subjects($subject["id"], false);
			$output .= "<ul class=\"nav nav-pills nav-stacked secondary-nav\">";
			//Populate the pages
			while($page = mysqli_fetch_assoc($page_set)) { 
				//Highlight selected
				$output .= "<li";
					if ($page_array && $page["id"]==$page_array["id"]) {
						$output .= " class=\"active\"";
					}
				$output .= ">";
				$output .= "<a href=\"manage_content.php?page=";
				$output .= urlencode($page["id"]);
				$output .= "\">";
				$output .= $page["menu_name"]; //Populate navigation with pages under each subject
				$output .= "</a></li>";
			}
			//Release returned pages data
			mysqli_free_result($page_set);
			$output .="</ul></li>";
		}
		//Release returned subjects data
		mysqli_free_result($subject_set);
		$output .= "</ul>";
		return $output;
	}

	//Public navigation
	function public_navigation($subject_array, $page_array) {
		$output = "<ul class=\"nav nav-pills nav-stacked\">";
		//Subjects db query
		$subject_set = find_all_subjects();
		//Use returned data from query about subjects (if any)
		while($subject = mysqli_fetch_assoc($subject_set)) {
			//Highlight selected
			$output .= "<li";
				if ($subject_array && $subject["id"]==$subject_array["id"]) {
					$output .= " class=\"active\"";
				}
			$output .= ">"; 
			$output .= "<a href=\"index.php?subject=";
			$output .= urlencode($subject["id"]); 
			$output .= "\">";
			$output .= htmlentities($subject["menu_name"]); //Populate navigation with subjects
			$output .="</a>";
			//In the public navigation, we want to have an accordion effect when a subject is selected
			if ($subject_array["id"] == $subject["id"] || $page_array["subject_id"] == $subject["id"]) {
				//Pages db query
				$page_set = find_pages_for_subjects($subject["id"]);
				$output .= "<ul class=\"nav nav-pills nav-stacked secondary-nav\">";
				//Populate the pages
				while($page = mysqli_fetch_assoc($page_set)) { 
					//Highlight selected
					$output .= "<li";
						if ($page_array && $page["id"]==$page_array["id"]) {
							$output .= " class=\"active\"";
						}
					$output .= ">";
					$output .= "<a href=\"index.php?page=";
					$output .= urlencode($page["id"]);
					$output .= "\">";
					$output .= $page["menu_name"]; //Populate navigation with pages under each subject
					$output .= "</a></li>";
				}
				$output .="</li>";//end of subject list item
				$output .="</ul>";
				//Release returned pages data
				mysqli_free_result($page_set);
			}
		}
		//Release returned subjects data
		mysqli_free_result($subject_set);
		$output .= "</ul>";
		return $output;
	}

	//Generate form errors
	function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<div class=\"error text-danger\">";
		  $output .= "Please fix the following errors:";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
				$output .= htmlentities($error);
				$output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		return $output;
	}

	//Check if a query to the database was successful
	function confirm_query ($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}

	//Find all subjects in the db
	function find_all_subjects($public=true) {
		global $connection;
		$query  = "SELECT * ";
		$query .= "FROM subjects ";
		if ($public) { 
			//Checks if the page is part of the public area, and hides non visible items if true
			$query .= "WHERE visible = 1 ";
		}
		// $query .= "WHERE visible = 1 ";
		$query .= "ORDER BY position ASC";
		$subject_set = mysqli_query($connection, $query);
		// Test if there was a query error
		confirm_query($subject_set);
		return $subject_set;
	}

	//Find pages for a subject
	function find_pages_for_subjects($subject_id, $public=true){
		global $connection;
		//Make safe from injections
		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
		//Query to db
		$query  = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE subject_id = {$safe_subject_id} ";
		if ($public) {
			//Checks if the page is part of the public area, and hides non visible items if true
			$query .= "AND visible = 1 ";
		}
		$query .= "ORDER BY position ASC";
		$page_set = mysqli_query($connection, $query);
		// Test if there was a query error
		confirm_query($page_set);
		return $page_set;
	}

	//Find all admins in the db
	function find_all_admins() {
	global $connection;

	$query  = "SELECT * ";
	$query .= "FROM admins ";
	$query .= "ORDER BY username ASC";
	$admin_set = mysqli_query($connection, $query);
	confirm_query($admin_set);
	return $admin_set;
	}
	//Find the subject in db by id
	function find_subject_by_id($subject_id, $public=true) {
		global $connection;
		//Make safe from injections
		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
		//Query to db
		$query  = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id = {$safe_subject_id} ";
		if ($public) {
			$query .= "AND visible = 1 "; //This makes sure that even if the user types a hidden page's url by hand it will not display
		}
		$query .= "LIMIT 1";
		$subject_set = mysqli_query($connection, $query);		
		confirm_query($subject_set);// Test if there was a query error
		if ($subject = mysqli_fetch_assoc($subject_set)) {
			return $subject;
		} else {
			return null;
		}
	}

	//Find the page in db by id
	function find_page_by_id($page_id, $public=true) {
		global $connection;
		//Make safe from injections
		$safe_page_id = mysqli_real_escape_string($connection, $page_id);
		//Query to db
		$query  = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE id = {$safe_page_id} ";
		if ($public) {
			$query .= "AND visible = 1 "; //This makes sure that even if the user types a hidden page's url by hand it will not display
		}
		$query .= "LIMIT 1";
		$page_set = mysqli_query($connection, $query);		
		confirm_query($page_set);// Test if there was a query error
		if ($page = mysqli_fetch_assoc($page_set)) {
			return $page;
		} else {
			return null;
		}
	}

	//Find the administrator in db by id
	function find_admin_by_id($admin_id) {
		global $connection;

		//Make safe from injections
		$safe_admin_id = mysqli_real_escape_string($connection, $admin_id);
		//Query to db
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "WHERE id = {$safe_admin_id} ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);		
		confirm_query($admin_set);// Test if there was a query error
		if ($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}

	//Find the administrator in db by username
	function find_admin_by_username($username) {
		global $connection;

		//Make safe from injections
		$safe_username = mysqli_real_escape_string($connection, $username);
		//Query to db
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "WHERE username = '{$safe_username}' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);		
		confirm_query($admin_set);// Test if there was a query error
		if ($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}

	//Find default page for subject
	function find_default_page_for_subject($subject_id) {
		$page_set = find_pages_for_subjects($subject_id);
		if($first_page = mysqli_fetch_assoc($page_set)) {
			return $first_page;
		} else {
			return null;
		}
	}

	//Find which page was selected fr editing
	function find_selected_page($public=false) {
		global $current_subject;
		global $current_page;
		if(isset($_GET["subject"])) {
		$current_subject = find_subject_by_id($_GET["subject"], $public);
			if ($current_subject && $public) {
			$current_page = find_default_page_for_subject($current_subject["id"]);
			}
		} elseif (isset($_GET["page"])) {
			$current_subject = null;
			$current_page = find_page_by_id($_GET["page"], $public);
		} else {
			$current_subject = null;
			$current_page = null;	
		}
	}

	//Encrypt passwords
	function password_encrypt ($password) {
		$hash_format = "$2y$10$"; //We want to use Blowfish algorithm 10 times
		$salt_length = 22; //Setup how long you want the hash to be, longer strings will be truncated to this value
		$salt = generate_salt($salt_length);
		$format_and_salt = $hash_format . $salt;
		$hash = crypt($password, $format_and_salt);
		return $hash;
	}


	//Generate the extra spice for the password
	function generate_salt($length) {
		$unique_random_string = md5(uniqid(mt_rand(), true)); //Not actually unique, but pretty descent for the job, MD5 algorithm will produce 32 chars
		$base64_string = base64_encode($unique_random_string); //Make valid chars to be a-z A-Z "/" "." and 0-9 
		$modified_base64_string = str_replace('+', '.', $base64_string); //Exclude "+"
		$salt = substr($modified_base64_string, 0, $length); //After salt is encrypted, shorten it to the given length in password_encrypt
		return $salt;
	}

	//Compare password with the hashed version on the db
	function password_check($password, $existing_hash) {
		// existing hash contains format and salt at start
	  $hash = crypt($password, $existing_hash);
	  if ($hash === $existing_hash) {
	    return true;
	  } else {
	    return false;
	  }
	}

	//Attempt a login and authenticate
	function attempt_login($username, $password) {
		$admin = find_admin_by_username($username);
		if ($admin) {
			// found admin, now check password
			if (password_check($password, $admin["hashed_password"])) {
				// password matches
				return $admin;
			} else {
				// password does not match
				return false;
			}
		} else {
			// admin not found
			return false;
		}
	}
	
	//Check if user has logged in to view admin content
	function logged_in() {
		return isset($_SESSION['admin_id']);
	}

	function confirm_logged_in() {
		if(!logged_in()) {
			redirect_to("login.php");
		}	
	}
?>