<?php

session_start();
include "../../../connect.php";
include "../../regular_functions.php";
include "../../../sidebar/sidebar.php";
displayMessage();

// check if election is chosen
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
			if ($answer['manager'] == 'yes') {
					
				// manage other assitant manager

			// adding new assitant
				
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$mid = $_POST['mid'];
				$addManager = "
INSERT INTO election_manager(vid, eid) VALUES 
((select case when exists (SELECT vid FROM voters WHERE voterID = '$mid') 
then (SELECT vid FROM voters WHERE voterID = '$mid') else 'a' end) ,
 (SELECT eid FROM election WHERE electionID = '$eid'));

";
/* echo $addManager; */
/* die; */
				try {
					if (mysqli_query($conn, $addManager)) {
						$_SESSION['msg-success'] = "Added <big>'$mid'</big> as MANAGER successfully!";
					}
				} catch(Exception $e) {
					$_SESSION['msg-error'] = 'Sorry, Voter ID <big>\''.$mid.'\'</big> is INVALID!!';
				}
				header("Location: ".$_SERVER['REQUEST_URI']);
			}
	?>

<style>
	table {
	 font-size: 25px;
	min-width: 800px;
}
	button {
font-size: 23px;
}
	.locations a,label,input{
		 font-size: 22px;
}
	.locations {
		max-width: 800px;
		margin: auto;
}
	table td {
		padding: 20px;
}
	.assistants {
	max-width: 900px;
	margin: auto;
}
.assistants table {
	max-width: 900px;
	margin: auto;
}
</style>
<div class="main">
	<h2 style="text-align: center;">ASSISTANT - MANAGERS</h2>
	<style>

	.delete {
		color: white;
		background: maroon;
		text-decoration: none;
		padding: 10px;
		font-weight: bold;
		font-family: Arial, Helvetica, sans-serif;
		border-radius: 8px;
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
	<hr>
	<br> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Add New Manager:<br>
	<br>
<div class="assistants">
	<form action="" method="post" onsubmit="if (!confirm('Are you sure you want to ADD an ADMIN?')) {event.preventDefault();}">
	<input type="text" name="mid" placeholder="Enter the Voter ID">
	<button hidden>ADD</button>
	</form>
	<hr>
		<u>Managers :</u> <br><br>
		
</div>
		<table border=2 cellspacing=0 cellpadding=10>
			<thead>
				<th>Image</th>
				<th>Name</th>
				<th>Email</th>
				<th>Voter ID</th>
				<th>Contact</th>
				<th>Action</th>
			</thead>

			<tbody>
	<?php
			$getManagers = "SELECT emid, name, email, photo, voterID FROM `election_manager` join voters on voters.vid = election_manager.vid where eid = (SELECT eid from election where electionID = '$eid') ";
			$managers = mysqli_query($conn, $getManagers);
			if ($managers->num_rows > 0 ) {
			while ($manager = $managers->fetch_assoc()) {
				/* echo "<pre>"; */
				/* print_r($admin); */
				/* echo "</pre>"; */
	?>
			<tr>
				<td><img src="../../../uploads/profile_picture/<?=$manager['photo']?>" height="100px"></td>
				<td><?php echo $manager['name'] ?></td>
				<td><?php echo $manager['email'] ?></td>
				<td><?php echo $manager['voterID'] ?></td>
				<td><a href="../../backend/contact/email.php?s=<?=$answer['mid']?>&r=<?=$manager['voterID']?>&role=manager">Send an Email</a>
				<td><a href="./delete-manager.php?vid=<?=$manager['voterID']?>&eid=<?=urlencode($eid)?>" onclick="if (prompt('Enter the Voter-ID of the manager for confirmation : ') != '<?=$manager['voterID']?>') {event.preventDefault();}" class="delete">REMOVE</a>
	</td>		</tr>
	<?php
				} 	
			} else {
				echo "<td colspan=\"6\" style=\"font-style: italic; text-align: center;\">No Assistant Managers are added to this Election Yet!</td>";
			}

	?>
			</tbody>
		</table>
	<?php

			} else if ($answer['assistant'] == 'yes') {
				$_SESSION['msg'] = "Only the original manager who created the election can manage assitant managers!";
				header("Location: ".$_SERVER['REQUEST_URI']);
				exit();
			} else {
				$_SESSION['msg'] = "You can not manage this election, please contact manager for being added as assitant!";
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
