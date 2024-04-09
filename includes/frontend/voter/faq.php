<h1>Frequently Asked Questions</h1>

<?php
	include "../../../connect.php";
	$getRows = "SELECT * FROM faq limit 10;";
	$rows = mysqli_query($conn, $getRows);
	if ($row = $rows->num_rows > 0) {
		while($row = $rows->fetch_assoc()) {
			/* print_r($row); */
?>

<br>
<details>
<summary style="background-color: lightgrey;"><?php echo $row['question']?>&nbsp; &nbsp; &nbsp; &nbsp; [<?=$row['category']?>]</summary>
<p style="margin-left:50px;"><?php echo $row['answer']; echo "<hr>";?></p>
</details>
<?php
		}
	}
?>
