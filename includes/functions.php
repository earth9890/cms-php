<?php
function checkQueryResult($result, $conn)
{
    if (!$result) {
        die("Database query failed: " . $conn->error);
    }
}

function getSubjects($conn, $public = true)
{
    if ($public) {
        $query = "SELECT * FROM subjects where visible = 1 order by position  ASC";
    } else {
        $query = "SELECT * FROM subjects order by position  ASC";
    }
    $subjectResult = $conn->query($query);
    checkQueryResult($subjectResult, $conn);
    return $subjectResult;
}

function getPageByIdForSubjects($id, $conn, $public = true)
{
    if ($public) {
        $query = "SELECT * FROM pages WHERE subject_id = {$id} AND visible = 1 order by position ASC";
    } else {
        $query = "SELECT * FROM pages WHERE subject_id = {$id} order by position ASC";
    }
    $pageResult = $conn->query($query);
    checkQueryResult($pageResult, $conn);
    return $pageResult;
}


function getSubjectById($id, $conn)
{
    // echo var_dump($id);
    // echo $id . "from getSubjectById";
    $query = "SELECT * FROM subjects WHERE id = {$id} limit 1";
    $subjectResult = $conn->query($query);
    checkQueryResult($subjectResult, $conn);
    $result = $subjectResult;
    if ($subjectResult->num_rows <= 0) {
        echo "No subject found";
    }
    $result = $subjectResult->fetch_assoc();
    // echo print_r($result) . "odfosfnsod";

    return $result;

}

function getPagesById($id, $conn)
{
    $query = "SELECT * FROM pages WHERE id = {$id} LIMIT 1";
    $pageResult = $conn->query($query);
    checkQueryResult($pageResult, $conn);
    $result = $pageResult->fetch_assoc();
    return $result;
}

function getDefaultPage($subject_id, $conn)
{
    $page_set = getPageByIdForSubjects($subject_id, $conn);
    if ($first_page = mysqli_fetch_array($page_set)) {
        return $first_page;
    } else {
        return NULL;
    }
}

function get_default_page($subject_id)
{
    // Get all visible pages
    global $conn;
    $page_set = getPageByIdForSubjects($subject_id, $conn, true);
    if ($first_page = mysqli_fetch_array($page_set)) {
        return $first_page;
    } else {
        return NULL;
    }
}
function findSelectedPage()
{
    global $conn;
    global $selected_subject;
    global $selected_page;
    if (isset($_GET['sub'])) {
        $selected_subject = getSubjectById($_GET['sub'], $conn);
        $selected_page = get_default_page($selected_subject['id']);
    } elseif (isset($_GET['page'])) {
        $selected_page = getPagesById($_GET['page'], $conn);
        $selected_subject = NULL;
    } else {
        $selected_subject = NULL;
        $selected_page = NULL;
    }
}

function navigation($public = false)
{
    global $selected_subject;
    global $selected_page;
    global $conn;
    $subjectResult = getSubjects($conn, $public);
    checkQueryResult($subjectResult, $conn);
    while ($subjectRow = $subjectResult->fetch_assoc()) {
        $subjectId = $subjectRow['id'];
        echo "<li";
        if ($selected_subject['id'] == $subjectId && $selected_page == NULL) {
            echo " style=\"font-weight: bold;\"";
        }
        echo "><a href=\"edit_subject.php?sub=" . urlencode($subjectId) . "\"> {$subjectRow["menu_name"]} </a></li>";
        $pageResult = getPageByIdForSubjects($subjectId, $conn);
        checkQueryResult($pageResult, $conn);
        echo "<ul >";
        while ($pageRow = $pageResult->fetch_assoc()) {
            echo "<li";
            if ($selected_page['id'] == $pageRow['id'] && $selected_subject == NULL) {
                echo " style=\"font-weight: bold;\"";
            }
            echo "><a href=\"content.php?page=" . urlencode($pageRow['id']) . "\">{$pageRow["menu_name"]} </a></li>";
        }
        echo "</ul>";
    }
}


function redirectTo($location = NULL)
{
    if ($location != NULL) {
        header("Location: {$location}");
        exit;
    }
}

function checkRequiredFields($required)
{
    $errors = array();
    foreach ($required as $fieldname) {
        if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname]) && $_POST[$fieldname] != 0) {
            $errors[] = $fieldname;
        }
    }

    return $errors;
}

function mysql_prep($value)
{
    global $conn; // Assuming $connection is your database connection object
    $value = mysqli_real_escape_string($conn, $value);
    return $value;
}




function check_max_field_lengths($length)
{
    $errors = array();
    foreach ($length as $fieldname => $maxlength) {
        if (strlen(trim(htmlspecialchars($_POST[$fieldname]))) > $maxlength) {
            $errors[] = $fieldname;
        }
    }

    return $errors;
}

function display_errors($error_array)
{
    echo "<p class=\"errors\">";
    echo "Please review the following fields:<br />";
    foreach ($error_array as $error) {
        echo " - " . $error . "<br />";
    }
    echo "</p>";
}


function public_navigation($public = true)
{
    global $selected_subject;
    global $selected_page;
    global $conn;
    $subjectResult = getSubjects($conn, $public);
    checkQueryResult($subjectResult, $conn);
    while ($subjectRow = $subjectResult->fetch_assoc()) {
        $subjectId = $subjectRow['id'];

        echo "<li";
        if ($selected_subject['id'] == $subjectId && $selected_page == NULL) {
            echo " style=\"font-weight: bold;\"";
        }
        echo "><a href=\"index.php?sub=" . urlencode($subjectId) . "\"> {$subjectRow["menu_name"]} </a></li>";
        $pageResult = getPageByIdForSubjects($subjectId, $conn);
        checkQueryResult($pageResult, $conn);
        echo "<ul >";
        while ($pageRow = $pageResult->fetch_assoc()) {
            echo "<li";
            if ($selected_page['id'] == $pageRow['id'] && $selected_subject == NULL) {
                echo " style=\"font-weight: bold;\"";
            }
            echo "><a href=\"index.php?page=" . urlencode($pageRow['id']) . "\">{$pageRow["menu_name"]} </a></li>";
        }
        echo "</ul>";
    }
}