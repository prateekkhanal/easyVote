<?php

session_start();

include '../../../connect.php';
include "../../../sidebar/right/view-election.php";
include "../../regular_functions.php";

displayMessage();

if (isset($_GET['eid'])) {
	$eid = $_GET['eid'];
if (isset($_SESSION['vid'])) {
	// check if the user has already created election
	if ($_SESSION['role'] == 'manager') {
		// continue
		include './check-for-this-election.php';
		include './manage-candidate.php';
		?>
	<?php
	} else {
		echo "You need to switch role to manager to view the candidates!";
	}

} else {
	header("Location: ../../../signin.php");
}
} else {
	echo 'Election not chosen to view the candidates!';
}
?>
