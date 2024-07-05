<?php

include "../../regular_functions.php";
include "../../../connect.php";
include "../../../sidebar/sidebar.php";

displayMessage();
?>
<style>
	table {
	 font-size: 25px;
	min-width: 1000px;
}
	.locations a,label,input{
		 font-size: 22px;
}
	.locations {
		padding-top: 20px;
		max-width: 1200px;
		margin: auto;
}
	table td {
		padding: 20px;
}
td:last-child {
	display: flex;
	justify-content: center;
}
h1 {
	margin-top: 100px;
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
	border-right: 0px;
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
input {
padding : 8px;
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
.add img{
background-color: white;
width: 20px;
	
}
</style>
<div class="main">
		<div class="locations">
		<center>
				<h2 style="color: red;">ADMINISTRATOR - LOCATIONS</h2>
		</center>
		<hr><br>
		<a href="location_add.php" class="add"> <span>Add a location</span></a>
		<br>
		<br>
		<div>
			  <label for="search">Search Location:</label>
			  <input type="text" id="search" name="search" onkeyup="searchLocations()" placeholder="Location Name"> </div> <br>
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
	<td><a href="location_update.php?title=<?php echo $row['location_name']?>&lid=<?php echo $row['lid']; ?>"> <img src="/easyVote/uploads/icons/edit.png"></a>&ensp; &ensp;<a href="location_delete.php?title=<?php echo $row['location_name']?>&lid=<?php echo $row['lid']; ?>"><img src="/easyVote/uploads/icons/delete.png"></a></td>
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

</div>
</div>
