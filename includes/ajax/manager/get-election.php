<?php
include "../../../connect.php";
session_start();

$election_name = isset($_GET['name']) ? $_GET['name'] : '';
$vid = isset($_GET['vid']) ? $_GET['vid'] : '';
$getelection = "
			SELECT distinct election.*, locations.*,
				 (
					SELECT 
						 CASE
					  WHEN (CURDATE() < start_date AND start_date < end_date) THEN 'not-started'
					  WHEN ((CURDATE() = start_date AND CURTIME() < start_time) AND (start_time <= end_time)) THEN 'not-started'
					  WHEN ((CURDATE() BETWEEN start_date AND end_date) AND (start_date < end_date)) then 'started'
					  WHEN ((CURDATE() > end_date AND start_date < end_date) and (start_date <= end_date)) THEN 'ended'
					  WHEN ((CURDATE() = end_date AND CURTIME() < end_time) and (start_date <= end_date)) THEN 'started'
					  WHEN ((start_date = end_date AND start_time < end_time) AND (CURTIME() > end_date)) THEN 'ended'
                      WHEN ((start_date = end_date AND start_time < end_time) AND (CURTIME() < end_date)) THEN 'not-started'
					  WHEN ((CURDATE() = end_date AND CURTIME() > end_time) AND (start_date <= end_date)) THEN 'ended'
							  ELSE 'invalid date/time range'
						 END
				 ) 	AS	 status
			 FROM 		 election 
			join			 locations 
			on 			 locations.lid = election.lid 
			left join 			election_manager as em 
			on				 em.eid = election.eid 
			WHERE (election.vid = " . $_SESSION['vid']. " or em.vid = ".$_SESSION['vid']
			.') and (election.title LIKE \'%'.$election_name.'%\' OR electionID LIKE \'%'.$election_name.'%\'
)'			;

/* echo $getelection; */
$rows = mysqli_query($conn, $getelection);

$records = "<br>";

		
/* if ($rows && $rows->num_rows > 0) { */
if ( $rows->num_rows > 0) {
    while ($row = $rows->fetch_assoc()) {
?>
<?php $records .= '
<div style="float: left; background-color: #214F9A; text-align:center; width: max-content; margin: 20px; padding: 40px; border-radius: 7px;">
		<h2 style="text-align: center; font-style: italic; color: white; font-size: bigger; text-transform: uppercase; margin-bottom: 9px;">'.$row['status'].'</h2>
		<h2 style="text-align: center; margin-bottom: 9px; font-size: x-large;">'.$row['title'].'</h2>
		<big><div style="text-align: center; font-family:Arial, Helvetica, sans-serif;  font-weight: bold; color: lightgreen;" title="Election ID"> '.$row['electionID']
		.' <div style="text-align: center; font-style:italic;color: lightblue; display: inline-block;" title="Election ID">('.$row['level'].'/'.$row['view'].')</div>
		</div></big>
		
		<p style="text-align: center; margin: auto; margin-top: 10px; border: 2px; border-radius: 7px; width: 600px;">'.$row['description'].'</p>
		<p>
		</p>
		<table border=2 cellspacing=0 cellpadding=10 style="border-collapse: collapse;">
			<thead>
				<th>Location</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Start Time</th>
				<th>End Time</th>
			</thead>

			<tbody>
			<tr>
				<td>'. $row['location_name'] . '</td>
				<td>'. $row['start_date'] . '</td>
				<td>'. $row['end_date'] . '</td>
				<td>'. $row['start_time'] . '</td>
				<td>'. $row['end_time'] . '</td>
			</tr>
			</tbody>
		</table>
		<div style="margin-top: 20px;">
			<button onclick="window.location.href=\'manage-election.php?eid='.urlencode($row['electionID']).'&et='.urlencode($row['title']).'" style="margin-right: 10px; margin-top: 5px;">Manage</button>
			<button onclick="if (confirm(\'Are you sure you want to DELETE this election?\')) {window.location.href=\'delete-election.php?eid='.urlencode($row['electionID']).'&title='.urlencode($row['title']).'} else {event.preventDefault();}">Delete</button>
		</div>
	</div>
</div>
';
    }
	 echo $records;
} else {
    // If no results found, return an empty row
    echo "<br><br>No Elections found!";
}
?>
