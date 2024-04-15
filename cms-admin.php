<?php
require_once 'includes/session.php';
session_start();
require_once 'includes/functions.php';

if (logged_in()) {
    redirectTo('staff.php');
}
redirectTo('login.php');