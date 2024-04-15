<?php
require_once ('includes/connection.php');
require_once ('includes/functions.php');
?>
<?php
if (intval($_GET['sub']) == 0) {
	redirectTo("content.php");
}
$id = htmlspecialchars($_GET['sub']);
if ($subject = getSubjectById($id, $conn)) {
	$query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
	$result = mysqli_query($conn, $query);
	if (mysqli_affected_rows($conn) == 1) {
		redirectTo("content.php");
	} else {
		// Failed to Delete
		echo "Delete failed: " . mysqli_error($conn);
		echo "<br><a href=\"content.php\">Return to Main Page</a>";
	}
} else {
	// no subject in DB
	redirectTo("content.php");
}
?>
<?php mysqli_close($conn); ?>