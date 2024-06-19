<?php 

// the below file needs to be included ONCE before including this file

/* include 'pinning-elections.html'; */
/* include '../../regular_functions.php'; */
session_start();
/* displayMessage(); */

/* print_r($_SESSION); */
// this variable must be declared before using this file (every new $eid for every icon)
/* $eid = 'D!DCasxCE'; */
$sql = "SELECT COUNT(*) AS pinned from pinned_elections where vid=(SELECT voterID from voters where vid = ".$_SESSION['vid'].") and eid = '$eid';";
$pinnedCount = mysqli_query($conn, $sql);
if ($pinnedCount->num_rows > 0) {$pinned = true;}
if ($pinned == true) {

?>
<span><img class="pinning" src="../../../uploads/pin.png" title="UNPIN" onclick="pinning('unpin', <?=$_SESSION['vid']?>, '<?=$eid?>', this)"></span>
<?php
} else if ($pinned == false) {
?>
	<span><img class="pinning" src="../../../uploads/unpin.png" title="PIN" onclick="pinning('pin', <?=$_SESSION['vid']?>, '<?=$eid?>', this)"></span>
<?php
}
?>
