<!DOCTYPE html>
<?php
	include "../../../connect.php";
	include "../../regular_functions.php";
	displayMessage();
	echo '
	<h2 style="text-align: center; color: red;">ADMINISTRATOR - Elections Panel</h2>
<hr><br>
	<input type="text" id="name" placeholder="SEARCH" name="name">
<br>
<br> <hr><br>
		<label for="level">Level : </label>
		<select id="level" name="level">
			<option value="%">All</option>
			<option value="custom">Custom</option>
			<option value="national">National</option>
			<option value="international">International</option>
			<option value="pending" selected>Pending</option>
			<option value="rejected">rejected</option>
		</select>
<br>
<br>
<hr><br>
	<div id="elections">
';

	/* get voterID of admin */
	$getVoterID = "SELECT voterID from voters where vid=".$_SESSION['vid'];
	$adminVoterID = mysqli_query($conn, $getVoterID);
	$adminVID = $adminVoterID->fetch_assoc()['voterID'];

	$sql = "
			SELECT title, position, level, view, start_date, end_date, start_time, end_time, electionID, description, authentication, location_name, voterID, name FROM election JOIN locations on locations.lid = election.lid join voters on voters.vid = election.vid WHERE level='pending' ORDER BY eid DESC;
";
	/* echo $sql; */
			echo "<pre>";
	$result = mysqli_query($conn, $sql);
	/* print_r($result); */
			echo "</pre>";
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			/* print_r($row); */

?>
	<div id="elections">
				<div style="float: left; background-color: #4285F4; text-align:center; width: max-content; margin: 20px; padding: 10px; border-radius: 7px;">
			<h2 style="text-align: center; font-style: italic; color: white; font-size: bigger; text-transform: uppercase; margin-bottom: 9px;"><?=$row['status']?></h2>
			<h2 style="text-align: center; margin-bottom: 9px; font-size: x-large;"><?=$row['title']?></h2>
			<big><div style="text-align: center; font-family:Arial, Helvetica, sans-serif;  font-weight: bold; color: lightgreen;" title="Election ID"><?=$row['electionID']?>
			<div style="text-align: center; font-style:italic;color: lightblue; display: inline-block;" title="Election ID">(<?=$row['level']?>/<?=$row['view']?>)</div>
			</div></big>
			
			<p style="text-align: center; margin: auto; margin-top: 10px; border: 2px; border-radius: 7px; width: 600px;"><?=$row['description']?></p>
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
					<td><?php echo $row['location_name'] ?></td>
					<td><?php echo $row['position'] ?></td>
					<td><?php echo $row['start_date'] ?></td>
					<td><?php echo $row['end_date'] ?></td>
					<td><?php echo $row['start_time'] ?></td>
					<td><?php echo $row['end_time'] ?></td>
				</tr>
				</tbody>
			</table>
			<p>Manager : <i><?=$row['name'] . '&ensp;&ensp;['. $row['voterID'].']'?></i></p>

		<label for="level">Level : </label>
		<select id="roles" name="roles" onchange="if (confirm('Do you really want to CHANGE the role? ')) {changeLevel(this)} else {event.preventDefault()}">
			<option value="custom" <?php if ($row['level'] == 'custom') echo 'selected'?>>Custom</option>
			<option value="pending" <?php if ($row['level'] == 'pending') echo 'selected'?>>Pending</option>
			<option value="national" <?php if ($row['level'] == 'national') echo 'selected'?>>National</option>
			<option value="international" <?php if ($row['level'] == 'international') echo 'selected'?>>International</option>
			<option value="rejected" <?php if ($row['level'] == 'rejected') echo 'selected'?>>rejected</option>
		</select>
		<input style="display: none;" value="<?=$row['electionID']?>">
		<div style="margin-top: 20px;">
		<button onclick="window.location.href='../../backend/contact/email.php?s=<?=$adminVID?>&r=<?=$row['voterID']?>&role=manager&et=<?=$row['title']?>&eid=<?=$row['electionID']?>'" style="margin-right: 10px; margin-top: 5px;">Contact Manager</button>
		<button data-value1="<?=$row['electionID']?>" data-value2="<?=$row['title']?>" onclick="if (confirm('Do you really want to delete this election?')) {deleteElection(this)} else {event.preventDefault()}">Delete</button>
		</div>
	</div>
	</div>
<?php
		}
	} else {
		echo "No Elections!";
	}
?>
<script>
	  function searchElections() {
			var searchLevel = document.getElementById("level").value;
			var searchName = document.getElementById("name").value;
			console.log(searchName, searchLevel);
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				 if (this.readyState == 4 && this.status == 200) {
					  document.getElementById("elections").innerHTML = this.responseText;
				 }
			};
			xhr.open("GET", "../../../includes/ajax/admin/view-elections.php?level=" + searchLevel + "&title=" +searchName , true);
			xhr.send();
	  }
	 
	  function changeLevel(select) {
			var level = select.value;
			var eid = select.nextElementSibling.value;
			/* console.log(searchLevel); */
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				 if (this.readyState == 4 && this.status == 200) {
					/* window.location.href="view-elections.php"; */
					 window.location.reload();
					 console.log(this.responseText);
				 }
			};
			console.log("../../ajax/admin/change-level.php?level=" + level + "&eid=" + eid);
			xhr.open("GET", "../../ajax/admin/change-level.php?level=" + level + "&eid=" + encodeURIComponent(eid) , true);
			xhr.send();
	  }

	  function deleteElection(button) {
			var eid = button.dataset.value1;
			var title = button.dataset.value2;
			console.log(eid);
			console.log(title);

			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				 if (this.readyState == 4 && this.status == 200) {
					/* window.location.href="view-elections.php"; */
					 window.location.reload();
					 console.log(this.responseText);
				 }
			};
			console.log("../../ajax/admin/change-level.php?level=" + level + "&eid=" + eid);
			xhr.open("GET", "../../ajax/admin/delete-election.php?eid=" + encodeURIComponent(eid) + "&title=" + encodeURIComponent(title) , true);
			xhr.send();
	  }
	  // Call searchElections function whenever the search input changes
	  document.getElementById("name").addEventListener("input", searchElections);
	  document.getElementById("level").addEventListener("change", searchElections);
 </script>

