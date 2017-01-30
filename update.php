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
        if(($imdbID == $movie['imdbID']) && ($checkdb == TRUE) && (!empty($movie['Title'])) && (!empty($movie['Plot']))) {
    	    $date_now = date("Y-m-d");
    	    //add to database
    	    if($movie['Type'] == "series") {
    		  $query = "UPDATE `imdb` SET `Title`='".mysql_prep($movie['Title'])."', `Year`='".$movie['Year']."', `Released`='".$movie['Released']."', `Runtime`='".$movie['Runtime']."', 
    		                            `Genre`='".$movie['Genre']."', `Director`='".mysql_prep($movie['Director'])."', `Writer`='".mysql_prep($movie['Writer'])."', 
    		                            `Actors`='".mysql_prep($movie['Actors'])."', `Plot`='".mysql_prep($movie['Plot'])."', `Language`='".$movie['Language']."', 
    		                            `Country`='".$movie['Country']."', `Poster`='".$movie['Poster']."', 
    		                            `imdbRating`='".$movie['imdbRating']."', `imdbVotes`='".$movie['imdbVotes']."', `Type`='".$movie['Type']."', 
    		                            `totalSeasons`='".$movie['totalSeasons']."' WHERE `imdbID`='".$movie['imdbID']."'"; 
		    } else {
    		  $query = "UPDATE `imdb` SET `Title`='".mysql_prep($movie['Title'])."', `Year`='".$movie['Year']."', `Released`='".$movie['Released']."', `Runtime`='".$movie['Runtime']."', 
    		                            `Genre`='".$movie['Genre']."', `Director`='".mysql_prep($movie['Director'])."', `Writer`='".mysql_prep($movie['Writer'])."', 
    		                            `Actors`='".mysql_prep($movie['Actors'])."', `Plot`='".mysql_prep($movie['Plot'])."', `Language`='".$movie['Language']."', 
    		                            `Country`='".$movie['Country']."', `Poster`='".$movie['Poster']."', 
    		                            `imdbRating`='".$movie['imdbRating']."', `imdbVotes`='".$movie['imdbVotes']."', `Type`='".$movie['Type']."', 
    		                            `totalSeasons`='0' WHERE `imdbID`='".$movie['imdbID']."'"; 
		    }
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