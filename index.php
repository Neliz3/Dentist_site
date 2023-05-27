<?php 
session_start();
if (isset($_SESSION['phone']))
{
    $timeout = 2;

    ini_set( "session.gc_maxlifetime", $timeout);

    if (isset($_SESSION['position'])) header("Location: admin.php");
    else header("Location: /templates/home-page.php");
}
else header("Location: login.php");
?>
