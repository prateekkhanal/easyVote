<?php
	include "../../backend/manager/election-timer.php";
	include "../../../sidebar/left/candidate.php";
	include "../../../sidebar/sidebar.php";
?>
<div class="main">
  <style>
* {
	font-family: "Lato", sans-serif;
	padding: 0px;
	margin: 0px;
}
.sidebar-page {
	grid-area: menu;
	position: fixed;
	top: 350px;
	left: 300px;
	z-index: 0.5;
}
.sidebar-page ul li, a {
	list-style: none;
	text-decoration: none;
	font-style: italic;
	font-size: 0.9em;
	margin: 15px 0px;
	color: black;
	
}
.main-content {
	grid-area: main;
	margin-right: 50px;
	margin-left: 0px;
	padding-left: 0px;
	padding-right: 0px;
	padding-top: 10px;
	padding-bottom: 125px;
	font-size: 1em;
	max-width: 1000px;
	min-width: 1000px;
	text-align: justify;
 }

table {
	font-size: 0.9em;
	min-width: 400px;
	
}

.container {
  display: grid;
  grid-template-areas:
    'footer footer footer footer menu';
  /* background-color: #2196F3; */
  /* background-color: lightgray; */
}

.grid-container > div {
  background-color: rgba(255, 255, 255, 0.8);
  text-align: center;
  padding: 20px 0;
  font-size: 25px;
}

.description {
	min-width: 1000px;
	font-size: 0.9em;
}
table {
	border-collapse: collapse;
}
table th, td{
	border: 2px solid black;
padding: 10px;
}
	
table td img {
	border-radius: 50%;
	max-width: 100px;
}

h2.center {
	text-align: center;
	margin-bottom: 10px;
}

  </style>
  <div class="container">
    <div class="main-content">
<?php

	session_start();
	
	if (isset($_GET['eid'])) {
		$eid = $_GET['eid'];

		include "../../../connect.php";
		include "../../regular_functions.php";

	$getElectionDetails = "
   	select e.title, e.vid, e.electionID, (SELECT voterID from voters where vid = (select vid from election where electionID = '$eid')) as vID, (SELECT voterID from voters where vid = (SELECT vid from election where electionID='$eid')) AS mID,
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
							 END AS status from election WHERE election.electionID = '$eid'
				) as electionStatus
