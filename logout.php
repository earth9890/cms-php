<?php require_once 'includes/functions.php'; ?>

<?php session_start();
$_SESSION = array();

if(isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

session_destroy();

redirectTo('login.php?logout=1');


?>