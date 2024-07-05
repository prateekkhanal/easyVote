<?php
	session_start();

	include "../../../connect.php";
	include "../../../sidebar/left/candidate.php";
	include "../../../sidebar/sidebar.php";
?>

<style>
	#faqs {
		border: 1px solid #444;
		border-radius: 5px;
		max-width: 1050px;
		min-height: 666px;
		margin: auto;
		padding: 10px;
}
details {
	margin: 20px;
	text-align: left;
}
center { 
 font-size: 0.9em;
}
select, input {
 font-size: 0.8em;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    color: #333;
    margin: 0;
    padding: 0;
}

.faqs {
    margin: auto;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
	max-width: 1100px;
	margin-bottom: 100px;
	margin-top: 50px;
}

center {
	position: sticky;
	top: 50px;
}
h2 {
    color: #444;
}

hr {
    border: 0;
    height: 1px;
    background: #ddd;
    margin: 20px 0;
}

label {
    display: inline-block;
    margin-bottom: 10px;
}

input[type="text"], select {
    width: 200px;
    padding: 8px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="text"]:focus, select:focus {
    border-color: #777;
    outline: none;
}
input[type="text"] {
    width: 300px;
}
details {
    margin: 10px 0;
    padding: 10px;
    border: 1px solid #ddd;
    background-color: #d3d3d32e;
    border-radius: 4px;
}

summary {
    background-color: #d3d3d366;
    padding: 10px;
    cursor: pointer;
    font-weight: bold;
    border-radius: 4px;
    outline: none;
}

summary:hover {
    background-color: #ddd;
}

details[open] summary {
    background-color: #d3d3d366;
}

details p {
    margin: 10px 0;
    padding: 0;
}

details hr {
    margin: 10px 0;
}

#faqs big b i {
    color: #d9534f; /* Highlighted text color */
}

#faqs span {
    display: inline;
}

.center {
    text-align: center;
}

</style>
<br>
<div class="main">
<div class="faqs">
<center>
<h2>Frequently Asked Questions </h2>
<hr><br>
<label for="keyword">
			Search : 
 </label><input type="text" id="keyword" onkeyup="getFaqs(this.value, document.getElementById('role').value)" placeholder="Enter Keyword">  &ensp;&ensp; &ensp; &ensp;&ensp; &ensp; &ensp;&ensp; &ensp; &ensp;&ensp; &ensp; &ensp;&ensp; &ensp;&ensp; &ensp; &ensp;&ensp; 
<label for="role">
			Role : 
</label>
	<select id="role" onchange="getFaqs(document.getElementById('keyword').value, this.value)">
	<option value="%" <?= (!isset($_SESSION['role']) ? 'selected' : '' ) ?>>Any</option>
		<option value="voter" <?= (($_SESSION['role'] == 'voter') ? 'selected' : '' ) ?>>Voter</option>
		<option value="candidate" <?= (($_SESSION['role'] == 'candidate') ? 'selected' : '' ) ?>>Candidate</option>
		<option value="manager" <?= (($_SESSION['role'] == 'manager') ? 'selected' : '' ) ?>>Manager</option>
		<option value="admin" <?= (($_SESSION['role'] == 'admin') ? 'selected' : '' ) ?>>Admin</option>
	</select>
<br><br>
<br>
<div id="faqs">
<?php
	// check if user is logged in

	if (isset($_SESSION['vid'])) {
		$role = $_SESSION['role'];
	}
	
	$getRows = "SELECT * FROM faq where `role` like 'anyone' or role like '". ((isset($role)) ? $role : '%') ."' and (question like '%' or answer like '%' or category like '%') limit 10";
	/* echo $getRows; */ 
	$rows = mysqli_query($conn, $getRows);
	if ($row = $rows->num_rows > 0) {
		while($row = $rows->fetch_assoc()) {
			/* print_r($row); */
?>

<details style="color: #333;">
<summary ><?php echo $row['question']?>&nbsp; &nbsp; &nbsp; &nbsp; [<?=$row['category']?>]</summary>
<p style="margin-left:50px;"><?php echo $row['answer']; echo "<hr>";?></p>
</details>
<?php
		}
	}
?>
</div>
</center>

<script>
	function getFaqs(keyword, role) {
		console.log(keyword, role);
		 var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("faqs").innerHTML = this.responseText;
		  surroundText('faqs', keyword);
		  /* console.log(this.responseText); */
      }
    };
    xmlhttp.open("GET", "../../ajax/voter/faqs.php?r="+role+"&k="+keyword, true);
    xmlhttp.send();
	}

function surroundText(pId, str) {
    // Get the p element by ID
    var pElement = document.getElementById(pId);
    if (!pElement) {
        console.log('Element not found');
        return;
    }

    // Function to surround the text within text nodes
    function surroundInTextNode(node, searchString) {
        const regex = new RegExp(`(${searchString})(?![^<>]*>)`, 'gi');
        const text = node.textContent;
        const replacedText = text.replace(regex, (match) => `<big><b><i>${match}</i></b></big>`);

        if (text !== replacedText) {
            const newSpan = document.createElement('span');
            newSpan.innerHTML = replacedText;
            node.parentNode.replaceChild(newSpan, node);
        }
    }

    // Traverse the p element and its children to find text nodes
    function traverseNodes(node, searchString) {
        if (node.nodeType === Node.TEXT_NODE) {
            surroundInTextNode(node, searchString);
        } else {
            node.childNodes.forEach(child => traverseNodes(child, searchString));
        }
    }

    // Start the traversal from the p element
    traverseNodes(pElement, str);
}

</script>

</div>
</div>
