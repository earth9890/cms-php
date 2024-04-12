<?php require_once 'includes/header.php'; ?>
<?php
if (isset($_GET['subj'])) {
    $selected_subj = $_GET['subj'];
    $selected_page = "";
} elseif (isset($_GET['page'])) {
    $selected_page = $_GET['page'];
    $selected_subj = "";

} else {
    $selected_page = "";
    $selected_subj = "";
}
?>

<table id="structure">
    <tr>
        <td id="navigation">&nbsp;

            <?php
            require 'includes/connection.php';
            require 'includes/functions.php';
            $subjectResult = getSubjects($conn);
            checkQueryResult($subjectResult, $conn);
            while ($subjectRow = $subjectResult->fetch_assoc()) {
                $subjectId = $subjectRow['id'];
                echo "<li";
                if ($selected_subj == $subjectId) {
                    echo " style=\"font-weight: bold;\"";
                }
                echo "><a href=\"content.php?subj=" . urlencode($subjectId) . "\"> {$subjectRow["menu_name"]} </a></li>";
                $pageResult = getPageByIdForSubjects($conn, $subjectId);
                checkQueryResult($pageResult, $conn);
                echo "<ul class=\"pages";
                if ($selected_subj == $subjectId) {
                    echo " selected-ul";
                }
                echo "\">";

                while ($pageRow = $pageResult->fetch_assoc()) {
                    $menuName = $pageRow['menu_name'];
                    echo "<li";
                    if ($selected_page == $pageRow['id']) {
                        echo " style=\"font-weight: bold;\"";
                    }
                    echo "><a href=\"content.php?page=" . urlencode($pageRow['id']) . "\">{$pageRow["menu_name"]} </a></li>";
                }
                echo "</ul>";
            }
            ?>

        </td>
        <td id="page">
            <h2> Content Area</h2>
            <?php
            echo $selected_subj . "<br/>";
            echo $selected_page;

            ?>

        </td>
    </tr>
</table>
<?php require 'includes/footer.php'; ?>