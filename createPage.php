<?php
require_once ('includes/connection.php');
require_once ('includes/functions.php');
?>
<?php
$errors = array();
$required_fields = array('menu_name', 'position', 'visible', 'content');
checkRequiredFields($required_fields);
$length_validation = array('menu_name' => 30);
foreach ($length_validation as $fieldname => $maxlength) {
    if (strlen(trim(htmlspecialchars($_POST[$fieldname]))) > $maxlength) {
        $errors[] = $fieldname;
    }
}
echo var_dump($errors);
if (!empty($errors)) {
    echo "Got erros";

    redirectTo("new_page.php");
}
?>
<?php
$menu_name = htmlspecialchars($_POST['menu_name']);
$position = htmlspecialchars($_POST['position']);
$visible = htmlspecialchars($_POST['visible']);
echo $visible . "okkkk - ";
$content = htmlspecialchars($_POST['content']);
$subject_id = htmlspecialchars($_GET['sub']);

$query = "INSERT INTO pages (subject_id, menu_name, position, visible, content) VALUES({$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}')";
if (mysqli_query($conn, $query)) {
    header("Location: content.php");
    exit;
} else {
    echo "<p>Page creation failed.</p>";
    echo "<p>" . mysqli_error($conn) . "</p>";
}
?>
<?php mysqli_close($conn); ?>