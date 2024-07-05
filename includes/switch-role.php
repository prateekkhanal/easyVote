<?php
	session_start();
   include "../sidebar/left/candidate.php";
   include "regular_functions.php";
   include "../sidebar/sidebar.php";
	displayMessage();
	
	// if user isn't signned in, redirect to the login page
	if (!isset($_SESSION['role'])) {
		$_SESSION['msg'] = 'You need to login first!';
		redirectHere($_SERVER['PHP_SELF']);
		header("Location: ../signin.php");
	}
	$isAdmin = checkIfAdmin($_SESSION['vid']);

	// get the user role 
	if (isset($_GET['role'])) {
		// check the role requested
		$role = $_GET['role'];
		if ($role == 'admin') {
			// check if the current user has admin privileges
			if ($isAdmin) {
				// switch the role to admin
				if ($role == $_SESSION['role']) {
					$_SESSION['msg'] = 'You are ALREADY ADMIN!';
				} else {
					$_SESSION['msg-success'] = 'You now have ADMIN privileges!';
					$_SESSION['role'] = 'admin';
				}
			} else {

			} 
		} 


		if ($role == 'manager') {
				if ($role == $_SESSION['role']) {
					$_SESSION['msg'] = 'You are ALREADY MANAGER!';
				} else {
					$_SESSION['msg-success'] = 'You now have MANAGER privileges!';
					$_SESSION['role'] = 'manager';
				}
			} 

		if ($role == 'candidate') {
				if ($role == $_SESSION['role']) {
					$_SESSION['msg'] = 'You are ALREADY CANDIDATE!';
				} else {
					$_SESSION['msg-success'] = 'You now have CANDIDATE privileges!';
					$_SESSION['role'] = 'candidate';
				}
		} 
		if ($role == 'voter') {
				if ($role == $_SESSION['role']) {
					$_SESSION['msg'] = 'You are ALREADY VOTER!';
				} else {
					$_SESSION['msg-success'] = 'You now have VOTER privileges!';
					$_SESSION['role'] = 'voter';
				}
		}
		/* header("Location: " . $_SERVER['PHP_SELF']); */
		/* exit(); */
		echo "<script>window.history.back();</script>";
		}
	/* function checkIfAdmin($vid) { */
	/* 	include "../../connect.php"; */
	/* 	$getAdmin = "SELECT * FROM admins WHERE vid = $vid;"; */
		
	/* 	$rows = mysqli_query($conn, $getAdmin); */
	/* 	if ($rows->num_rows > 0) { */
	/* 		return true; */
	/* 	} */
	/* 	return false; */
		/* } */

?>

<style>
	.main ul li a {
		padding: 30px;
		border: 1px solid lightgray;
		text-decoration: none;
		display: inline-block;
		width: 150px;
		font-weight: bold;
		color: black;
		text-align: center;
		border-radius: 7px;
		font-size: 25px;
		align-items: center;
	}
	.main ul li {
		display: inline-block;
	}
	.main ul {
		display: flex;
		justify-content: space-around;
}
	#admin {
		background-color: #f414145e;
	}
	#manager {
		background-color: #76eb76a3;
	}
	#candidate {
		background-color: #cd4fcd4f;
	}
	#voter {
		background-color: #0000ff30;
	}
	.roles {
		width: 1100px;
		margin: auto;
		padding-top: 20px;
}
	.roles a span {
		display: inline-block;
		height: 50px;
}
</style>
<div class="main">

<div class="roles">

	<center>
	<h2>Choose Role:</h2>
	</center>
<hr>
<br>

	<ul>
		<li><a href="?role=voter" id="voter"><img src="../uploads/icons/voter.png"><br><span>Voter</span></a></li>
		<li><a href="?role=candidate" id="candidate"><img src="../uploads/icons/candidate.png"><br><span>Candidate</span></a></li>
		<li><a href="?role=manager" id="manager"><img src="../uploads/icons/manager.png"><br><span>Manager</span></a></li>
		<?php if ($isAdmin) : ?>
			<li><a href="?role=admin" id="admin"><img src="../uploads/icons/admin.png"><br><span>Admin</span></a></li>
		<?php endif; ?>
	</ul>

</div>
</div>
