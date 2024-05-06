<?php
	session_start();
	include "../../connect.php";

	$pid = $_GET['pid'];
	$eid = $_GET['eid'];
	$pn = $_GET['pn'];

	$sql = "DELETE FROM parties WHERE partyID='$pid' and parties.eid='$eid';;";
	
	$result = mysqli_query($conn, $sql);

	if ($result) {
		$_SESSION['msg-success'] = "Party <big>" . $pn . "</big> Deleted Successfully!!!";
	} else {
		$_SESSION['msg-error'] = "Party <big>" . $pn . "</big> couldn't be deleted!!!";
	}

	header("Location: list-parties.php?eid=".urlencode($_GET['eid'])."&et=".urlencode($_GET['et']));
?>
