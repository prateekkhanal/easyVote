
<?php

session_start();
include "../../../sidebar/left/candidate.php";
include "../../../sidebar/sidebar.php";
include "./pinning-elections.html";
include "../../../connect.php";
$vid = $_SESSION['vid'];
$getPinnedElections = "SELECT *, e.title, 
 			(	SELECT			
									CASE
								  WHEN (CURDATE() < start_date AND start_date < end_date) THEN 'not-started'
								  WHEN ((CURDATE() = start_date AND CURTIME() < start_time) AND (start_time <= end_time)) THEN 'not-started'
								  WHEN ((CURDATE() BETWEEN start_date AND end_date) AND (start_date < end_date)) then 'started'
								  WHEN ((CURDATE() > end_date AND start_date < end_date) and (start_date <= end_date)) THEN 'ended'
								  WHEN ((CURDATE() = end_date AND CURTIME() < end_time) and (start_date <= end_date)) THEN 'started'
								  WHEN ((start_date = end_date AND start_time < end_time) AND (CURTIME() > end_date)) THEN 'ended'
										 WHEN ((start_date = end_date AND start_time < end_time) AND (CURTIME() < end_date)) THEN 'not-started'
								  WHEN ((CURDATE() = end_date AND CURTIME() > end_time) AND (start_date <= end_date)) THEN 'ended'
								  ELSE 'N/A'
							 END AS status from election WHERE election.electionID = e.electionID
			) as status
 
	FROM pinned_elections JOIN election as e on e.electionID = pinned_elections.eid WHERE pinned_elections.vid = $vid";
/* echo $getPinnedElections; */
echo "</pre>";
$count = 1;

$pinnedElectionsResult = mysqli_query($conn, $getPinnedElections);

?>

<div class="main">
<div class="favs">

<style>
	* {
		font-family: "Lato", sans-serif;
	 }
	table {
		font-size: 0.9em;
		margin: auto;
		min-width: 1200px;
	}
	thead th {
		text-transform: uppercase;
	}
	td:nth-child(3) {
		text-transform: uppercase;
	}
	td:nth-child(2) {
		max-width: 600px;
	}
	td:nth-child(1), td:nth-child(4) {
		text-align: center;
	}
	table th, td {
	padding: 15px;
	}
	
	h1 {
		text-align: center;
		font-size: 2em;
}
.favs {
	padding-top: 50px;
	max-width: 1200px;
	margin: auto;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    text-align: left;
    background-color: #fff;
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 12px 15px;
    border: 1px solid #ddd;
}

th {
    background-color: #f4f4f4;
    color: #333;
    text-transform: uppercase;
    font-weight: 600;
	 text-align: center;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
}

</style>

	<h1>Pinned Elections</h1>
<hr><br>

	<table border=2 cellspacing=0 cellpadding=10>
		<thead>
			<th>Count</th>
			<th>Election</th>
			<th>Status</th>
			<th>Unpin</th>
		</thead>

		<tbody>
	<?php
		if ($pinnedElectionsResult->num_rows > 0) {
			while ($row = $pinnedElectionsResult->fetch_assoc()) {
	?>
		<tr>
			<td><?php echo $count++; ?></td>
			<td><a href="/easyVote/includes/frontend/voter/election.php?eid=<?=urlencode($row['electionID'])?>"><?php echo $row['title'] . " (<i>" .$row['electionID'] . "</i>) "; $pinned= true; $eid = $row['electionID'];?></p></td>
			<td><?php echo $row['status'] ?></td>
			<td><?php include "./pinning-elections.php"?></td>
		</tr>
		<?php
			}
			} else {
		?>
			<tr>
				<td colspan="4"><i>You haven't pinned any elections yet!</i></td>
			</tr>
	<?php
			}
		?>
		</tbody>
	</table>

</div>
</div>
