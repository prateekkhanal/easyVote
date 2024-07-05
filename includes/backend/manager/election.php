<?php
	include "../../../includes/regular_functions.php";
	include "../../../sidebar/sidebar.php";

	// allow user to create the election only if he is logged in
	if (!isset($_SESSION['vid'])) {
		$_SESSION['msg'] = "You need to LOGIN to create an election!";
		redirectHere($_SERVER['PHP_SELF']);
		header("Location: ../../../signin.php");
		exit;
	}

	// swith the role to manager
	if (role() != 'manager') { $_SESSION['msg'] = "Your role is switched to MANAGER!";}
	setRole('manager');
	displayMessage();
	

	/* echo "You can create an election!"; */

	include "./list-elections.php";
?>
