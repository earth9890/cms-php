<?php require_once ("includes/connection.php"); ?>
<?php require_once ("includes/functions.php"); ?>
<?php

if (intval($_GET['page']) == 0) {
	redirectTo('content.php');
}

$id = mysql_prep($_GET['page']);
// make sure the page exists (not strictly necessary)
// it gives some extra security and allows use of 
// the page's subject_id for the redirect
if ($page = getPagesById($id, $conn)) {
	
	$query = "DELETE FROM pages WHERE id = {$page['id']} LIMIT 1";
	$result = mysqli_query($conn, $query);
	if (mysqli_affected_rows($conn) == 1) {
		// Successfully deleted
		redirectTo("edit_subject.php?subj={$page['subject_id']}");
	} else {
		// Deletion failed
		echo "<p>Page deletion failed.</p>";
		echo "<p>" . mysqli_error($conn) . "</p>";
		echo "<a href=\"content.php\">Return to Main Site</a>";
	}
} else {
	// page didn't exist, deletion was not attempted
	redirectTo('content.php');
}
?>
<?php
// because this file didn't include footer.php we need to add this manually
mysqli_close($db);
?>