<?php require_once ("includes/session.php");
session_start();
?>
<?php require_once ("includes/connection.php"); ?>
<?php require_once ("includes/functions.php"); ?>

<?php findSelectedPage(); ?>
<?php include ("includes/header.php"); ?>
<table id="structure">
    <tr>
        <td id="navigation">
            <?php echo public_navigation($public = true); ?>
        </td>
        <td id="page">
            <?php if ($selected_page) { ?>
                <h2><?php echo htmlentities($selected_page['menu_name']); ?></h2>
                <div class="page-content">
                    <?php echo strip_tags($selected_page['content']); ?>
                </div>
                <?php
                if (!logged_in()) {
                    echo "<a href='login.php'><button>Login</button></a> ";
                }
                ?>
            <?php } else { ?>
                <h2>Welcome to Widget Corp</h2>
                <?php
                if (!logged_in()) {
                    echo "<a href='login.php'><button>Login</button></a> ";
                }
                ?>

            <?php } ?>
        </td>
    </tr>
</table>
<?php include ("includes/footer.php"); ?>