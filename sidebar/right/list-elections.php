<?php

	session_start();
	// check if the current user has created any elections
	include "../../connect.php";

	echo '
		<br>
		<br>
		<div>
			  <label for="search">Search Elections:</label>
			  <input type="text" id="search" name="search" onkeyup="searchElections()"> </div> <br><hr>
<div id="election-card">
';
	
	$sql = '
			SELECT *,
				 (
					SELECT 
						 CASE
							  WHEN (CURDATE() < start_date AND start_date < end_date) THEN "not-started"
							  WHEN ((CURDATE() = start_date AND CURTIME() < start_time) AND (start_time <= end_time)) THEN "not-started"
							  WHEN ((CURDATE() BETWEEN start_date AND end_date) AND (start_date < end_date)) then "started"
							  WHEN ((CURDATE() > end_date AND start_date < end_date) and (start_date <= end_date)) THEN "ended"
							  WHEN ((CURDATE() = end_date AND CURTIME() < end_time) and (start_date <= end_date)) THEN "started"
							  WHEN ((start_date = end_date AND start_time < end_time) AND (CURTIME() > end_date)) THEN "ended"
							  WHEN ((CURDATE() = end_date AND CURTIME() > end_time) AND (start_date <= end_date)) THEN "ended"
							  ELSE "invalid date/time range"
						 END
				 ) 	AS	 status
			 FROM 		 election 
			join			 locations 
			on 			 locations.lid = election.lid 
			WHERE			 vid = ' . $_SESSION['vid'];
	/* echo $sql; */
	$rows = mysqli_query($conn, $sql);
	/* print_r($rows); */
	if ($row = $rows->num_rows > 0) {
		echo "<u>Elections You Have managed : </u>";
		while($row = $rows->fetch_assoc()) {

			echo "<pre>";
			/* print_r($row); */
			echo "</pre>";
?>
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
		<div style="margin-top: 20px;">
			<button onclick="window.location.href='manage-election.php?eid=<?=urlencode($row['electionID'])?>&et=<?=$row['title']?>'" style="margin-right: 10px; margin-top: 5px;">Manage</button>
			<button onclick="if (confirm('Are you sure you want to DELETE this election?')) {window.location.href='delete-election.php?eid=<?=$row['electionID']?>&title=<?=$row['title']?>'} else {event.preventDefault();}">Delete</button>
		</div>
	</div>
<?php
		}
	} else {
		echo "You haven't yet created any election!";
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
