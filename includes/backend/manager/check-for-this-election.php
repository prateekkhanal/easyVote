<?php

$vid = $_SESSION['vid'];
$eid = $_GET['eid'];

$checkSql = "
	SELECT 
	CASE 
	WHEN
	EXISTS (SELECT * FROM election_manager WHERE vid = $vid AND eid = (SELECT eid FROM election WHERE electionID = '$eid')) 	OR 
	EXISTS (SELECT * FROM election WHERE electionID = '$eid' AND vid = $vid)
        then 'yes'
        else 'no'
        end as manager
";

$check = mysqli_query($conn, $checkSql);
while ($result = $check->fetch_assoc()) {
	if ($result['manager'] != 'yes') {
		die("You are not authorized to manage this election! Please contact the Election manager to be added as a assistant-manager!");
	}
}

?>
