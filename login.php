<?php require ("includes/session.php") ?>
<?php require_once ("includes/connection.php"); ?>
<?php require_once ("includes/functions.php"); ?>
<?php


if (logged_in()) {
	redirectTo("staff.php");
}
if (isset($_POST['submit'])) {
	$errors = array();

	// perform validations on the form data
	$required_fields = array('username', 'password');
	$errors = array_merge($errors, checkRequiredFields($required_fields));

	$fields_with_lengths = array('username' => 30, 'password' => 30);
	$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));

	$username = trim(mysql_prep($_POST['username']));
	$password = trim(mysql_prep($_POST['password']));
	$hashed_password = sha1($password);

	if (empty($errors)) {
		$query = "SELECT id, username ";
		$query .= "FROM users ";
		$query .= "WHERE username = '{$username}' ";
		$query .= "AND hashed_password = '{$hashed_password}' ";
		$query .= "LIMIT 1";
		$result_set = mysqli_query($conn, $query);
		checkQueryResult($result_set, $conn);
		if (mysqli_num_rows($result_set) == 1) {
			$found_user = mysqli_fetch_array($result_set);
			$_SESSION['user_id'] = $found_user['id'];
			$_SESSION['username'] = $found_user['username'];

			redirectTo("staff.php");
		} else {
			$message = "Username/password combination incorrect.<br />
					Please make sure your caps lock key is off and try again.";
		}
	} else {
		if (count($errors) == 1) {
			$message = "There was 1 error in the form.";
		} else {
			$message = "There were " . count($errors) . " errors in the form.";
		}
	}

} else {
	if (isset($_GET['logout']) && $_GET['logout'] == 1) {
		$message = "You are now logged out.";
	}
	$username = "";
	$password = "";
}
?>
<?php include ("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
			<a href="index.php">Return to public site</a>
		</td>
		<td id="page">
			<h2>Staff Login</h2>
			<?php if (!empty($message)) {
				echo "<p class=\"message\">" . $message . "</p>";
			} ?>
			<?php if (!empty($errors)) {
				display_errors($errors);
			} ?>
			<form action="login.php" method="post">
				<table>
					<tr>
						<td>Username:</td>
						<td><input type="text" name="username" maxlength="30"
								value="<?php echo htmlentities($username); ?>" /></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="password" name="password" maxlength="30"
								value="<?php echo htmlentities($password); ?>" /></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" name="submit" value="Login" /></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>
<?php include ("includes/footer.php"); ?>