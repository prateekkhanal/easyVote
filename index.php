<?php
		session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	 <meta charset="UTF-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <title>Three Containers Layout</title>
	 <link rel="stylesheet" href="./css/index.css">
	<style>
body, html {
    height: 100%;
    margin: 0;
}
a {color: white;}
h1 {color: white;}

.container {
    display: flex;
    height: 100%;
}

.left-sidebar, .right-sidebar {
    width: 17.5%;
    background-color: #5e6163;
}

.main-content {
    width: 65%;
    background-color: #3c3f42;
}

.left-sidebar, .main-content, .right-sidebar {
    height: 100%;
}
</style>
</head>
<body>
	 <div class="container">

		   <div class="left-sidebar">

				<a class="sidebar-item left-sidebar-item" href="#">Dashboard</a><br>
				<a class="sidebar-item left-sidebar-item" href="./includes/backend/lib/contactus.php">Contact Us</a><br>
				<a class="sidebar-item left-sidebar-item" href="#">About Us</a><br>
				<a class="sidebar-item left-sidebar-item" href="./includes/backend/admin/faq.php">FAQ</a><br>
				<a class="sidebar-item left-sidebar-item" href="./includes/backend/admin/profile.php?vid=<?php echo $_SESSION['vid'];?>">Profile</a><br>

			</div>
		  <div class="main-content">
			<?php
			if (isset($_SESSION['name'])) {
				echo "<h1>Hello, " . $_SESSION['name'] . "!</h1>";
			} else {
				echo "<h1>Hello, This is easyVote!</h1>";
			}
		?>


		</div>
			   <div class="right-sidebar">
				<a class="sidebar-item right-sidebar-item" href="#">Create an election</a><br>
				<a class="sidebar-item right-sidebar-item" href="#">Participated Elections</a><br>
				<a class="sidebar-item right-sidebar-item" href="./sidebar/right/switch-role.php">Switch Role</a><br>
					<a href="logout.php" class="sidebar-item right-sidebar-item">Logout</a>
				</div>
		 </div>
</body>
</html>
