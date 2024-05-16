<!DOCTYPE html>
<?php
	session_start();
	include "../../connect.php";
	$sql = '
			SELECT electionID, start_date, end_date, start_time, end_time,
				 CASE
					  WHEN (CURDATE() < start_date AND start_date < end_date) THEN "not-started"
					  WHEN ((CURDATE() = start_date AND CURTIME() < start_time) AND (start_time <= end_time)) THEN "not-started"
					  WHEN ((CURDATE() BETWEEN start_date AND end_date) AND (start_date < end_date)) then "started"
					  WHEN ((CURDATE() > end_date AND start_date < end_date) and (start_date <= end_date)) THEN "ended"
					  WHEN ((CURDATE() = end_date AND CURTIME() < end_time) and (start_date <= end_date)) THEN "started"
					  WHEN ((start_date = end_date AND start_time < end_time) AND (CURTIME() < end_date)) THEN "not-started"
					  WHEN ((start_date = end_date AND start_time < end_time) AND (CURTIME() > end_date)) THEN "ended"
					  WHEN ((CURDATE() = end_date AND CURTIME() > end_time) AND (start_date <= end_date)) THEN "ended"
					  ELSE "invalid date/time range"
				 END AS status
			FROM election WHERE electionID = 
	\'' . $_GET['eid'] . '\'';
	$rows = mysqli_query($conn, $sql);
	if ($row = $rows->num_rows > 0) {
		while($row = $rows->fetch_assoc()) {
		/* echo "<pre>"; */
		/* print_r($row); */
	 	$GLOBALS["status"] = $row['status'];
		if ($row['status'] == 'started') {
			$date = $row['end_date'];
			$time = $row['end_time'];
			$timer_status = 'Election Will END in';
			$color =	'#4cbb17';
		} else if ($row['status'] == 'not-started') {
			$date = $row['start_date'];
			$time = $row['start_time'];
			$timer_status = 'Election Will START in';
			$color = '#A9A9A9';
		} else {
			$timer_status = 'Election Ended';
			$color =	'#960019';
		}
		/* echo $date; */
		/* echo $time; */
		}
	}
?>
<style>
div.timer {
  text-align: center;
  font-size: 20px;
  margin-top: 0px;
  background-color: #4cbb17;
  border-radius: 10px;
  color: white;
  padding: 10px;
  width: max-content;
  position: absolute;
  top: 20px;
  right: 10px;
}
.timer p {
	font-size: 30px;
    margin: 2px;
	color: white;
    font-weight: bold;
}
</style>

<div class="timer" style="background-color: <?php echo $color ?>;">
<?=$timer_status?>
<?php if ($status != 'ended') { ?>
<p id="demo">

</p>
<?php } ?>
</div>

<script>
// Set the date we're counting down to
//var countDownDate = new Date("Jan 5, 2030 15:37:25").getTime();

/* var countDownDate = new Date("2024-04-27T23:07:26").getTime(); */
<?php if ($status != 'ended') { ?>
	console.log("<?=$status?>");
	var countDownDate = new Date("<?=$date?>T<?=$time?>").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = "<big>" + days + "</big> Days - " +"<big>" +  hours + "</big>H: "
  +"<big>" +  minutes + "</big>M: " +"<big>" +  seconds + "</big>S ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
<?php } ?>
</script>
