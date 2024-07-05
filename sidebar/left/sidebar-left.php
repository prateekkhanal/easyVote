<?php
session_start();
if ($_SESSION['role'] != 'candidate') {
?>
<script>
// Select all elements with the class 'sidebar-left'
const sidebars = document.querySelectorAll('.sidenav-left');

// Loop through each sidebar element and remove it
sidebars.forEach(sidebar => {
    sidebar.remove();
});
</script>
<?php } ?>
<?php
	if (!isset($_SESSION)) {session_start();}
	if (($_SESSION['role'] == 'voter') || (!isset($_SESSION['role']))) {
		include "voter.php";
	} else if (($_SESSION['role'] == 'candidate')) {
		include "candidate.php";
	} else if ($_SESSION['role'] == 'manager') {
		include "manager.php";
	} else if ($_SESSION['role'] == 'admin') {
		include "admin.php";
	}
?>
