<?php
session_start();
include "../../../connect.php";

$election_name = isset($_GET['en']) ? $_GET['en'] : '';
$level = $_GET['level'];
$title = $_GET['title'];
/* echo $level; */
$sql = "SELECT * FROM election JOIN locations on locations.lid = election.lid join voters on voters.vid = election.vid  WHERE level like '$level' and (title like '%$title%' or electionID like '%$title%' ) and " .$_SESSION['vid'] . " in (SELECT vid FROM admins) ORDER BY eid DESC ";
$rows = mysqli_query($conn, $sql);

$getVoterID = "SELECT voterID from voters where vid=".$_SESSION['vid'];
$adminVoterID = mysqli_query($conn, $getVoterID);
$adminVID = $adminVoterID->fetch_assoc()['voterID'];
$elections = "";

if ($rows && $rows->num_rows > 0) {
    while ($row = $rows->fetch_assoc()) {
?>
<?php $elections .= '
				<div style="float: left; background-color: #4285F4; text-align:center; width: max-content; margin: 20px; padding: 10px; border-radius: 7px;">
			<h2 style="text-align: center; font-style: italic; color: white; font-size: bigger; text-transform: uppercase; margin-bottom: 9px;">'. $row['status'].'</h2>
			<h2 style="text-align: center; margin-bottom: 9px; font-size: x-large;">'. $row['title'].'</h2>
			<big><div style="text-align: center; font-family:Arial, Helvetica, sans-serif;  font-weight: bold; color: lightgreen;" title="Election ID">'. $row['electionID'].'
			<div style="text-align: center; font-style:italic;color: lightblue; display: inline-block;" title="Election ID">('. $row['level'].'/'. $row['view'].')</div>
			</div></big>
			
			<p style="text-align: center; margin: auto; margin-top: 10px; border: 2px; border-radius: 7px; width: 600px;">'. $row['description'].'</p>
			<p>
			</p>
			<table border=2 cellspacing=0 cellpadding=10>
				<thead>
					<th>Location</th>
					<th>Position</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Start Time</th>
					<th>End Time</th>
				</thead>

				<tbody>
				<tr>
					<td>' . $row['location_name'] . '</td>
					<td>' . $row['position'] . '</td>
					<td>' . $row['start_date'] . '</td>
					<td>' . $row['end_date'] . '</td>
					<td>' . $row['start_time'] . '</td>
					<td>' . $row['end_time'] . '</td>
				</tr>
				</tbody>
			</table>
			<p>Manager : <i>'.$row['name'] . '&ensp;&ensp;['. $row['voterID'].']'.'</i></p>
		<label for="level">Level : </label> ';

		 $elections .= '
<select id="roles" name="roles" onchange="if (confirm(\'Do you really want to CHANGE the role?\')) {changeLevel(this)} else {event.preventDefault()}"> 
	 <option value="pending"';
		 $elections .= ($row['level'] == 'pending') ? 'selected' : ''; 
		 $elections .='>Pending</option>
			 <option value="custom" ';
		 $elections .= ($row['level'] == 'custom') ? 'selected' : '';
		$elections .= '>Custom</option>
			<option value="national" ';
		 $elections .= ($row['level'] == 'national') ? 'selected' : '';
		$elections .= ' >National</option>
			<option value="international" ';
		 $elections .= ($row['level'] == 'international') ? 'selected' : ''; 
		$elections .= ' >International</option>
			<option value="rejected" ';
		 $elections .= ($row['level'] == 'rejected') ? 'selected' : ''; 
		 $elections .= ' >Rejected</option> 
			 </select> 
		<input style="display: none;" value="'.$row['electionID'].'">
			<div style="margin-top: 20px;">
				<button onclick="window.location.href=\'../../backend/contact/email.php?s='.$adminVID.'&r='.$row['voterID'].'&role=manager&et='.$row['title'].'&eid='.$row['electionID'].'\'" style="margin-right: 10px; margin-top: 5px;">Contact Manager</button>
				<button data-value1="'.$row['electionID'].'" data-value2="'.$row['title'].'" onclick="if (confirm(\'Do you really want to delete this election?\')) {deleteElection(this)} else {event.preventDefault()}">Delete</button>
			</div>
		</div>

';
    }
	 echo $elections;
} else {
    // If no results found, return an empty row
    echo "No elections of level $level found!";
}
?>
