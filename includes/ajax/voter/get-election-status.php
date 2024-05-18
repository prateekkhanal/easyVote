<?php

include "../../../connect.php";
$eid = $_GET['eid'];
$statusQuery = '			SELECT 
				 CASE
					  WHEN (CURDATE() < start_date AND start_date < end_date) THEN "not-started"
					  WHEN ((CURDATE() = start_date AND CURTIME() < start_time) AND (start_time <= end_time)) THEN "not-started"
					  WHEN ((CURDATE() BETWEEN start_date AND end_date) AND (start_date < end_date)) then "started"
					  WHEN ((CURDATE() > end_date AND start_date < end_date) and (start_date <= end_date)) THEN "ended"
					  WHEN ((CURDATE() = end_date AND CURTIME() < end_time) and (start_date <= end_date)) THEN "started"
					  WHEN ((start_date = end_date AND start_time < end_time) AND (CURTIME() < end_date)) THEN "not-started"
					  WHEN ((start_date = end_date AND start_time < end_time) AND (CURTIME() > end_date)) THEN "ended"
					  WHEN ((CURDATE() = end_date AND CURTIME() > end_time) AND (start_date <= end_date)) THEN "ended"
					  ELSE "invalid date/time range"
				 END AS status
			FROM election WHERE electionID = \''.$eid.'\'';

echo $statusQuery;

$statusResult = mysqli_query($conn, $statusQuery);

if ($statusResult->num_rows > 0) {
	while($status = $statusResult->fetch_assoc()) {
		$electionStatus = $status['status'];
	}
} else {
	$electionStatusus = 'N/A';
}
echo $electionStatus;
