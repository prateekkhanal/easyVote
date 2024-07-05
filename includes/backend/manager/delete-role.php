<?php
	session_start();
	include "../../../connect.php";

	$rid = $_GET['rid'];
	$eid = $_GET['eid'];
	$position = $_GET['position'];

	$sql = "DELETE FROM roles WHERE rid=$rid;";
	$result = mysqli_query($conn, $sql);

	if ($result) {
		$_SESSION['msg-success'] = "Role <big>" . $position . "</big> Deleted Successfully!!!";
	} else {
		$_SESSION['msg-error'] = "Election <big>" . $position . "</big> couldn't be deleted!!!";
	}

	header("Location: manage-election.php?eid=".urlencode($_GET['eid'])."&et=".urlencode($_GET['et']));
?>
