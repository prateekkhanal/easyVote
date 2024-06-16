<?php

session_start();

include '../../../connect.php';
include "../../regular_functions.php";

displayMessage();

if (isset($_SESSION['vid'])) {
	// check if the user has already created election
	if ($_SESSION['role'] == 'candidate') {
		// continue
		include './elections.php';
		?>
	<?php
	} else {
		echo "You need to switch role to CANDIDATE to view the candidates!";
	}

} else {
	$_SESSION['msg'] = "You need to login first!";
	redirectHere($_SERVER['PHP_SELF']);
	header("Location: ../../../signin.php");
}
?>

