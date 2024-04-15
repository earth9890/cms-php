<?php include ('includes/header.php'); ?>
<?php
if (isset($_POST['submit'])) {
    $errors = array();

   

    $required_fields = array('username', 'password');
    $errors = array_merge($errors, checkRequiredFields($required_fields));

    $field_length = array('username' => 30, 'password' => 30);
    $errors = array_merge($errors, check_max_field_lengths($field_length));

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $hashed_password = sha1($password);

    if (empty($errors)) {
        $query = "INSERT INTO users(username, hashed_password) VALUES ('{$username}', '{$hashed_password}')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $message = "The user was successfully created.";
        } else {
            $message = "The user could not be created.";
            $message .= "<br> " . mysqli_error($conn);
        }
    } else {

        $message = count($errors) . " error(s) in the form.";
    }

} else {
    $username = '';
    $password = '';
}
?>

<div class="container">
    <h3>Create new user</h3>
    <?php if (!empty($message)) {
        echo "<p class=\"alert alert-success\">" . $message . "</p>";
    } ?>
    <?php if (!empty($errors)) {
        display_errors($errors);
    } ?>
    <form action="new_user.php" method="POST">
        <div class="mb-3">
            <span>Username: </span>
            <input class="form-control w-auto" type="text" name="username" maxlength="30"
                value="<?php echo htmlentities($username); ?>" />
        </div>
        <div class="mb-3">
            <span>Password: </span>
            <input class="form-control w-auto" type="password" name="password" maxlength="30"
                value="<?php echo htmlentities($password); ?>" />
        </div>
        <input type="submit" name="submit" value="Create User">
    </form>
</div>
<?php include ('includes/footer.php') ?>