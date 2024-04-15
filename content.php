<?php require_once 'includes/header.php';

findSelectedPage()
    ?>

<table id="structure">
    <tr>
        <td id="navigation">&nbsp;
            <?php
            navigation()
                ?>


            <?php echo "<li><a href=\"new_subject.php\">+ Add New Subject</a></li>"; ?>
        </td>
        <td id="page">
            <!-- <h2> Content Area</h2> -->
            <?php if (!is_null($selected_subject)) { // subject selected ?>
                <h2><?php echo $selected_subject['menu_name']; ?></h2>
            <?php } elseif (!is_null($selected_page)) { // page selected ?>
                <h2><?php echo $selected_page['menu_name']; ?></h2>
                <div>
                    <?php echo $selected_page['content']; ?>
                </div>
                <br />
                <a href="edit_page.php?page=<?php echo urlencode($selected_page['id']); ?>">Edit page</a>
            <?php } else { // nothing selected ?>
                <h2>Select a subject or page to edit</h2>
            <?php } ?>
        </td>
    </tr>
</table>
<?php require ("includes/footer.php"); ?>