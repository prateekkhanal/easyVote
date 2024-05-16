<?php
	include "../../../connect.php";
	$locQuery = 'SELECT lid, location_name FROM locations';
	$locationResult = mysqli_query($conn, $locQuery);
?>


<title>Search Field</title>
<style>
  .search-wrapper {
    display: flex;
    align-items: center;
    min-width: 500px;
    max-width: 850px;
    padding: 10px;
    font-size: 20px;
    background-color: #B0C4DE; /* Adjusted background color */
    border-radius: 30px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Added shadow for depth */
	margin: 50px auto;
  }

  .search-input {
    flex: 1;
    padding: 10px 30px;
    border: none;
    font-size: 25px;
    outline: none;
    background: none;
    color: #495057; /* Adjusted text color */
  }
	
	.select-left, .select-right option {
		font-size: 20px;
		padding: 20px;
		min-width: 100px;
}

  .select-left,
  .select-right {
    padding: 20px;
		min-width: 100px;
    font-size: 20px;
    border: none;
    border-radius: 10px;
    background-color: #ffffff; /* Adjusted select background color */
    color: #495057; /* Adjusted select text color */
  }

  .select-left {
    border-radius: 30px 0px 0px 30px;
  }

  .select-right {
    border-radius: 0px 30px 30px 0px;
  }
.status {
	text-transform: uppercase;
	font-weight: bold;
}

</style>
<body>

<div class="search-wrapper">
  <select class="select-left" id="select-left" name="view" onchange="getElections(this.value, this.nextSibling.nextSibling.value, this.nextSibling.nextSibling.nextSibling.nextSibling.value)">
    <option value="public">Public</option>
    <option value="private">Private</option>
  </select>
  <input type="text" id="search-input" class="search-input" placeholder="Enter Election Title (eg. Ktm Mayor 2081)" oninput="getElections(this.previousSibling.previousSibling.value, this.value, this.nextSibling.nextSibling.value)">
  <select id="select-right" class="select-right" name="lid" onchange="getElections(this.previousSibling.previousSibling.previousSibling.previousSibling.value, this.previousSibling.previousSibling.value, this.value)">
    <option value="%">Anywhere</option>
<?php
	while ($loc = $locationResult->fetch_assoc()) {
?>
	<option value="<?=$loc['lid']?>"><?=$loc['location_name']?></option>
<?php
	}
?>
  </select>
</div>
<?php include "./elections.php"; ?>
<script>
  // Selecting the elements
  const selectLeft = document.querySelector('.select-left');
  const selectRight = document.querySelector('.select-right');
  const searchInput = document.querySelector('.search-input');

  // Adding event listener to the select element
  selectLeft.addEventListener('change', function() {
    // Checking the selected option value
    if (selectLeft.value === 'private') {
      // If private is selected, change the placeholder
      searchInput.placeholder = 'Enter Election code (eg. 6627a5d924f09)';
		selectRight.value = '%';
    } else {
      // If public is selected, change the placeholder back
      searchInput.placeholder = 'Enter Election Title (eg. Ktm Mayor 2081)';
    }
  });

  function getElections(view, query, loc) {
	  console.log("View : ", view);
	  console.log("Query : ", query);
	  console.log("Location : ", loc);
	  var xmlHttp = new XMLHttpRequest();
	  xmlHttp.onreadystatechange = function() {
		  if (this.readyState = 4) {
		  document.getElementById("cards").innerHTML = this.responseText;
		  }
	  }
	  xmlHttp.open("GET", "../../ajax/voter/get-search-elections.php?lid="+encodeURIComponent(loc)+"&view="+view+"&q="+encodeURIComponent(query), true)
	  xmlHttp.send();
  }
</script>
</body>
