<?php
define('start',TRUE);
include('inc/classes.php');
include('inc/db.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/functions.php');
if ((isset($_POST['password'])) && (!empty($_POST['password']))) {
    $mypassword = mysql_prep($_POST['password']);
    ob_start();
    check_password($mypassword);
} else {
	
}
?>