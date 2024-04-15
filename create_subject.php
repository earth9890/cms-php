<?php require_once ("includes/connection.php"); ?>
<?php require_once ("includes/functions.php"); ?>
<?php



$required_fields = array('menu_name', 'position', 'visible');
checkRequiredFields($required_fields);
if (!empty($errors)) {
	redirectTo("new_subject.php");
}
?>
<?php
$menu_name = $_POST['menu_name'];
$position = $_POST['position'];
$visible = $_POST['visible'];
?>
<?php
$query = "INSERT INTO subjects (
				menu_name, position, visible
			) VALUES (
				'{$menu_name}', {$position}, {$visible}
			)";
$result = mysqli_query($conn, $query);
if ($result) {
	// Success!
	redirectTo("new_subject.php");

} else {
	// Display error message.
	echo "<p>Subject creation failed.</p>";
	echo "<p>" . mysqli_error($conn) . "</p>";
}
?>

<?php mysqli_close($connection); ?>