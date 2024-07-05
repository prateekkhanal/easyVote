<?php

include "../../../connect.php";

$q = $_GET['q'];
$view = $_GET['view'];
$lid = $_GET['lid'];

$electionsQuery = 'SELECT title, electionID, level, locations.location_name, (select make_request from roles where eid = election.electionID limit 1) as authentication , count(roles.eid) as roles, election.description,
				 CASE
					  WHEN (CURDATE() < start_date AND start_date < end_date) THEN "not-started"
					  WHEN ((CURDATE() = start_date AND CURTIME() < start_time) AND (start_time <= end_time)) THEN "not-started"
					  WHEN ((CURDATE() BETWEEN start_date AND end_date) AND (start_date < end_date)) then "started"
					  WHEN ((CURDATE() > end_date AND start_date < end_date) and (start_date <= end_date)) THEN "ended"
					  WHEN ((CURDATE() = end_date AND CURTIME() < end_time) and (start_date <= end_date)) THEN "started"
					  WHEN ((start_date = end_date AND start_time < end_time) AND (CURTIME() > end_date)) THEN "ended"
                      WHEN ((start_date = end_date AND start_time < end_time) AND (CURTIME() < end_date)) THEN "not-started"
					  WHEN ((CURDATE() = end_date AND CURTIME() > end_time) AND (start_date <= end_date)) THEN "ended"
					  ELSE "N/A"
				 END AS status
				 FROM election JOIN locations ON locations.lid = election.lid LEFT JOIN roles ON roles.eid = election.electionID
				 WHERE election.level <> "rejected" and election.view = ';
/* public' AND election.lid like '$lid' AND election.title LIKE '%$q%' GROUP by election.electionID ORDER BY election.eid desc;'; */
if ($view == 'public') {
	$electionsQuery .= '\'public\' AND election.lid LIKE \''.$lid.'\' AND election.title LIKE \'%'.$q.'%\'';
} else if ($view == 'private') {
	$electionsQuery .= '\'private\' AND election.lid LIKE \''.$lid.'\' AND election.electionID = \''.$q.'\'';
}
	$electionsQuery .=  ' GROUP by election.electionID ORDER BY election.eid desc;';
/* echo $electionsQuery; */
$electionsResult = mysqli_query($conn, $electionsQuery);
$count = false;
$elections = '';
if ($electionsResult->num_rows > 0) {
	while ($election = $electionsResult->fetch_assoc()) {
		/* print_r($election); */
		if ($count) { $elections .= '<hr>';}
		$count = true;
  $elections .= '
				  <div class="card">
					 <h2><a href="javascript: void(0)">'.$election['title'].'</a><small>
				(<i>'.$election['electionID'].'</i>)</small>
				</h2>
					 <div class="notes">
						  <strong>Level</strong>: <big><i>'.$election['level'].'</i></big>
							<br>
						  <strong>Location</strong>: <big><i>'.$election['location_name'].'</i></big>
							<br>
					 </div>
					 <div class="candidate-details" onclick="getRoles(\''.$election['electionID'].'\', this)">
						<strong>Roles: </strong> '.$election['roles'].' (<a href="javascript: void(0)"><i>View Details</i></a>)
					 </div>
					 <div class="additional-info">
						<p class="description">'.$election['description'].'</p>
					 </div>
					 <button id="spectate" onclick="window.location = \'../../frontend/voter/election.php?eid='.urlencode($election['electionID']).'\'">Spectate</button>
					<a href="javascript: void(0)" class="status '.$election['status'] .'">'.$election['status'].'</a>
				  </div>';
	}
} else {
	$elections .= "<h3>No elections Found!</h3>";
}
echo $elections;
