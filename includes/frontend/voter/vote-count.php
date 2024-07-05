<?php

	include "../../../connect.php";
	include "../../../sidebar/left/candidate.php";
	include "../../../sidebar/sidebar.php";
	$eid = $_GET['eid'];
	$getRoles = "SELECT rid, position,place FROM roles WHERE roles.eid = '$eid'";
	$rolesResult = mysqli_query($conn, $getRoles);
?>

<div class="main">
<style>
progress {
-webkit-appearance: none; -moz-appearance: none; appearance: none;height: 40px; width: 800px; border-radius: 10px;
}
progress::-webkit-progress-value {
  background-color:#002D72;
  border-radius: 0px;
}
progress::-moz-progress-bar {
  background-color:#002D72;
  border-radius: 0px;
}
h2, table {
	font-family: Arial, Helvetica, sans-serif;
	text-align: center;
	margin: auto;
	font-size: 30px;
	margin-left: 70px;
}
h2 {
	margin: 30px auto;
	border: 5px solid black;
	padding: 10px;
	width: max-content;
	min-width: 600px;
}
.progress-bar {
  position: relative;
  width: 100%;
  height: 20px;
  background-color: #ccc;
  border-radius: 5px;
}
table {
	font-size: 25px;
	text-align: center;
	border-collapse: collapse;
	margin-bottom: 40px;
	min-width: 1240px;
}
table tbody td img {
	max-height: 100px;
	border-radius: 100%;
	margin: 0px;
}
table tbody td button {
	font-size: 20px;
	border-radius: 10px;
	padding: 10px;
	border: none;
	background-color: #662d91;
	font-weight: bold;
}
th, button {
  background-color: #002D72;
  color: #fff;
}
h2#no-candidates {
	border: 0px solid black;
}
td {
	border: 1px solid #ddd;
}
td progress~span {
	color: #002D72;
}
tfoot th:first-child{
	text-align: left;
	padding-left: 50px;
}
</style>
<?php
	if ($rolesResult->num_rows > 0) {
?>
<br>

<?php
		$printLine = false;
		while ($role = $rolesResult->fetch_assoc()) {
			$candidatesQuery = "

				SELECT candidate.candidateID , voters.name, election.title, voters.photo, (SELECT count(*) from votes WHERE cid = candidate.candidateID) AS votes,
				(SELECT count(*) FROM votes WHERE cid = any (SELECT candidate.candidateID FROM candidate WHERE roles.rid = candidate.rid)) as totalVotes,
				roles.position as position, roles.place as place, election.electionID
				FROM candidate JOIN roles ON roles.rid = candidate.rid
						JOIN voters on voters.voterID = candidate.vid
						  JOIN election on election.electionID = roles.eid
						  WHERE roles.rid = ". $role['rid'] . " ORDER BY votes DESC";
	$candidates = mysqli_query($conn, $candidatesQuery);
		$count = 0;
			if ($printLine) {echo "<hr>";}
			$printLine = true;
?>
	<h2><i><?=$role['position']?></i> -> <i><?=$role['place']?></i></h2>
<table border="1px" cellspacing="0px" cellpadding="10px">
<thead>
<tr>
<th>Rank</th>
<th>Candidate</th>
<th>Progress</th>
<th>Votes</th>
<th>Details</th>
</tr>
</thead>
<tbody><pre>
	<?php
			if ($candidates->num_rows > 0) {
				$totalVotes = 0;
				while ($candidate = $candidates->fetch_assoc()) {
					$totalVotes = $candidate['totalVotes'];
?>
			<tr>
			<td><?=++$count;?></td>
				<td>
				<img src="/easyVote/uploads/profile_picture/<?=$candidate['photo']?>" title="<?=$candidate['name']?>" alt="<?=$candidate['name']?>" class="progress-image">
			</td>
				<td>
				<progress id="file" value="<?=$candidate['votes']?>" max="<?=$candidate['totalVotes']?>">
				</progress><br><span><?= ($candidate['totalVotes'] != 0) ? round($candidate['votes']/$candidate['totalVotes']*100) .'%' : '0%';?></span>
				</td>
				<td><?=$candidate['votes']?></td>
				<td><button onclick="window.location = '../candidate/profile.php?cid=<?=urlencode($candidate['candidateID'])?>'">View Profile</button></td>
			</tr>
<?php

				}
?>

</tbody>
<tfoot>
	<th colspan="4">Total votes : </th>
	<th><?=$totalVotes?></th>
</tfoot>
</table>
<?php
			} else {
?>
	<tr><td colspan="5"><h2 id="no-candidates"><i>No candidates are selected yet!</i></h2></td></tr>
<?php
			}
?>
<?php } ?>

<?php		
	} else {
		echo "<h2><i>There are no Roles yet Defined for this election!</i></h2>";
	}
?>
</div>
