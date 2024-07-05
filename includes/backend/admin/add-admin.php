<?php
	session_start();
	include "../../regular_functions.php";
	include "../../../connect.php";
	include "../../../sidebar/sidebar.php";
	displayMessage();
	if (!isset($_SESSION['vid'])) {
			$_SESSION['msg'] = "You need to login first!";
			redirectHere($_SERVER['PHP_SELF']);
			header("Location: ../../../signin.php");
	} else if (role() != 'admin') {
			$_SESSION['msg'] = "You need to switch-role to ADMIN!";
			redirectHere($_SERVER['PHP_SELF']);
			header("Location: ../../../sidebar/right/switch-role.php");
	}

	$getVoterID = "SELECT voterID from voters where vid=".$_SESSION['vid'];
	$adminVoterID = mysqli_query($conn, $getVoterID);
	$adminVID = $adminVoterID->fetch_assoc()['voterID'];

		$vid = $_SESSION['vid'];
	$checkIfAdmin = 'select (CASE
       when ' .$_SESSION['vid'] .' in (select vid from admins) then "yes"
       else "no"
       end ) as is_admin';
	$result = mysqli_query($conn, $checkIfAdmin);
	$answer = $result->fetch_assoc();
	if ($answer['is_admin'] == "yes") {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$vid = $_POST['vid'];
			$addAdmin = "INSERT INTO admins(vid) VALUES (
						(SELECT vid FROM voters WHERE voterID = '$vid'));";
/* echo $addAdmin; */
/* die; */
			try {
				mysqli_query($conn, $addAdmin); 
					$_SESSION['msg-success'] = "Added <big>'$vid'</big> as ADMIN successfully!";
			} catch(Exception $e) {
				$_SESSION['msg-error'] = 'Sorry, Voter ID <big>\''.$vid.'\'</big> is INVALID!!';
			}
			header("Location: ".$_SERVER['REQUEST_URI']);
		}

?>
<style>
.admins {
		font-size: 25px;
	}
	table {
	 font-size: 25px;
	min-width: 800px;
}
	.admins a,label,input{
		 font-size: 22px;
}
	.admins input {
		padding: 10px;
		width: 500px;
}
	.admins input::placeholder {
		font-size: 25px;
		font-style: italic;
}
	.admins {
		max-width: 800px;
		margin: auto;
}
	table td {
		padding: 20px;
}
.admins {
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
.instruction {
	color: #1B4D3E;
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

<div class="main">
<div class="admins">
<h2 style="text-align: center; color: red;">ADMINISTRATOR - Admins</h2>
<hr>
<br> <span class="instruction">Add New Admin:</span><br>
<br>
<form action="" method="post" onsubmit="if (!confirm('Are you sure you want to ADD an ADMIN?')) {event.preventDefault();}">
<input type="text" name="vid" placeholder="Enter the Voter ID">
<button hidden>ADD</button>
</form>
<hr>
<br>
	<u>Admins :</u> <br><br>
	
	<table border=2 cellspacing=0 cellpadding=10>
		<thead>
			<th>Image</th>
			<th>Name</th>
			<th>Email</th>
			<th>Voter ID</th>
			<th>Contact</th>
		</thead>

		<tbody>
<?php
		$getAdmins = "SELECT aid, name, email, photo, voterID FROM `admins` join voters on voters.vid = admins.vid; ";
		$admins = mysqli_query($conn, $getAdmins);
		while ($admin = $admins->fetch_assoc()) {
			echo "<pre>";
			/* print_r($admin); */
			echo "</pre>";
?>
		<tr>
			<td><img src="../../../uploads/profile_picture/<?=$admin['photo']?>" height="100px"></td>
			<td><?php echo $admin['name'] ?></td>
			<td><?php echo $admin['email'] ?></td>
			<td><?php echo $admin['voterID'] ?></td>
			<td><a href="../../backend/contact/email.php?s=<?=$adminVID?>&r=<?=$admin['voterID']?>&role=admin">Send an Email</a>
</td>		</tr>
<?php
	}
?>
		</tbody>
	</table>
<?php
	} else {
		echo "You are not admin!";
	}

?></div>
</div>
