<?php
define('start',TRUE);
include('inc/classes.php');
include('inc/db.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/functions.php');
if ((isset($_POST['tt'])) && (!empty($_POST['tt']))) {
    $imdbID = $_POST['tt'];
    $checkdb = check($imdbID);
    try {
        $omdb = new OMDb();
        $movie = $omdb->get_by_id($imdbID);
        if(($imdbID == $movie['imdbID']) && ($checkdb == TRUE)) {
    	    //del from database
            $query = "DELETE FROM `imdb` WHERE `imdbID`='".$movie['imdbID']."'";
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
    } catch(Exception $e) {
        echo $e->getMessage();
    }
} else {
	
}
?>