,e.level, e.view, e.start_date, e.end_date, e.start_time, e.end_time, l.location_name, e.description as electionDescription from election as e join locations as l on l.lid = e.lid
where electionID = '$eid';
";

		$electionDetails = mysqli_query($conn, $getElectionDetails);


		/* echo "<pre>"; */
		/* print_r($electionDetails); */
		$electionDetail = $electionDetails->fetch_assoc();
		/* print_r($electionDetail); */
		/* echo "</pre>"; */
		if ($electionDetails->num_rows > 0) {
			/* echo "Election exists!"; */

?>
	<h2 class="center"><?=$electionDetail['title']?>&ensp;&ensp;<?php include "./pinning-elections.html"; include "./pinning-elections.php";?></h2> 
		<h2 class="center">(<?=$electionDetail['electionID']?>)&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</h2><br>
<br>
<hr>
<br>
      <h2 id="election">Election Details</h2><br>
		<p><span class="title">Level : </span><?=$electionDetail['level']?></p>
		<p><span class="title">View : </span><?=$electionDetail['view']?></p>
		<p><span class="title">Location : </span><?=$electionDetail['location_name']?></p><br>
		<p><span class="title">Schedule : </span><br><br>
<table>
	<thead>
	  <tr>
		 <th>Start-Date</th>
		 <th>End-Date</th>
		 <th>Start-Time</th>
		 <th>End-Time</th>
	  </tr>
	</thead>
	<tbody>
	  <tr>
	  <td><?=$electionDetail['start_date']?></td>
	  <td><?=$electionDetail['end_date']?></td>
	  <td><?=$electionDetail['start_time']?></td>
	  <td><?=$electionDetail['end_time']?></td>
	  </tr>
	</tbody>
</table>

</p><br>
		<p><span class="title">Summary : </span><?=$electionDetail['electionStatus']?></p><br>
		<div class="description">
			<p><span class="title">Description : </span><br><br><?=$electionDetail['electionDescription']?></p>
		</div>
<br><hr><br>

	<h2 id="roles">Roles</h2><br>
<?php
$getRoles = "
			select r.rid, r.position, r.place, r.make_request, r.description from roles as r WHERE r.eid = '$eid';
			";

		$rolesDescriptions = $partiesDescriptions = array();
			$roleCount = $partyCount = 1;
		$roles = mysqli_query($conn, $getRoles);

		/* echo "<pre>"; */
		/* print_r($roles); */
		if ($roles->num_rows > 0) {
?>
		<table>
			<thead>
			  <tr>
				 <th>Count</th>
				 <th>Position</th>
				 <th>Place</th>
				 <th>Check</th>
		<?php if ($_SESSION['role'] == 'candidate') { ?>
				<th>Run-Now</th>
		<?php } else {?>
				<th>Vote-Now</th>
		<?php } ?>

			  </tr>
			</thead>
			<tbody>
<?php
		while ($role = $roles->fetch_assoc()) {
		/* print_r($role); */
			$rolesDescriptions[] = $role['description'];
?>
	  <tr>
	  <td><?=$roleCount++?></td>
	  <td><?=$role['position']?></td>
	  <td><?=$role['place']?></td>

	<?php if ($_SESSION['role'] == 'candidate') { ?>
		<th><a class="button" href="../candidate/can-i-run-as-a-candidate.php?rid=<?=$role['rid']?>&check=true">Can-I-Run-As-A-Candidate?</a></th>
		<th><a class="button" href="../candidate/run-now.php?rid=<?=$role['rid']?>">Run-Now</a></th>
	<?php } else {?>
		<th><a class="button" href="./can-i-vote.php?rid=<?=$role['rid']?>&check=true">Can-I-Vote?</a></th>
		<th><a class="button" href="./vote-now.php?rid=<?=$role['rid']?>">Vote-Now</a></th>
<?php } ?>
	  </tr>

<?php
		}
	$roleCount = 1;
?>
	</tbody>
</table><br>
<div class="description">
	<p><span class="title">Description : </span><br><br>
<?php foreach($rolesDescriptions as $roleDescription) {?>
	<?=$roleCount++?>. <?=$roleDescription?> <br><br>

<?php
	}
?>
</p>
</div>
<?php
		} else {
			echo "<p>Manager has not created any roles yet!</p>";
		}
?>
<br><hr><br>

	<h2 id="parties">Parties</h2><br>
<?php
	$getParties = "
			select p.logo, p.name as partyName, p.status, p.authentic, p.description as partyDescription from parties as p where p.eid = '$eid' and p.authentic <> 'rejected';
			";
		$parties = mysqli_query($conn, $getParties);

		/* echo "<pre>"; */
		/* print_r($parties); */
		if ($parties->num_rows > 0) {
?>
		<table>
			<thead>
			  <tr>
				 <th>Count</th>
				 <th>Logo</th>
				 <th>Name</th>
				 <th>Status</th>
				 <th>Authentic</th>
			  </tr>
			</thead>
			<tbody>
<?php
		while ($party = $parties->fetch_assoc()) {
		/* print_r($party); */
			$partiesDescriptions[] = $party['partyDescription'];
			/* echo '/easyVote/uploads/parties/'.$party['logo']?>; */
?>
	  <tr>
	  <td><?=$partyCount++?></td>
	  <td><img src="/easyVote/uploads/<?php echo (empty($party['logo'])) ? 'profile_picture/no-image-party.jpg' : 'party/'.$party['logo'];?>"></td>
	  <td><?=$party['partyName']?></td>
	  <td><?=$party['status']?></td>
	  <td><?=$party['authentic']?></td>
	  </tr>

<?php
		}
	$partyCount = 1;
?>
	</tbody>
</table><br><br>
<div class="description">
	<p><span class="title">Description : </span><br><br>
<?php foreach($partiesDescriptions as $partyDescription) {?>
	<?=$partyCount++?>. <?=$partyDescription?><br><br>
<?php
	}

?>
	</p></div>
<?php
		} else {
			echo "<p>Manager has not created any parties yet!</p>";
		}
?>
<br>
    <div class="sidebar-page">
      <ul>
			<h4>Navigation</h4>
        <li><a href="#election">Details</a></li>
        <li><a href="#roles">Roles</a></li>
        <li><a href="#parties">Parties</a></li>
		  <li><a href="../../backend/contact/email.php?s=<?=urlencode($electionDetail['vID'])?>&r=<?=urlencode($electionDetail['mID'])?>&role=<?=$_SESSION['role']?>&et=<?=urlencode($electionDetail['title'])?>&eid=<?=urlencode($electionDetail['electionID'])?>">Contact Manager</a></li>
		  <li><a href="./vote-count.php?eid=<?=urlencode($electionDetail['electionID'])?>">Votes</a></li>
      </ul>
    </div>
  </div>
<?php

		} else {
			echo "Election doesn't exist!";
			die();
			exit();
		}
	} else {
		echo "<h2><i>No election selected!</i></h2>";
	}
?>
</div>
</div>
