<?php
	session_start();
   include "../../includes/display_message.php";
   include "../../includes/regular_functions.php";
	
	// if user isn't signned in, redirect to the login page
	if (!isset($_SESSION['role'])) {
		$_SESSION['msg'] = 'You need to login first!';
		redirectHere($_SERVER['PHP_SELF']);
		header("Location: ../../signin.php");
	}
	$isAdmin = checkIfAdmin($_SESSION['vid']);

	// get the user role 
	if (isset($_GET['role'])) {
		// check the role requested
		$role = $_GET['role'];
		if ($role == 'admin') {
			// check if the current user has admin privileges
			if ($isAdmin) {
				// switch the role to admin
				if ($role == $_SESSION['role']) {
					$_SESSION['msg'] = 'You are ALREADY ADMIN!';
				} else {
					$_SESSION['msg-success'] = 'You now have ADMIN privileges!';
					$_SESSION['role'] = 'admin';
				}
			} else {

			} 
		} 

		header("Location: " . $_SERVER['PHP_SELF']);

		if ($role == 'manager') {
				if ($role == $_SESSION['role']) {
					$_SESSION['msg'] = 'You are ALREADY MANAGER!';
				} else {
					$_SESSION['msg-success'] = 'You now have MANAGER privileges!';
					$_SESSION['role'] = 'manager';
				}
			} 
		}

		if ($role == 'candidate') {
				if ($role == $_SESSION['role']) {
					$_SESSION['msg'] = 'You are ALREADY CANDIDATE!';
				} else {
					$_SESSION['msg-success'] = 'You now have CANDIDATE privileges!';
					$_SESSION['role'] = 'candidate';
				}
		} 
		if ($role == 'voter') {
				if ($role == $_SESSION['role']) {
					$_SESSION['msg'] = 'You are ALREADY VOTER!';
				} else {
					$_SESSION['msg-success'] = 'You now have VOTER privileges!';
					$_SESSION['role'] = 'voter';
				}
		}
	function checkIfAdmin($vid) {
		include "../../connect.php";
		$getAdmin = "SELECT * FROM admins WHERE vid = $vid;";
		
		$rows = mysqli_query($conn, $getAdmin);
		if ($row = $rows->num_rows > 0) {
			return true;
		}
		return false;
		}
?>


Choose Role:

<ul>
	<?php if ($isAdmin) : ?>
		<li><a href="?role=admin">Admin</a></li>
	<?php endif; ?>
	<li><a href="?role=manager">Manager</a></li>
	<li><a href="?role=candidate">Candidate</a></li>
	<li><a href="?role=voter">Voter</a></li>
</ul>
