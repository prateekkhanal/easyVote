<style>
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}

hr {
	color: lightgray;
	margin: 35px 0px;
}

.cards {
	border: 2px solid gray;
	border-radius: 8px;
	min-width: 500px;
	max-width: 80%;
	margin: 15px auto;
	padding: 5px 15px;
}
.card {
  margin: 20px auto;
  padding: 0px 30px 30px 30px;
  background-color: #317873;
	color: #f8f8f8;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
	font-size: 20px;
}

h2 {
  margin-top: 0;
	text-align: center;
	padding: 15px 0px;
	border-bottom: 8px solid black;
	background-color: lightgray;
	color: black;
}
h2 a{
	text-decoration: none;
	color: #000000;
	margin-right: 25px;
}

a {
   color: lightblue;
}
.notes, .candidate-details, .additional-info {
  margin-bottom: 15px;
}

.notes strong, .candidate-details strong, .additional-info strong {
  font-weight: bold;
}

.candidate-details strong {
	margin-bottom: 15px;
}

table {
  width: max-content;
  border-collapse: collapse;
	color: white;
	font-size: 18px;
}

table th, table td {
	margin-top: 10px;
  border: 1px solid #ddd;
  padding: 8px 38px;
}

.description {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    max-height: 3em; /* Adjust this value based on the desired height */
    overflow: hidden;
    text-overflow: ellipsis;
}

button {
  padding: 10px 20px;
  border: none;
  background-color: #6690aC;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
	font-size: 22px;
}

button:hover {
  background-color: #0071c5;
}

.status {
	background-color: gray;
	text-decoration: none;
	padding: 15px;
	border-radius: 8px;
	color: white;
	float: right;
	font-style: italic;
}
.status.started {
	background-color: #39FF14;
	color: #01411C;
}
.status.ended {
	background-color: #9e1b32;
	color: #ffffff;
}
strong+big i {
	text-transform: capitalize;
}
</style>
</head>
<body>
<?php

	// get elections
	$electionsQuery = '
					SELECT 
						title, electionID, level, locations.location_name, 
							(select make_request from roles where eid = election.electionID limit 1)
									 as authentication , 
						count(roles.eid) as roles, 
						election.description, 
						CASE WHEN (CURDATE() < start_date AND start_date < end_date) 
						THEN "not-started" WHEN ((CURDATE() = start_date AND CURTIME() < start_time) 
						AND (start_time <= end_time)) 
						THEN "not-started" 
						WHEN ((CURDATE() BETWEEN start_date AND end_date) 
						AND (start_date < end_date)) then "started" WHEN 
						((CURDATE() > end_date AND start_date < end_date) 
						and (start_date <= end_date)) THEN "ended" 
						WHEN ((CURDATE() = end_date AND CURTIME() < end_time) 
						and (start_date <= end_date)) THEN "started" 
						WHEN ((start_date = end_date AND start_time < end_time) 
						AND (CURTIME() > end_date)) THEN "ended" 
						WHEN ((start_date = end_date AND start_time < end_time) 
						AND (CURTIME() < end_date)) THEN "not-started" 
						WHEN ((CURDATE() = end_date AND CURTIME() > end_time) 
						AND (start_date <= end_date)) 
						THEN "ended" ELSE "N/A" 
						END AS status 
						FROM election 
						JOIN locations ON locations.lid = election.lid 
						LEFT JOIN roles ON roles.eid = election.electionID 
						WHERE election.level <> "rejected" 
						and election.view = \'public\' 
						AND election.lid LIKE \'%\' AND election.title LIKE \'%%\' 
						GROUP by election.electionID ORDER BY election.eid ; ';
	/* echo $electionsQuery; */
	$elections = mysqli_query($conn, $electionsQuery);


?>
  <div class="cards" id="cards">
<?php
if ($elections->num_rows > 0) {
	while($election = $elections->fetch_assoc()) {
		echo "<pre>";
		/* print_r($election); */
		echo "</pre>";
?>

  <div class="card">
  <h2><a href="javascript: void(0)"><?=$election['title']?></a><small>
  (<i><?=$election['electionID']?></i>)</small>
</h2>
    <div class="notes">
	 <strong>Level</strong>: <big><i><?=$election['level']?></i></big>
			<br>
			<strong>Location</strong>: <big><i><?=$election['location_name']?></i></big>
			<br>
    </div>
	 <div class="candidate-details" onclick="getRoles('<?=$election['electionID']?>', this)">
	 <strong>Roles: </strong> <?=$election['roles']?> (<a href="javascript: void(0)"><i>View Details</i></a>)
    </div>
    <div class="additional-info">
	 <p class="description"><?=$election['description']?></p>
    </div>
	 <button id="spectate" onclick="window.location='/easyVote/includes/frontend/voter/election.php?eid=<?=urlencode($election['electionID'])?>'">Spectate</button>
	 <a href="javascript: void(0)" class="status <?=$election['status']?>"><?=$election['status']?></a>
  </div>
<hr>
<?php

	}
}
?>
  </div>
  <script>
function getRoles(eid, roleContainer) {
		let xmlhttp = new XMLHttpRequest();
	 xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        roleContainer.innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "../../ajax/voter/get-roles.php?eid=" + encodeURIComponent(eid), true);
    xmlhttp.send();	
}
</script>
</body>
</html>

