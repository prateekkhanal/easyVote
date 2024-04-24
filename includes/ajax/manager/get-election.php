<?php
include "../../../connect.php";

$election_name = isset($_GET['name']) ? $_GET['name'] : '';
$vid = isset($_GET['vid']) ? $_GET['vid'] : '';
$getelection = "SELECT * FROM election WHERE vid = $vid and title LIKE '%$election_name%' OR electionID LIKE '%$election_name%';";
$rows = mysqli_query($conn, $getelection);

$records = "";

if ($rows && $rows->num_rows > 0) {
    while ($row = $rows->fetch_assoc()) {
?>
<?php $records .= '
<div style="float: left; background-color: #4285F4; text-align:center; width: max-content; margin: 20px; padding: 10px; border-radius: 7px;" id="election-card">
		<h2 style="text-align: center; margin-bottom: 9px;">'.$row['title'].'</h2>
		<big><div style="text-align: center; font-family:Arial, Helvetica, sans-serif;  font-weight: bold; color: lightgreen;" title="Election ID">'.$row['electionID']
		.'<div style="text-align: center; font-style:italic;color: lightblue; display: inline-block;" title="Election ID">('.$row['level'].')</div>
		</div></big>
		
		<p style="text-align: center; margin: auto; margin-top: 10px; border: 2px; border-radius: 7px; width: 600px;">'.$row['description'].'</p>
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
				<th>Actions</th>
			</thead>

			<tbody>
			<tr>
				<td>'. $row['location_name'] . '</td>
				<td>'. $row['position'] . '</td>
				<td>'. $row['start_date'] . '</td>
				<td>'. $row['end_date'] . '</td>
				<td>'. $row['start_time'] . '</td>
				<td>'. $row['end_time'] . '</td>
				<td>[<a href="manage-election.php?eid='.$row['electionID'].'">Manage</a>]<br>[<a href="delete-election.php?eid='.$row['electionID'].'&title='.$row['title'].'" onclick="if (!confirm(\'Are you sure you want to DELETE this election?\')) {event.preventDefault();}">Delete</a>]</td>
			</tr>
			</tbody>
		</table>
</div>
';
    }
	 echo $records;
} else {
    // If no results found, return an empty row
    echo "<tr><td colspan='3'>No Elections found</td></tr>";
}
?>
