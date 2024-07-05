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
		$rolesSql = "SELECT distinct position from roles where eid = '".$row['electionID']."'";
		/* echo $rolesSql; */
		$roles = mysqli_query($conn, $rolesSql);
		$role = '';
		if ($roles->num_rows == 0) {
			$role .= "⸻";
		} else {
			while($r = $roles->fetch_assoc()) {
				$role.= $r['position'].'<br>';
			}
		}


?>
<?php $elections .= '
				<div style="float: left; background-color: #E70808D9; margin-left: 350px;color: white; text-align:center; width: max-content; margin: 20px; padding: 20px; border-radius: 7px;"><center>
			<h2 style="text-align: center; font-style: italic;  font-size: 25px; text-transform: uppercase; margin-bottom: 9px;">'. $row['status'].'</h2>
			<h2 style="text-align: center; margin-bottom: 9px; font-size: x-large;">'. $row['title'].'</h2>
			<big><div style="text-align: center; font-family:Arial, Helvetica, sans-serif;  font-weight: bold; color: lightgreen;" title="Election ID">'. $row['electionID'].'
			<div style="text-align: center; font-style:italic;color: lightblue; display: inline-block;" title="Election ID">('. $row['level'].'/'. $row['view'].')</div>
			</div></big>
			
			<p style="text-align: center; margin: auto; margin-top: 10px; border: 2px; border-radius: 7px; width: 600px;">'. $row['description'].'</p>
			<p>
			</p>
			<table border=2 cellspacing=0 cellpadding=10 style="min-width: 800px;max-width: 800px; color: white; border-collapse: collapse; margin: auto;">
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
					<td>'. $role .'</td>
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
<center>
		</div>

';
    }
	 echo $elections;
} else {
    // If no results found, return an empty row
    echo "No elections of level $level found!";
}
?>
