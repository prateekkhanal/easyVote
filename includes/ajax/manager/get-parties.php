<?php
include "../../../connect.php";
session_start();

$electionID = isset($_GET['eid']) ? $_GET['eid'] : '';
$party = isset($_GET['p']) ? $_GET['p'] : '';
$getParties = "

	SELECT (SELECT count(*) from candidate where eid='$electionID'
	 and pid=parties.partyID and verified='accepted') AS candidates,
	parties.name as partyName, parties.partyID, 
	parties.description as partyDescription, 
	parties.logo, election.title as electionTitle, 
	parties.status as partyStatus, 
	parties.authentic as authentic, 
	election.electionID 
	FROM parties 
	join election 
	on 		election.electionID = parties.eid 
	WHERE		 election.electionID ='$electionID' and parties.name like '%$party%';
";
/* echo $getParties; */

/* echo $getelection; */
$rows = mysqli_query($conn, $getParties);

$records = "<br>";

		
if ($rows && $rows->num_rows > 0) {
    while ($row = $rows->fetch_assoc()) {
			$status = $row['authentic'];
			$logo = (empty($row['logo'])) ? '../../../uploads/profile_picture/no-image-party.jpg' : '../../uploads/party/'.$row['logo'];
?>
<?php $records .= '
	<div style="float: left; background-color: #4285F4; max-width: 610px; min-width: 610px; text-align:center; width: max-content; margin: 20px; position: relative; padding: 15px; border-radius: 7px;">
			<p style="font-style: italic; text-align: center; margin: auto; margin-top: 20px; border: 2px; border-radius: 7px; width: 600px; text-transform: capitalize;">'.$row['partyStatus'].'for Candidates</p>
			<h2 style="text-align: center; margin-bottom: 9px;">'.$row['partyName'].'</h2>
			<div style="text-align: center; font-style:italic;color: lightblue; display: inline-block;" title="Election ID">('.$row['partyID'].')</div>
			
			<p style="text-align: center; margin: auto; margin-top: 10px; border: 2px; border-radius: 7px; width: 600px;">'.$row['description'].'</p>
			<p>
			<img src="'.$logo.'" height="250px" width="auto" style="border-radius:47%;">
			</p>
			<p>'.$row['partyDescription'].'</p>
			<p>'.$row['candidatesRunning'].'</p>
			<img src="../../../uploads/'.$status.'.png" alt="'.$status.'" style="height:35px; display: inline; position: absolute; border-radius:50%; top: 20px; right: 20px; margin-bottom: 10px;">
			<div style="margin-bottom: 20px;">
			<a href="../../../includes/backend/manager/candidates.php?eid='.urlencode($electionID).'&et='.urlencode($_GET['et']).'&pid='.urlencode($row['partyID']).'" style="color: white; display: block; "><big>Candidates : '.$row['candidates'].'</big></a><br>
			<button onclick="window.location.href=\'update-party.php?pid='.urlencode($row['partyID']).'&eid='.urlencode($_GET['eid']).'&et='.urlencode($_GET['et']).'\'" style="margin-right: 10px; margin-top: 5px; padding: 8px; font-weight: bold;">Update</button>
			<button onclick="if (confirm(\'Are you sure you want to DELETE this party?\')) {window.location.href=\'delete-party.php?pid='.urlencode($row['partyID']).'&eid='.urlencode($_GET['eid']).'&pn='.urlencode($row['partyName']).'&et='.urlencode($_GET['et']).'\'} else {event.preventDefault();}" style="margin-right: 10px; margin-top: 5px; padding: 8px; font-weight: bold;">Delete</button>
			</div>
	</div>
';
    }
	 echo $records;
} else {
    // If no results found, return an empty row
    echo "<br><br>No matching parties with the name '<b><big>$party</big></b>'!";
}
?>

