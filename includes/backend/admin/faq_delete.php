<?php
	session_start();
	include "../../../connect.php";
	$faqid = $_GET['qid'];
	$sql = "DELETE FROM faq WHERE qid=$faqid;";
	/* echo $sql; */
	$result = mysqli_query($conn, $sql);
	if ($result) {
		$_SESSION['msg-success'] = "Category Deleted Successfully!!!";
	} else {
		$_SESSION['msg-success'] = "Category couldn't be deleted!!!";
	}
		header("Location: faq.php");
?>
