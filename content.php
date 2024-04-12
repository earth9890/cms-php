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

<table id="structure" class="w-full">
    <tr>
        <td id="navigation" class="w-1/4 bg-gray-100 p-4">
            <?php
            require 'includes/connection.php';
            require 'includes/functions.php';
            $subjectResult = getSubjects($conn);
            checkQueryResult($subjectResult, $conn);
            while ($subjectRow = $subjectResult->fetch_assoc()) {
                $subjectId = $subjectRow['id'];
                echo "<ul class=\"mb-4\">";
                echo "<li";
                if ($selected_subj == $subjectId) {
                    echo " class=\"font-bold\"";
                }
                echo "><a href=\"content.php?subj=" . urlencode($subjectId) . "\" class=\"text-blue-500\"> {$subjectRow["menu_name"]} </a></li>";
                $pageResult = getPageByIdForSubjects($conn, $subjectId);
                checkQueryResult($pageResult, $conn);
                while ($pageRow = $pageResult->fetch_assoc()) {
                    echo "<li";
                    if ($selected_page == $pageRow['id']) {
                        echo " class=\"font-bold\"";
                    }
                    echo "><a href=\"content.php?page=" . urlencode($pageRow['id']) . "\" class=\"text-blue-500\">{$pageRow["menu_name"]} </a></li>";
                }
                echo "</ul>";
            }
            ?>
        </td>
        <td id="page" class="w-3/4 bg-white p-4">
            <h2 class="text-2xl font-bold">Content Area</h2>
            <?php
            echo $selected_subj . "<br/>";
            echo $selected_page;
            ?>
        </td>
    </tr>
</table>
<?php require 'includes/footer.php'; ?>
