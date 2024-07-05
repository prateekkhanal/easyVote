<?php
	
	session_start();
	include "../../../connect.php";

	$role = (isset($_GET['r']) ? $_GET['r'] : '%');
	$keyword = (isset($_GET['k']) ? $_GET['k'] : '%');

	$getFaqs = "SELECT * FROM faq where role like '$role' and (LOWER(question) like LOWER('%$keyword%') or LOWER(answer) like LOWER('%$keyword%') or LOWER(category) like LOWER('%$keyword%')) limit 10";
	/* echo $getFaqs; */

	$faqs = mysqli_query($conn, $getFaqs);

	$response = '';
	if ($faq = $faqs->num_rows > 0) {
		while($faq = $faqs->fetch_assoc()) {
			/* echo "<pre>"; */
			/* print_r($faq); */
			/* echo "</pre>"; */
			$response .= "

			<details style=\"color: #333;\">
			<summary>".$faq['question']."&nbsp; &nbsp; &nbsp; &nbsp; [".$faq['category']."]</summary>
			<p style=\"margin-left:50px;\">".$faq['answer']."<hr></p>
			</details>
";

		}
	} else {
		echo "<p>Sorry, FAQs related to the keyword <big><b><i>$keyword</i></b></big> doesn't exist!</p>";
	}

	echo $response;

?>
