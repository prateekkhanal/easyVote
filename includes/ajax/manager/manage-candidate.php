<?php
	session_start();
	include "../../../connect.php";

	$cid = urldecode($_GET['cid']);
	$mid = $_GET['mid'];
	$status = $_GET['status'];
	$eid = urldecode($_GET['eid']);

	$updateCandidateSql = "
					UPDATE candidate 
						SET
						verified = '$status'
					WHERE 
						candidateID = '$cid'
					AND
					(
						EXISTS (
							SELECT * FROM election WHERE vid = $mid and electionID = '$eid'
							)
						OR EXISTS (
						SELECT * FROM election_manager WHERE eid = (SELECT eid from election WHERE electionID = '$eid') AND vid = '$mid'
							)
					)
";

	if (mysqli_query($conn, $updateCandidateSql)) {
		echo "Candidate Updated Successfully!";
		$_SESSION['msg-success'] = "Candidate <i><big>".$cid."</big></i> Updated Successfully!";
		/* header("Location: ../../../includes/backend/manager/candidates.php?eid="+urlencode($cid)); */
	} else {
		echo "Failed to Update Candidate! Try Again!";
	}

?>
