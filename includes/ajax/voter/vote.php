<?php

$vid = isset($_GET['vid']) ? $_GET['vid'] : '';
$cid = isset($_GET['cid']) ? $_GET['cid'] : '';

if (empty($vid) || empty($cid)) {
	echo "Vote Failed! Invalid VoterID or CandidateID!";
} else {
	include "../../../connect.php";
	$voteQuery = "INSERT INTO votes (vid, cid) VALUES((SELECT voterID from voters WHERE vid = $vid), '$cid')";
	try {
	($vote = mysqli_query($conn, $voteQuery));
		$_SESSION['msg-success'] = "Voted Successfully!";
	} catch (Exception $e) {
		$_SESSION['msg-error'] = "Voting Failed! You have already Voted for this candidate!";
	}
	displayMessage();
}
?>
