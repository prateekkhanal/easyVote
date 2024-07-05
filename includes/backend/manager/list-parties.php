<?php
include "../../../includes/regular_functions.php";
include "../../../sidebar/sidebar.php";
include "view-election.php";
	if (role() != 'candidate' & role() != 'manager') $_SESSION['msg'] = ' You must switch-role as <i>CANDIDATE</i> to request to run in an election!';
	displayMessage();
	$electionID = $_GET['eid'];
	$electionTitle = $_GET['et'];
	/* $sql = "SELECT pid, parties.name as partyName, parties.partyID, parties.description as partyDescription, parties.logo, election.title as electionTitle, election.electionID FROM parties join election on election.eid = parties.eid WHERE election.electionID ='$electionID';"; */
	$sql = "
	SELECT (SELECT count(*) from candidate where eid='$electionID' and pid=parties.partyID and verified='accepted') AS candidates,parties.name as partyName, parties.partyID, parties.description as partyDescription, parties.logo, election.title as electionTitle, parties.status as partyStatus, parties.authentic as authentic, election.electionID FROM parties join election on election.electionID = parties.eid WHERE election.electionID ='$electionID';
	";
/* echo $sql; */
	session_start();
	// check if the current user has created any elections
	include "../../../connect.php";

	echo '
<style>
	table {
	 font-size: 21px;
	min-width: 800px;
}
	button {
font-size: 23px;
}
	.locations a,label,input{
		 font-size: 22px;
}
	div {
		max-width: 600px;
		margin: auto;
		font-size: 23px;
}
	table td {
		padding: 20px;
}
input {
	padding: 5px;
}
.add {
	width: max-content;
	border: 1px solid #000000;
	border-radius: 8px;
	padding: 12px 15px;
	text-decoration: none;
	color: white;
	background-color: #1B4D3E;
	font-weight: bold;
}
</style>
<div class="main">
		<div>
<br>
		<a href="create-party.php?eid='.urlencode($_GET['eid']).'&et='.urlencode($_GET['et']).'" class="add">Create new Party</a> <br> <br>
<br>
			  <label for="search"><b>Search Parties:</b></label>
			  <input type="text" id="search" name="search" onkeyup="searchParties()" placeholder="Party Name"> </div> <br>
	<u>Parties You Have managed : </u><br><br><hr>
<div id="party-card">
';
	
	/* print_r($rows); */
	$rows = mysqli_query($conn, $sql);
	if ($row = $rows->num_rows > 0) {
		while($row = $rows->fetch_assoc()) {

			echo "<pre>";
			/* print_r($row); */
			echo "</pre>";
?>
	<div style="float: left; background-color: #4285F4; max-width: 810px; min-width: 810px; text-align:center; width: max-content; margin: 20px; position: relative; padding: 15px; border-radius: 7px;">
			<p style="font-style: italic; text-align: center; margin: auto; margin-top: 20px; border: 2px; border-radius: 7px; width: 600px; text-transform: capitalize;"><?=$row['partyStatus']?> for Candidates</p>
			<h2 style="text-align: center; margin-bottom: 9px;"><?=$row['partyName']?></h2>
			<div style="text-align: center; font-style:italic;color: lightblue; display: inline-block;" title="Election ID">(<?=$row['partyID']?>)</div>
			
			<p style="text-align: center; margin: auto; margin-top: 10px; border: 2px; border-radius: 7px; width: 600px;"><?=$row['description']?></p>
			<p>
			<img src="<?php echo (empty($row['logo'])) ? '../../../uploads/profile_picture/no-image-party.jpg' : '../../uploads/party/'.$row['logo'];?>" height="250px" width="auto" style="border-radius:47%;">
			</p>
			<p><?=$row['partyDescription']?></p>
			<p><?=$row['candidatesRunning']?></p>
			<?php $status = $row['authentic'];?>
			<img src="../../../uploads/<?=$status?>.png" alt="<?=$status?>" style="height:35px; display: inline; position: absolute; border-radius:50%; top: 20px; right: 20px; margin-bottom: 10px;">
			<div style="margin-bottom: 20px;">
			<a href="../../../includes/backend/manager/candidates.php?eid=<?=urlencode($electionID)?>&et=<?=urlencode($row['electionTitle'])?>&pid=<?=urlencode($row['partyID'])?>" style="color: white; display: block; "><big>Candidates : <?=$row['candidates']?></big></a><br>
			<button onclick="window.location.href='update-party.php?pid=<?=urlencode($row['partyID'])?>&eid=<?=urlencode($_GET['eid'])?>&et=<?=urlencode($_GET['et'])?>'" style="margin-right: 10px; margin-top: 5px;" style="margin-right: 10px; margin-top: 5px; padding: 8px; font-weight: bold;">Update</button>
			<button onclick="if (confirm('Are you sure you want to DELETE this party?')) {window.location.href='delete-party.php?pid=<?=urlencode($row['partyID'])?>&eid=<?=urlencode($_GET['eid'])?>&pn=<?=urlencode($row['partyName'])?>&et=<?=urlencode($_GET['et'])?>'} else {event.preventDefault();}" style="margin-right: 10px; margin-top: 5px; padding: 8px; font-weight: bold;">Delete</button>
			</div>
	</div>
<?php
		}
	} else {
		echo "You haven't yet created any PARTIES yet!";
	}
?>
</div>
	<script>
        function searchParties() {
            var searchValue = document.getElementById("search").value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("party-card").innerHTML = this.responseText;
                }
            };
				xhr.open("GET", "../../ajax/manager/get-parties.php?eid=" + '<?=urlencode($electionID)?>'+'&p='+searchValue, true);
            xhr.send();
        }

        // Call searchElections function whenever the search input changes
        document.getElementById("search").addEventListener("input", searchParties());
    </script>
</div>
