<?php
include "../../../connect.php";

$location_name = isset($_GET['name']) ? $_GET['name'] : '';
$getLocations = "SELECT * FROM locations WHERE location_name LIKE '%$location_name%';";
$rows = mysqli_query($conn, $getLocations);

$records = "";

if ($rows && $rows->num_rows > 0) {
    while ($row = $rows->fetch_assoc()) {
?>
<?php $records .= '

        <tr>
				<td>'.$row['lid'].'</td>
            <td>'.$row['location_name'].'</td>
            <td><a href="location_update.php?title='.$row['location_name'] .'&lid='.$row['lid'].'"><img src="/easyVote/uploads/icons/edit.png"></a>&ensp;&ensp;<a href="location_delete.php?title='.$row['location_name'].'&lid='.$row['lid'].'"><img src="/easyVote/uploads/icons/delete.png"></a></td>
        </tr>';
    }
	 echo $records;
} else {
    // If no results found, return an empty row
    echo "<tr><td colspan='3'>No locations found</td></tr>";
}
?>
