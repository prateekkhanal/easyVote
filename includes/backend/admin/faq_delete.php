<?php
	include "../../../connect.php";
	$faqid = $_GET['qid'];
	$sql = "DELETE FROM faq WHERE qid=$faqid;";
	/* echo $sql; */
	$result = mysqli_query($conn, $sql);
	if ($result) {
		echo "Category Deleted Successfully!!!";
		include "./faq.php";
	} else {
		echo "Category couldn't be deleted!!!";
	}
?>
