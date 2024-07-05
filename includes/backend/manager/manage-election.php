<?php
include "../../../includes/regular_functions.php";
include "../../../connect.php";
include "../../../sidebar/sidebar.php";

// check if the current user is authentic manager of this election

if ($_SESSION['role'] == 'manager') {
	if (isset($_GET['eid'])) {
		$eid = $_GET['eid'];
		// check if the user is logged in
		if (isset($_SESSION['vid'])) {
			// check if the user is the original manager
			$vid = $_SESSION['vid'];
			$checkManager = "select (select voterID from voters where vid=$vid) as mid, case when exists (select * from election where electionID = '$eid') then 'exists' else 'invalid' end as election,CASE 
		when exists (select * from election where vid = $vid and electionID = '$eid') then 'yes' else 'no' end as manager, 
			 CASE
					when exists (SELECT * FROM election_manager where vid = $vid and eid = (select eid from election where electionID = '$eid'))
				then 'yes' else 'no' end as assistant";

			/* echo $checkManager; */
			$result = mysqli_query($conn, $checkManager);
			$answer = $result->fetch_assoc();
			/* print_r($answer); */

			// if the election is valid
			if ($answer['election'] == 'exists') {
			// if the manager is authentic
			if (($answer['manager'] == 'yes') or $answer['assistant'] == 'yes') {
					
				// manage other assistant manager

					displayMessage();
?>
<style>
	table {
	 font-size: 23px;
	min-width: 800px;
}
	button, textarea, select, input {
font-size: 23px;
}
	.election a,label,input{
		 font-size: 22px;
}
	.election {
		max-width: 800px;
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
td:nth-child(3) {
	padding-left: 30px;
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
	
.update {
	width: max-content;
	border: 1px solid #000000;
	border-radius: 8px;
	padding: 12px 15px;
	text-decoration: none;
	color: white;
	background-color: #2c3968;
	font-weight: bold;
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
<?php
					include "./election-timer.php";
					include "view-election.php";
					$eid = $_GET['eid'];
					$et = $_GET['et'];

					?>
<div class="main">
<div class="election">
					<div>

					<br>
						<a href="update-election.php?eid=<?=urlencode($_GET['eid'])?>&et=<?=urlencode($_GET['et'])?>" class="update">Edit Election Details</a>
					<br>
					<br>
					<hr>
<?php if ($answer['manager'] == 'yes') { ?>
					<br>
						<a href="/easyVote/includes/backend/manager/manage-assistants.php?eid=<?=urlencode($_GET['eid'])?>&et=<?=urlencode($_GET['et'])?>" class="update">Manage Assistant Managers</a>
					<br>
					<br>
					<hr>
<?php } ?>

					</div>
					<br>
					<a href="create-role.php?eid=<?=urlencode($_GET['eid'])?>&et=<?=urlencode($_GET['et'])?>" class="add">Create New Role</a><br><br>
					View Roles:-
					<br>
					<br>

						<table border=2 cellspacing=0 cellpadding=5 id="roles">
							<thead>
								<th>Position</th>
								<th>Place</th>
								<th>Actions</th>
							</thead>

							<tbody>
					<?php
						$sql = 'SELECT * FROM roles WHERE eid=\''.$_GET['eid'].'\'';
						$result = mysqli_query($conn, $sql);
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
					?>
							<tr>
								<td><?php echo $row['position'] ?></td>
								<td><?php echo $row['place'] ?></td>
								<td><a href="update-role.php?eid=<?=urlencode($eid)?>&et=<?=urlencode($et)?>&rid=<?=$row['rid']?>"><img src="/easyVote/uploads/icons/edit.png"></a> <a href="delete-role.php?eid=<?=urlencode($row['eid'])?>&et=<?=urlencode($_GET['et'])?>&rid=<?=$row['rid']?>&position=<?=$row['position']?>" onclick="if (!confirm('Are you sure you want to DELETE this role?')) {event.preventDefault();}"><img src="/easyVote/uploads/icons/delete.png"></a></td>
							</tr>
					<?php
							}
						} else {
							echo "<tr><td colspan=\"3\" style=\"font-style: italic;\">No roles Created for this election yet!</td></tr>";
						}
					?>
							</tbody>
						</table>
					<hr>
					<br>
						<a href="list-parties.php?eid=<?=urlencode($_GET['eid'])?>&et=<?=urlencode($_GET['et'])?>" class="update">Manage Parties</a>
					<br>
					<hr>
					<br>
						<a href="./candidates.php?eid=<?=urlencode($_GET['eid'])?>&et=<?=urlencode($_GET['et'])?>" class="update">Manage Candidates</a>
					<br>
					<br>
					<hr>

<?php

			} else {
				$_SESSION['msg'] = "You can not manage this election, please contact manager for being added as assistant!";
			}
			} else {
				$_SESSION['msg-error'] = "Election <big><b>$eid</b></big> doesn't exist!";
			}

			//	else
		} else {
			redirectHere($_SERVER['REQUEST_URI']);
			echo "<script>
				if (confirm('You haven\'t logged in! Do you want to login first!')) {
					window.location.href = '../../../signin.php';
	}
				</script>";
			
		}
	} else {
		echo "<h1>No election chosen!</h1>";
	}
} else {
			echo "<script>
				if (confirm('You need to switch role to manager first!')) {
					window.location.href = '../../../sidebar/right/switch-role.php';
	}
				</script>";
}

?>
</div>
</div>
