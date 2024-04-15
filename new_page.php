<?php require_once ("includes/connection.php"); ?>
<?php require_once ("includes/functions.php"); ?>
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
			<h2>Adding New Page</h2>
			<?php if (!empty($message)) {
				echo "<p class=\"message\">" . $message . "</p>";
			} ?>

			<form action="createPage.php?sub=<?php echo $selected_subject['id']; ?>" method="post">

				<?php $new_page = true; ?>
				<?php include "page_form.php" ?>
				<input type="submit" name="submit" value="Create Page" />
			</form>
			<br />
			<a href="edit_subject.php?sub=<?php echo $selected_subject['id']; ?>">Cancel</a><br />
		</td>
	</tr>
</table>
<?php include ("includes/footer.php"); ?>