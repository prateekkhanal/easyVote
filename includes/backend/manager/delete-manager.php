<?php

include "../../../connect.php";
session_start();

// ensure both id of the assistant and election are given
if (isset($_GET['eid'])) {
	$eid = $_GET['eid'];
	if (isset($_GET['vid'])) {
		$vid = $_GET['vid'];
		// delete
		$delete = "DELETE FROM election_manager where eid=(SELECT eid from election where electionID = '$eid') and vid = (select vid from voters where voterID = '$vid')";
		/* echo $delete; die; */
		if ($result = mysqli_query($conn, $delete)) {
			$_SESSION['msg-success'] = "Manager <big><b>$vid</b></big> Removed Successfully!";
			header("Location: ./manage-assitants.php?eid=".urlencode($eid));
		}

	} else {
	$vid = $_GET['vid'];
		$_SESSION['msg-error'] = "No manager chosen";
	}
} else {
	$_SESSION['msg-error'] = "No election chosen";
}

?>
