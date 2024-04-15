<?php require_once ("includes/connection.php"); ?>
<?php require_once ("includes/functions.php"); ?>
<?php
if (intval($_GET['page']) == 0) {
	redirectTo("content.php");
}
if (isset($_POST['submit'])) {
	$errors = array();
	$required_fields = array('menu_name', 'position', 'visible', 'content');
	$errors = array_merge($errors, checkRequiredFields($required_fields));

	$field_length = array('menu_name' => 30);
	$errors = array_merge($errors, check_max_field_lengths($field_length));

	$id = htmlspecialchars($_GET['page']);
	$menu_name = htmlspecialchars($_POST['menu_name']);
	$position = htmlspecialchars($_POST['position']);
	$visible = htmlspecialchars($_POST['visible']);
	$content = htmlspecialchars($_POST['content']);


	if (empty($errors)) {
		$query = "UPDATE pages SET menu_name = '{$menu_name}', position = '{$position}', visible = '{$visible}', content = '{$content}' WHERE id = {$id}";
		$result = mysqli_query($conn, $query);
		if (mysqli_affected_rows($conn) == 1) {
			$message = "The page was successfully updated.";
		} else {
			$message = "The page update failed.";
			$message .= "<br>" . mysqli_error($conn);
		}
	} else {
		$message = count($errors) . " error(s) in the form.";
	}
} // END isset(submit)
findSelectedPage();
?>
<?php findSelectedPage(); ?>
<?php include ("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
			<?php echo navigation(); ?>
			<br />
			<a href="new_subject.php">+ Add a new subject</a>
		</td>
		<td id="page">
			<h2>Edit page: <?php echo $sel_page['menu_name']; ?></h2>
			<?php if (!empty($message)) {
				echo "<p class=\"message\">" . $message . "</p>";
			} ?>
			<?php if (!empty($errors)) {
				display_errors($errors);
			} ?>

			<form action="edit_page.php?page=<?php echo $selected_page['id']; ?>" method="post">
				<?php include "page_form.php" ?>
				<input type="submit" name="submit" value="Update Page" />&nbsp;&nbsp;
				<a href="delete_page.php?page=<?php echo $selected_page['id']; ?>"
					onclick="return confirm('Are you sure you want to delete this page?');">Delete page</a>
			</form>
			<br />
			<a href="content.php?page=<?php echo $sel_page['id']; ?>">Cancel</a><br />
		</td>
	</tr>
</table>
<?php include ("includes/footer.php"); ?>