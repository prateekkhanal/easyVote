<?php
include "../../includes/regular_functions.php";
include "view-election.php";
	if (role() != 'candidate' & role() != 'manager') $_SESSION['msg'] = ' You must switch-role as <i>CANDIDATE</i> to request to run in an election!';
	displayMessage();
	$electionID = $_GET['eid'];
	/* $sql = "SELECT pid, parties.name as partyName, parties.partyID, parties.description as partyDescription, parties.logo, election.title as electionTitle, election.electionID FROM parties join election on election.eid = parties.eid WHERE election.electionID ='$electionID';"; */
	$sql = "
	SELECT (SELECT count(*) from candidate where eid='D!DCasxCE' and pid=parties.partyID) AS candidates,parties.name as partyName, parties.partyID, parties.description as partyDescription, parties.logo, election.title as electionTitle, parties.status as partyStatus, parties.authentic as authentic, election.electionID FROM parties join election on election.electionID = parties.eid WHERE election.electionID ='$electionID';
	";
/* echo $sql; */
	session_start();
	// check if the current user has created any elections
	include "../../connect.php";

	echo '
		<div>
		<a href="create-party.php?eid='.urlencode($_GET['eid']).'&et='.urlencode($_GET['et']).'">Create new Party</a> <br> <br>
			  <label for="search">Search Parties:</label>
			  <input type="text" id="search" name="search" onkeyup="searchElections()"> </div> <br>
<div id="election-card">
';
	
	$rows = mysqli_query($conn, $sql);
	/* print_r($rows); */
	if ($row = $rows->num_rows > 0) {
		echo "<u>Parties You Have managed : </u><br><hr><br>";
		while($row = $rows->fetch_assoc()) {

			echo "<pre>";
			/* print_r($row); */
			echo "</pre>";
?>
	<div style="float: left; background-color: #4285F4; text-align:center; width: max-content; margin: 20px; position: relative; padding: 10px; border-radius: 7px;">
			<p style="font-style: italic; text-align: center; margin: auto; margin-top: 20px; border: 2px; border-radius: 7px; width: 600px; text-transform: capitalize;"><?=$row['partyStatus']?> for Candidates</p>
			<h2 style="text-align: center; margin-bottom: 9px;"><?=$row['partyName']?></h2>
			<div style="text-align: center; font-style:italic;color: lightblue; display: inline-block;" title="Election ID">(<?=$row['partyID']?>)</div>
			
			<p style="text-align: center; margin: auto; margin-top: 10px; border: 2px; border-radius: 7px; width: 600px;"><?=$row['description']?></p>
			<p>
			<img src="<?php echo (empty($row['logo'])) ? '../../uploads/profile_picture/no-image-party.jpg' : '../../uploads/party/'.$row['logo'];?>" height="250px" width="auto" style="border-radius:47%;">
			</p>
			<p><?=$row['partyDescription']?></p>
			<p><?=$row['candidatesRunning']?></p>
			<?php $status = $row['authentic'];?>
			<img src="../../uploads/<?=$status?>.png" alt="<?=$status?>" style="height:35px; display: inline; position: absolute; border-radius:50%; top: 20px; right: 20px; margin-bottom: 10px;">
			<div style="margin-bottom: 20px;">
			<a href="#" style="color: white; display: block; "><big>Candidates : <?=$row['candidates']?></big></a><br>
			<button onclick="window.location.href='update-party.php?pid=<?=urlencode($row['partyID'])?>&eid=<?=urlencode($_GET['eid'])?>&et=<?=urlencode($_GET['et'])?>'" style="margin-right: 10px; margin-top: 5px;">Update</button>
			<button onclick="if (confirm('Are you sure you want to DELETE this election?')) {window.location.href='delete-party.php?pid=<?=urlencode($row['partyID'])?>&eid=<?=urlencode($_GET['eid'])?>&pn=<?=urlencode($row['partyName'])?>&et=<?=urlencode($_GET['et'])?>'} else {event.preventDefault();}">Delete</button>
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
        function searchElections() {
            var searchValue = document.getElementById("search").value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("election-card").innerHTML = this.responseText;
                }
            };
				xhr.open("GET", "../../includes/ajax/manager/get-election.php?name=" + searchValue + "&vid=" + <?=$_SESSION['vid']?>, true);
            xhr.send();
        }

        // Call searchElections function whenever the search input changes
        document.getElementById("search").addEventListener("input", searchElections);
    </script>
