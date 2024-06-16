<?php
session_start();
include "../../../connect.php";
include "../../regular_functions.php";

$rid = (isset($_GET['rid']) ? $_GET['rid'] : '');
$pid = (isset($_GET['pid']) ? $_GET['pid'] : '');

if (isset($_SESSION['vid'])) {
	$vid = $_SESSION['vid'];
	if (!empty($rid)){
		$checkIfAllowed = "
			select 
			(	SELECT			
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
			) as time
			,
				case when (SELECT authentication from election where electionID = (SELECT eid from roles where rid = $rid)) = 'anyone' 
					then 'success' else 'not-needed' end as anyone,
				 case when 
					(SELECT authentication from election where electionID = (SELECT eid from roles where rid = $rid)) = 'verified' and (SELECT authentic FROM voters where voterID = (SELECT voterID from voters where vid=$vid)) = 'yes'
				  then 'success' 
					when (SELECT authentication from election where electionID = (SELECT eid from roles where rid = $rid)) <> 'verified' then 'not-needed'
					else 'failed' end as verified,
				  case 
			when ((SELECT authentication from election where electionID = (SELECT eid from roles where rid = $rid)) = 'location') and ((SELECT election.lid from roles join election on election.electionID = roles.eid join voters on voters.lid = election.lid WHERE roles.rid = $rid and voters.voterID = (SELECT voterID from voters where vid = $vid)) is not null)
			then 'success'
				when ((SELECT authentication from election where electionID = (SELECT eid from roles where rid = $rid)) <> 'location')
				 then 'not-needed'
			else 'failed' end as location,
					case when 
				(SELECT authentication from election where electionID = (SELECT eid from roles where rid = $rid)) = 'chosen' and (SELECT count(*) FROM registered_voters as rv WHERE rv.eid = (SELECT eid from roles where rid = $rid) and rv.vid = (SELECT voterID from voters where vid = $vid)) 
					 then 'success'
					  when 
				(SELECT authentication from election where electionID = (SELECT eid from roles where rid = $rid)) <> 'chosen'
				then 'not-needed'
					  else 'failed'  end as chosen,	
			CASE when (
								 select votes.cid from votes join candidate on candidate.candidateID = votes.cid WHERE candidate.rid = $rid and votes.vid = (SELECT voterID from voters where vid = $vid)
							) is not null then 'yes' else 'no' 
							end as votedAlready, 
							(
								 select votes.cid from votes join candidate on candidate.candidateID = votes.cid WHERE candidate.rid = $rid and votes.vid = (SELECT voterID from voters where vid = $vid)
							) as votedFor;

			";
					/* echo $checkIfAllowed; */
					$result = mysqli_query($conn, $checkIfAllowed);
					/* echo "hehehe"; */
					$answer = $result->fetch_assoc();
					/* echo "<pre>"; */
					/* print_r($answer); */
					/* echo "</pre>"; */

					$canVote = true;
					$votedFor = $answer['votedFor'];
					$failures = $successes = array();

					if ($answer['anyone'] == 'success' || $answer['anyone'] == 'not-needed') {
						$successes[] = '<p class="'.$answer['anyone'].'">You must have an <i>easyVote</i> account!</p>';
					} 

					if ($answer['verified'] == 'success' || $answer['verified'] == 'not-needed') {
						$successes[] = '<p class="'.$answer['verified'].'">Your account must be <i>VERIFIED</i>!</p>';
					} else {
						$failures[] = '<p class="'.$answer['verified'].'">Your account <i>isn\'t verified</i>!</p>';
					}

					if ($answer['location'] == 'success' || $answer['location'] == 'not-needed') {
						$successes[] = '<p class="'.$answer['location'].'">You must belong to the <i>SAME LOCATION</i> where the election is being held!</p>';
					} else {
						$failures[] = '<p class="'.$answer['location'].'">You <i>don\'t</i> belong to the <i>SAME LOCATION</i> where the election is being held!</p>';
					}

					if ($answer['chosen'] == 'success' || $answer['chosen'] == 'not-needed') {
						$successes[] = '<p class="'.$answer['chosen'].'">You must be <i>REGISTERED</i> by the <i>ELECTION MANAGER</i></p>';
					} else {
						$failures[] = '<p class="'.$answer['chosen'].'">You aren\'t <i>REGISTERED</i> by the <i>ELECTION MANAGER</i></p>';
					}

					$voteAlready = ($answer['votedAlready'] == 'yes') ? true : false;

					if (!$voteAlready) {
						$successes[] = '<p class="success">You <i>HAVEN\'T VOTED YET</i>! You can choose the candidate</p>';
					} else {
						$failures[] = '<p class="failed">You have <i>ALREADY VOTED</i> for a Candidate in this election! You can just observe the election now!</p>';
					}

					$time = $answer['time'];

					if ($time == 'ended') {
						$failures[] = '<p class="failed">Time has <i>Ended</i>!</p>';
					}

					if (!empty($failures) | $voteAlready) {
						$canVote = false;
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
	<h1>Can I Vote? </h1>
	<h2>Quick Answer : <big><?=($canVote) ? 'Yes' : 'No'?></big></h2>
	<br>
	<hr>
	<h1>Summary</h1>
		<table border="1" cellpadding="10" cellspacing="0">
			<thead>
				<tr><th colspan="7">Requirements</th></tr>
				<tr>
					<th style="border-bottom: none;"></th>
					<th>Time</th>
					<th>Registration</th>
					<th>Verified Account</th>
					<th>Same Location</th>
					<th>Registered by Manager</th>
					<th>Not Voted Yet</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th rowspan="2"  style="border-top: none;">FulFillments</th>
					<td><p title="<?=$answer['time']?>"><?= ($answer['time'] == 'started') ? '&#9989;' : (($answer['time'] == 'ended') ? '&#10060;' : '&#8213;')?></p></td>
					<td><p title="<?=$answer['anyone']?>"><?= ($answer['anyone'] == 'success') ? '&#9989;' : (($answer['anyone'] == 'failed') ? '&#10060;' : '&#8213;')?></p></td>
					<td><p title="<?=$answer['verified']?>"><?= ($answer['verified'] == 'success') ? '&#9989;' : (($answer['verified'] == 'failed') ? '&#10060;' : '&#8213;')?></p></td>
					<td><p title="<?=$answer['location']?>"><?= ($answer['location'] == 'success') ? '&#9989;' : (($answer['location'] == 'failed') ? '&#10060;' : '&#8213;')?></p></td>
					<td><p title="<?=$answer['chosen']?>"><?= ($answer['chosen'] == 'success') ? '&#9989;' : (($answer['chosen'] == 'failed') ? '&#10060;' : '&#8213;')?></p></td>
					<td><p title="<?=$answer['votedAlready']?>"><?= ($answer['votedAlready'] == 'no') ? '&#9989;' : (($answer['votedAlready'] == 'yes') ? '&#10060;' : '&#8213;')?></p></td>
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
				echo "<li><i>All conditions are met! You <i>CAN VOTE</i>!</i> &#9989;</li>";
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
		echo "There isn't any role to check!";
	}
} else {
	$_SESSION['msg'] = 'You need to login first!';
	redirectHere($_SERVER['PHP_SELF']);
	header("Location: ../../../signin.php");
}

?>
