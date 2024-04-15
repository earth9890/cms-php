<?php require_once ('includes/session.php');
confirm_logged_in();

?>
<?php if (!isset($new_page)) {
    $new_page = false;
} ?>

<p>Page name: <input type="text" name="menu_name" value="<?php echo $selected_page['menu_name']; ?>" id="menu_name" />
</p>

<p>Position: <select name="position">
        <?php
        if (!$new_page) {
            $page_set = getPageByIdForSubjects($selected_page['subject_id'], $conn);
            $page_count = mysqli_num_rows($page_set);
        } else {
            $page_set = getPageByIdForSubjects($selected_subject['id'], $conn);
            $page_count = mysqli_num_rows($page_set) + 1;
        }
        for ($count = 1; $count <= $page_count; $count++) {
            echo "<option value=\"{$count}\"";
            if ($selected_page['position'] == $count) {
                echo " selected";
            }
            echo ">{$count}</option>";
        }
        ?>
    </select></p>
<p>Visible:
    <input type="radio" name="visible" value="0" <?php
    if ($selected_page['visible'] == 0) {
        echo " checked";
    }
    ?> /> No
    &nbsp;
    <input type="radio" name="visible" value="1" <?php
    if ($selected_page['visible'] == 1) {
        echo " checked";
    }
    ?> /> Yes
</p>
<p>Content:<br />
    <textarea name="content" rows="20" cols="80"><?php echo $selected_page['content']; ?></textarea>
</p>