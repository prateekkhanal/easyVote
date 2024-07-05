<?php

	session_start();
	// check if the current user has created any elections
	include "../../../connect.php";

	echo '
<style>
	table {
	 font-size: 25px;
	min-width: 800px;
}
	button {
font-size: 23px;
}
	.elections a,label,input{
		 font-size: 22px;
}
	.elections , .elections table{
		max-width: 800px;
		margin: auto;
		font-size: 20px;
	color: white;
}
.elections pre {
	color: black;
}
	table td {
		padding: 20px;
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
h3 {
	font-style: italic;
}
</style>
<div class="main">
<center>
<h2 style="color: #1B4D3E; margin-bottom: 0px;">MANAGER - Elections Panel</h2>'
.(!isset($_GET['role']) ? '<h3 style="color: #1B4D3E; margin-bottom: 0px;">(BOTH)</h3>' : "") .
(($_GET['role']=='personal') ? '<h3 style="color: #1B4D3E; margin-bottom: 0px;">(Personal)</h3>' : "") .
(($_GET['role']=='assistant') ? '<h3 style="color: #1B4D3E; margin-bottom: 0px;">(Assisted)</h3>' : "") .
'</center>
<div class="elections">
<hr>
<br>
	<a href="create-election.php" class="add">Create New Election</a><br><br>
<br>
		<div>
			  <label for="search" style="color: black;">Search Elections:</label>
			  <input type="text" id="search" name="search" onkeyup="searchElections()" placeholder="Election Title"> </div> <br><hr>
		<u>Elections You Have managed : </u>
<div id="election-card">
';
	
	/* $sql = " */
	/* 		SELECT DISTINCT election.*, locations.*, */
	/* 			 ( */
	/* 				SELECT */ 
	/* 					 CASE */
	/* 				  WHEN (CURDATE() < start_date AND start_date < end_date) THEN 'not-started' */
	/* 				  WHEN ((CURDATE() = start_date AND CURTIME() < start_time) AND (start_time <= end_time)) THEN 'not-started' */
	/* 				  WHEN ((CURDATE() BETWEEN start_date AND end_date) AND (start_date < end_date)) then 'started' */
	/* 				  WHEN ((CURDATE() > end_date AND start_date < end_date) and (start_date <= end_date)) THEN 'ended' */
	/* 				  WHEN ((CURDATE() = end_date AND CURTIME() < end_time) and (start_date <= end_date)) THEN 'started' */
	/* 				  WHEN ((start_date = end_date AND start_time < end_time) AND (CURTIME() > end_date)) THEN 'ended' */
                      /* WHEN ((start_date = end_date AND start_time < end_time) AND (CURTIME() < end_date)) THEN 'not-started' */
	/* 				  WHEN ((CURDATE() = end_date AND CURTIME() > end_time) AND (start_date <= end_date)) THEN 'ended' */
	/* 						  ELSE 'invalid date/time range' */
	/* 					 END */
	/* 			 ) 	AS	 status */
	/* 		 FROM 		 election */ 
	/* 		join			 locations */ 
	/* 		on 			 locations.lid = election.lid */ 
	/* 		join 			election_manager as em */ 
	/* 		on				 em.eid = election.eid */ 
	/* 		WHERE (election.vid = " . $_SESSION['vid']. " or em.vid = ".$_SESSION['vid'].')'; */

	$sql = "
			SELECT DISTINCT election.*, locations.*,
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
			WHERE (".(($_GET['role'] != 'assistant') ? "election.vid = " . $_SESSION['vid'] : '').((!isset($_GET['role'])) ? " or " : "").(($_GET['role'] != 'personal') ? " em.vid = ".$_SESSION['vid']: '').')' ;
/* echo $sql; die; */
	$rows = mysqli_query($conn, $sql);
	/* print_r($rows); */
	if ($row = $rows->num_rows > 0) {
		while($row = $rows->fetch_assoc()) {

			/* print_r($row); */
?>
	<div style="float: left; background-color: #214F9A; text-align:center; width: max-content; margin: 20px; padding: 40px; border-radius: 7px;">
			<h2 style="text-align: center; font-style: italic; color: white; font-size: bigger; text-transform: uppercase; margin-bottom: 9px;"><?=$row['status']?></h2>
			<h2 style="text-align: center; margin-bottom: 9px; font-size: x-large;"><?=$row['title']?></h2>
			<big><div style="text-align: center; font-family:Arial, Helvetica, sans-serif;  font-weight: bold; color: lightgreen;" title="Election ID"><?=$row['electionID']?>
			<div style="text-align: center; font-style:italic;color: lightblue; display: inline-block;" title="Election ID">(<?=$row['level']?>/<?=$row['view']?>)</div>
			</div></big>
			
			<p style="text-align: center; margin: auto; margin-top: 10px; border: 2px; border-radius: 7px; width: 600px;"><?=$row['description']?></p>
			<p>
			</p>
			<table border=2 cellspacing=0 cellpadding=10 style="min-width: 800px; max-width: 800px; border-collapse: collapse;">
				<thead>
					<th>Location</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Start Time</th>
					<th>End Time</th>
				</thead>

				<tbody>
				<tr>
					<td><?php echo $row['location_name'] ?></td>
					<td><?php echo $row['start_date'] ?></td>
					<td><?php echo $row['end_date'] ?></td>
					<td><?php echo $row['start_time'] ?></td>
					<td><?php echo $row['end_time'] ?></td>
				</tr>
				</tbody>
			</table>
		<div style="margin-top: 20px;">
			<button onclick="window.location.href='manage-election.php?eid=<?=urlencode($row['electionID'])?>&et=<?=$row['title']?>'" style="margin-right: 10px; margin-top: 5px; padding: 5px; font-weight: bold;">Manage</button>
			<button onclick="if (confirm('Are you sure you want to DELETE this election?')) {window.location.href='delete-election.php?eid=<?=$row['electionID']?>&title=<?=$row['title']?>'} else {event.preventDefault();}" style="margin-right: 10px; margin-top: 5px; padding: 5px; font-weight: bold;">Delete</button>
		</div>
	</div>
<?php
		}
	} else {
		echo "<h3 style=\"color: black;\">You haven't ".(($_GET['role'] == 'assistant') ? "assisted in " : "created ")." any election yet!</h3>";
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
						  console.log(this.responseText);
                }
            };
				xhr.open("GET", "../../ajax/manager/get-election.php?name=" + searchValue + "&vid=" + <?=$_SESSION['vid']?>, true);
            xhr.send();
        }

        // Call searchElections function whenever the search input changes
        document.getElementById("search").addEventListener("input", searchElections);
    </script>
</div>
