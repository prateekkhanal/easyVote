<?php

include "../../regular_functions.php";
include "../../../connect.php";

displayMessage();
?>
<html>
	<head>
		<title>LOCATIONS</title>
	</head>
	<body>
		<h1>LOCATIONS</h1>
		<a href="location_add.php">Add a location</a>
		<br>
		<br>
		<div>
			  <label for="search">Search Location:</label>
			  <input type="text" id="search" name="search" onkeyup="searchLocations()"> </div> <br>
		<table border=2 cellspacing=0 cellpadding=10>
			<thead>
				<th>ID</th>
				<th>Location</th>
				<th>Action</th>
			</thead>

			<tbody id="locationTableBody">
<?php
	include "../../../connect.php";
	$location_name = isset($_GET['name']) ? $_GET['name'] : '';
	$getLocations = "SELECT * FROM locations WHERE location_name like '%$location_name%';";
	$rows = mysqli_query($conn, $getLocations);
	if ($row = $rows->num_rows > 0) {
		while($row = $rows->fetch_assoc()) {
?>
<tr>
	<td><?php echo $row['lid'] ?></td>
	<td><?php echo $row['location_name'] ?></td>
	<td>[<a href="location_update.php?title=<?php echo $row['location_name']?>&lid=<?php echo $row['lid']; ?>">Edit</a>]<br>[<a href="location_delete.php?title=<?php echo $row['location_name']?>&lid=<?php echo $row['lid']; ?>">Delete</a>]</td>
</tr>
<?php
		}
	} 
?>
	<script>
        function searchLocations() {
            var searchValue = document.getElementById("search").value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("locationTableBody").innerHTML = this.responseText;
                }
            };
            xhr.open("GET", "../../ajax/admin/location.php?name=" + searchValue, true);
            xhr.send();
        }

        // Call searchLocations function whenever the search input changes
        document.getElementById("search").addEventListener("input", searchLocations);
    </script>
			</tbody>
		</table>
	</body>
</html>
