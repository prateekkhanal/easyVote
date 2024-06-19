<?php
session_start();
include "../../../connect.php";
include "../../regular_functions.php";

if (isset($_SESSION['vid'])) {
	$vid = $_SESSION['vid'];
	if (isset($_GET['rid'])) {
		$rid = $_GET['rid'];
		$checkIfAllowed = "
			   select 
   	    (select count(*) from candidate where vid = (select voterID from voters where vid = $vid) and eid = (SELECT eid FROM roles WHERE rid = $rid)) as otherRequests,
   	    (select count(*) from parties where eid = (SELECT eid FROM roles WHERE rid = $rid) and parties.status = 'open') as partyStatus,
			  (SELECT			
									CASE
								  WHEN (CURDATE() < start_date AND start_date < end_date) THEN 'not-started'
								  WHEN ((CURDATE() = start_date AND CURTIME() < start_time) AND (start_time <= end_time)) THEN 'not-started'
								  WHEN ((CURDATE() BETWEEN start_date AND end_date) AND (start_date < end_date)) then 'started'
								  WHEN ((CURDATE() > end_date AND start_date < end_date) and (start_date <= end_date)) THEN 'ended'
								  WHEN ((CURDATE() = end_date AND CURTIME() < end_time) and (start_date <= end_date)) THEN 'started'
								  WHEN ((start_date = end_date AND start_time < end_time) AND (CURTIME() > end_date)) THEN 'ended'
										 WHEN ((start_date = end_date AND start_time < end_time) AND (CURTIME() < end_date)) THEN 'not-started'
								  WHEN ((CURDATE() = end_date AND CURTIME() > end_time) AND (start_date <= end_date)) THEN 'ended'
								  ELSE 'N/A'
							 END AS status from election WHERE election.electionID = (SELECT eid FROM roles WHERE rid = $rid)
				) as electionStatus,
	case when (SELECT make_request from roles where rid = $rid) = 'anyone' 
		then 'success' else 'not-needed' end as anyone,
	 case when 
	 	(SELECT make_request from roles where rid = $rid) = 'verified' and (SELECT authentic FROM voters where voterID = (SELECT voterID from voters where vid=$vid)) = 'yes'
	  then 'success' 
      when (SELECT make_request from roles where rid = $rid) <> 'verified' then 'not-needed'
      else 'failed' end as verified,
	  case 
when ((SELECT make_request from roles where rid = $rid) = 'location') and ((SELECT election.lid from roles join election on election.eid = roles.eid join voters on voters.lid = election.lid WHERE roles.rid = $rid and voters.voterID = (SELECT voterID from voters where vid = $vid)) is not null)
then 'success'
	when ((SELECT make_request from roles where rid = $rid) <> 'location')
    then 'not-needed'
else 'failed' end as location,
	   case when 
	(SELECT make_request from roles where rid = $rid) = 'chosen' and (SELECT count(*) FROM registered_candidates as rc WHERE rc.rid = $rid and rc.vid = (SELECT voterID from voters where vid = $vid)) 
	    then 'success'
        when 
	(SELECT make_request from roles where rid = $rid) <> 'chosen'
   then 'not-needed'
        else 'failed'  end as chosen";	
$getCandidateInfo = "
				parties.name as partyName, parties.partyID, roles.position
				from candidate join parties on
				 parties.partyID = candidate.pid 
				join roles on roles.rid = candidate.rid 
				where candidate.vid = (select voterID from voters where vid = 3) 
				and candidate.eid = (select eid from roles where rid = 3);
				";
					/* echo "<pre>"; */
					/* echo $checkIfAllowed; */
					$result = mysqli_query($conn, $checkIfAllowed);
					/* echo "hehehe"; */
					$answer = $result->fetch_assoc();
					/* print_r($answer); */
					/* echo "</pre>"; */

					$canRun = true;
					$votedFor = $answer['votedFor'];
					$failures = $successes = array();

					if ($answer['otherRequests'] == 0) {
						$successes[] = '<p class="'.$answer['otherRequests'].'">You <i>haven\'t sent requests</i> for any other role in the election!</p>';
					}  else {
						$failures[] = '<p class="'.$answer['otherRequests'].'">You have already sent request for some role in this election!</p>';
					}


					if ($answer['partyStatus'] > 0 ) {
						$successes[] = '<p class="'.$answer['partyStatus'].'">There '.(($answer['partyStatus'] > 1) ? 'are '.$answer['partyStatus'].' PARTIES ' : 'is 1 PARTY ').' <i>AVAILABLE!</i></p>';
					} else {
						$failures[] = '<p class="'.$answer['partyStatus'].'">There is <i>NO PARTY</i> available!</p>';
					}

					if ($answer['electionStatus'] == 'not-started') {
						$successes[] = '<p class="'.$answer['electionStatus'].'">Election <i>HASN\'T STARTED</i> yet!</p>';
					} else {
						$failures[] = '<p class="'.$answer['electionStatus'].'">Election has <i style="text-transform: uppercase;">'.$answer['electionStatus'].'</i> already!</p>';
					}


					if ($answer['anyone'] == 'success') {
						$successes[] = '<p class="'.$answer['chosen'].'">You must have been<i> REGISTERED</i>!</p>';
					} else if ($answer['anyone'] == 'failed'){
						$failures[] = '<p class="'.$answer['chosen'].'">You are <i>NOT REGISTERED</i>!</p>';
					}

					if ($answer['verified'] == 'success') {
						$successes[] = '<p class="'.$answer['chosen'].'">Your account must be <i>VERIFIED</i>!</p>';
					} else if ($answer['verified'] == 'failed'){
						$failures[] = '<p class="'.$answer['chosen'].'">Your account is\'t <i>VERIFIED</i> by the <i>ELECTION MANAGER</i></p>';
					}

					if ($answer['location'] == 'success') {
						$successes[] = '<p class="'.$answer['chosen'].'">You must be from the <i>SAME LOCATION</i>!</p>';
					} else if ($answer['location'] == 'failed'){
						$failures[] = '<p class="'.$answer['chosen'].'">You are <i>NOT FROM THE SAME LOCATION</i> as the election!</p>';
					}

					if ($answer['chosen'] == 'success') {
						$successes[] = '<p class="'.$answer['chosen'].'">You must be <i>REGISTERED</i> by the <i>ELECTION MANAGER</i></p>';
					} else if ($answer['chosen'] == 'failed'){
						$failures[] = '<p class="'.$answer['chosen'].'">You aren\'t <i>REGISTERED</i> by the <i>ELECTION MANAGER</i></p>';
					}

					$time = $answer['time'];

					if (!empty($failures)) {
						$canRun = false;
					}

					/* echo "<pre>Failures : ";print_r($failures); */
					/* echo "Successes : ";print_r($successes); */
					/* echo "</pre>"; */
			if ($_GET['check'] == "true") {
	?>
		<hr>
		<style>
			table th {
		padding: 20px;
	}
		td {
		padding: 0px;
	}
	p {
		padding: 10px;
	}
			td {
				font-size: 50px;
				text-align: center;
			}
		
	h2 {
		font-style: italic;
	}
	.descriptions p {
	display: inline-block;
	}
		</style>
	<h1>Can I Run As a Candidate?</h1>
	<h2>Quick Answer : <big><?=($canRun) ? 'Yes' : 'No'?></big></h2>
	<br>
	<hr>
	<h1>Summary</h1>
		<table border="1" cellpadding="10" cellspacing="0">
			<thead>
				<tr><th colspan="7">Requirements</th></tr>
				<tr>
					<th style="border-bottom: none;"></th>
					<th>Other Requests</th>
					<th>Parties Available</th>
					<th>Election Status</th>
					<th>Authentication</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th rowspan="2"  style="border-top: none;">FulFillments</th>
					<td><p title="<?=$answer['otherRequests']?>"><?= ($answer['otherRequests'] == 0) ? '&#9989;' : (($answer['otherRequests'] > 0) ? '&#10060;' : '&#8213;')?></p></td>
					<td><p title="<?=$answer['partyStatus']?>"><?= ($answer['partyStatus'] > 0) ? '&#9989;' :  '&#10060;';?></p></td>
					<td><p title="<?=$answer['electionStatus']?>"><?= ($answer['electionStatus'] == 'started') ? '&#10060;' : (($answer['electionStatus'] == 'ended') ? '&#10060;' : '&#9989;')?></p></td>
					<td><p title="authentication"><?php if ($answer['anyone'] != 'failed' && $answer['verified'] != 'failed' && $answer['location'] != 'failed' && $answer['chosen'] != 'failed') {echo '&#9989;';} else{ echo '&#10060;';}?></p></td>
				</tr>
			</tbody>
			<tfoot>
			</tfoot>
		</table>
		<br>
		<hr>
		<br>
	<h1>Status Descriptions</h1>
	<div class="descriptions">
		<div class="failures">
			<h2>Failures</h2>
			<?php
			if (empty($failures)) {
				echo "<li><i>All conditions are met! You <i>CAN RUN in this election</i>!</i> &#9989;</li>";
			} else {
				foreach($failures as $failure) {
					echo "<li>". $failure ."&#10060;</li>";
				}
			}
			?>

		</div>
		<div class="successes">
			<h2>Successes</h2>
			<ul>
			<?php
			if (empty($successes)) {
				echo "<li><i>No conditions are met</i>&#10060;</li>";
			} else {
				foreach($successes as $success) {
					echo "<li>". $success ."&#9989;</li>";
				}
			}
			?>
			</ul>
		</div>
	</div>
	<?php

			}
	} else {
		echo "No Role is selected to check!";
	}
} else {
	$_SESSION['msg'] = 'You need to login first!';
	redirectHere('localhost'.$_SERVER['REQUEST_URI']);
	header("Location: ../../../signin.php");
}

?>

