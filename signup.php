<?php

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>Signup</h1>

	<form action="" method="post">
		<label for="name">Name</label><br>
		<input type="text" name="name" id="name" placeholder="Name"><br><br>
		<label for="email">Email</label><br>
		<input type="text" name="email" id="email" placeholder="Email"><br><br>
		<label for="password">Password</label><br>
		<input type="password" name="password_1" id="password" placeholder="Password"><br><br>
		<label for="password">Password</label><br>
		<input type="password" name="password_2" id="password" placeholder="Confirm Password"><br><br>
		<!-- files -->
		<span>Citizenship Photo(Front)</span>	<input type="file" name="front_image"><br><br>
		<span>Citizenship Photo(Back)</span>	<input type="file" name="back_image"><br><br>
		<span>Profile Picture</span>	<input type="file" name="photo"><br><br>
		<button>Signup</button>
	</form>
	
</body>
</html>

