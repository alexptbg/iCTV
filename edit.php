<?php
define('start',TRUE);
include('inc/classes.php');
include('inc/db.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/functions.php');
$seasons = array();
if (isset($_POST['tt'])) {
	$tt = $_POST['tt'];
	if (isset($_POST['seasons'])) {
	    $seasons = $_POST['seasons'];	
	}
	if (isset($_POST['repeat-box'])) {
		$repeat = 1;
	} else {
		$repeat = 0;
	}
	$checkdb = check($tt);
    $seasons = implode(",",$seasons);
    if((!empty($tt)) && ($checkdb == TRUE)) {
	    $query = "UPDATE `imdb` SET `seen`='".$seasons."',`repeat`='".$repeat."' WHERE `imdbID`='".$tt."'";
        $result = mysql_query($query);
        confirm_query($result);
        if ($result) {
            echo "OK";
        } else {
		    echo "error-1";
		}
    } else {
	    echo "error-2";
	}
} else {
	//do nothing
}
?>