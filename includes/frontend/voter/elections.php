<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Election Announcement</title>
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
	max-width: 70%;
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
  background-color: #0056b3;
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
  <div class="cards" id="cards">
  <div class="card">
	 <h2><a href="javascript: void(0)"> Divya Gyan College Candidate</a><small>
(<i>662bb68b30eb6</i>)</small>
</h2>
    <div class="notes">
        <strong>Level</strong>: <big><i>Custom/National/International</i></big>
			<br>
        <strong>Location</strong>: <big><i>Kathmandu</i></big>
			<br>
    </div>
    <div class="candidate-details" onclick="getRoles('D!DCasxCE', this)">
      <strong>Roles: </strong> 3 (<a href="javascript: void(0)"><i>View Details</i></a>)
    </div>
    <div class="additional-info">
      <p class="description">
This is an election organized to choose a Mayor for Kathmandu municipality! 
This is an election organized to choose a Mayor for Kathmandu municipality! 
This is an election organized to choose a Mayor for Kathmandu municipality! 
This is an election organized to choose a Mayor for Kathmandu municipality! 
Elections from now on will be held on this e-voting platform (easyVote)!</p>
    </div>
    <button id="spectate">Spectate</button>
	<a href="javascript: void(0)" class="status started">Started</a>
  </div>
<hr>
  <div class="card">
	 <h2><a href="javascript: void(0)"> Divya Gyan College Candidate</a><small>
(<i>662bb68b30eb6</i>)</small>
</h2>
    <div class="notes">
        <strong>Level</strong>: <big><i>Custom/National/International</i></big>
			<br>
        <strong>Location</strong>: <big><i>Kathmandu</i></big>
			<br>
      <strong>Authentication</strong>: <big><i>Verified Account</i></big> 
    </div>
    <div class="candidate-details" onclick="getRoles('D!DCasxCE', this)">
      <strong>Roles: </strong> 3 (<a href="javascript: void(0)"><i>View Details</i></a>)
    </div>
    <div class="additional-info">
      <p class="description">
This is an election organized to choose a Mayor for Kathmandu municipality! 
This is an election organized to choose a Mayor for Kathmandu municipality! 
This is an election organized to choose a Mayor for Kathmandu municipality! 
This is an election organized to choose a Mayor for Kathmandu municipality! 
Elections from now on will be held on this e-voting platform (easyVote)!</p>
    </div>
    <button id="spectate">Spectate</button>
	<a href="javascript: void(0)" class="status ended">Ended</a>
  </div>
<hr>
  <div class="card">
	 <h2><a href="javascript: void(0)"> Divya Gyan College Candidate</a><small>
(<i>662bb68b30eb6</i>)</small>
</h2>
    <div class="notes">
        <strong>Level</strong>: <big><i>Custom/National/International</i></big>
			<br>
        <strong>Location</strong>: <big><i>Kathmandu</i></big>
			<br>
      <strong>Authentication</strong>: <big><i>Verified Account</i></big> 
    </div>
    <div class="candidate-details" onclick="getRoles('D!DCasxCE', this)">
      <strong>Roles: </strong> 3 (<a href="javascript: void(0)"><i>View Details</i></a>)
    </div>
    <div class="additional-info">
      <p class="description">
This is an election organized to choose a Mayor for Kathmandu municipality! 
This is an election organized to choose a Mayor for Kathmandu municipality! 
This is an election organized to choose a Mayor for Kathmandu municipality! 
This is an election organized to choose a Mayor for Kathmandu municipality! 
Elections from now on will be held on this e-voting platform (easyVote)!</p>
    </div>
    <button id="spectate">Spectate</button>
	<a href="javascript: void(0)" class="status not-started">Not started</a>
  </div>
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

