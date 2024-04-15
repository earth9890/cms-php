<?php require_once 'includes/session.php'; ?>
<?php require_once 'includes/connection.php'; ?>
<?php require_once 'includes/functions.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="stylesheets/public.css">
    <title>Widget Corp</title>
</head>

<body>
    <div id="header">
        <h1><a href="staff.php" style="color: white;">Widget Corp</a></h1>
        <?php if (logged_in()): ?>
            <div id="logout" style="position: fixed; top: 45px; right: 10px;">
                <a href="logout.php"
                    style="background-color: red; padding: 10px 20px; color: white; text-decoration: none;">Logout</a>
            </div>
        </div>
        </div>
    <?php endif; ?>
    </div>
    <div id="main">