<?php
require_once ("includes/connection.php");
require_once ("includes/functions.php");

// Check if subject ID is provided
if (empty($_GET['sub']) || intval($_GET['sub']) == 0) {
	echo "No subject ID was provided.";
	// Assuming redirectTo is a function that redirects the user
	redirectTo('content.php');
}

// Handle form submission
if (isset($_POST['submit'])) {
	$errors = array();
	$required_fields = array('menu_name', 'position', 'visible');
	$errors = array_merge($errors, checkRequiredFields($required_fields));

	// Validate input length
	$length_validation = array('menu_name' => 30);
	foreach ($length_validation as $fieldname => $maxlength) {
		if (strlen(trim($_POST[$fieldname])) > $maxlength) {
			$errors[] = $fieldname;
		}
	}

	// Debugging: Check if errors are detected
	if (!empty($errors)) {
		echo "Errors detected: ";
		var_dump($errors);
	}

	if (empty($errors)) {
		// Sanitize input
		$id = intval($_GET['sub']);
		$menu_name = mysqli_real_escape_string($conn, $_POST['menu_name']);
		$position = intval($_POST['position']);
		$visible = intval($_POST['visible']);

		// Debugging: Check sanitized input
		// echo "Sanitized input: ID=$id, Menu Name=$menu_name, Position=$position, Visible=$visible";

		// Update subject in the database
		$query = "UPDATE subjects SET menu_name = '{$menu_name}', position = {$position}, visible = {$visible} WHERE id = {$id}";
		$result = mysqli_query($conn, $query);

		// Debugging: Check if query executed successfully
		if ($result) {
			// echo "Query executed successfully.";
		} else {
			echo "Query failed: " . mysqli_error($conn);
		}

		// Check for errors and update status
		if ($result) {
			if (mysqli_affected_rows($conn) == 1) {
				$message = "The subject was successfully updated.";
			} else {
				$message = "The subject update failed." . "</br>" . mysqli_error($conn);
			}
		} else {
			$message = "Database query failed.";
		}
	} else {
		$message = count($errors) . " error(s) in the form.";
	}
}


// Retrieve selected subject
findSelectedPage();
?>

<?php include ("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
			<?php navigation(); ?>
		</td>
		<td id="page">
			<h2>Edit Subject: <?php echo htmlspecialchars($selected_subject['menu_name']); ?></h2>
			<?php if (!empty($message)) {
				echo "<p class=\"message\">" . $message . "</p>";
			} ?>
			<?php
			// output a list of the fields that had errors
			if (!empty($errors)) {
				echo "<p class=\"errors\">";
				echo "Please review the following fields:<br />";
				foreach ($errors as $error) {
					echo " - " . $error . "<br />";
				}
				echo "</p>";
			}
			?>
			<form action="edit_subject.php?sub=<?php echo urlencode($selected_subject['id']); ?>" method="post">
				<p>Subject name:
					<input type="text" name="menu_name"
						value="<?php echo htmlspecialchars($selected_subject['menu_name']); ?>" id="menu_name" />
				</p>
				<p>Position:
					<select name="position">
						<?php
						$subject_set = getSubjects($conn);
						$subject_count = mysqli_num_rows($subject_set);
						// Display options for position
						for ($count = 1; $count <= $subject_count + 1; $count++) {
							echo "<option value=\"{$count}\"";
							if ($count == $selected_subject['position']) {
								echo " selected";
							}
							echo ">{$count}</option>";
						}
						?>
					</select>
				</p>
				<p>Visible:
					<input type="radio" name="visible" value="0" <?php if ($selected_subject['visible'] == 0) {
						echo " checked";
					} ?> /> No
					&nbsp;
					<input type="radio" name="visible" value="1" <?php if ($selected_subject['visible'] == 1) {
						echo " checked";
					} ?> /> Yes
				</p>
				<input type="submit" name="submit" value="Edit Subject" />
				&nbsp;&nbsp;
				<a href="delete_subject.php?sub=<?php echo urlencode($selected_subject['id']); ?>"
					onclick="return confirm('Are you sure?');">Delete Subject</a>
			</form>
			<br />
			<a href="content.php">Cancel</a>
			<div style="margin-top: 2em; border-top: 1px solid #000000;">
				<h3>Pages in this subject:</h3>
				<ul>
					<?php
					$subject_pages = getPageByIdForSubjects($selected_subject['id'], $conn);
					while ($page = mysqli_fetch_array($subject_pages)) {
						echo "<li><a href=\"content.php?page={$page['id']}\">
		{$page['menu_name']}</a></li>";
					}
					?>
				</ul>
				<br />
				+ <a href="new_page.php?sub=<?php echo $selected_subject['id']; ?>">Add a new page to this subject</a>
			</div>
		</td>
	</tr>
</table>
<?php require ("includes/footer.php"); ?>