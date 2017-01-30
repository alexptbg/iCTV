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
        if(($imdbID == $movie['imdbID']) && ($checkdb == FALSE) && (!empty($movie['Title'])) && (!empty($movie['Plot']))) {
    	    $date_now = date("Y-m-d");
    	    //add to database
    	    if($movie['Type'] == "series") {
		        $query = "INSERT INTO `imdb` (`Title`,`Year`,`Released`,`Runtime`,`Genre`,`Director`,`Writer`,`Actors`,`Plot`,`Language`,`Country`,`Poster`,`imdbRating`,`imdbVotes`,`imdbID`,`Type`,`totalSeasons`,`when`) 
				          VALUES ('".mysql_prep($movie['Title'])."','".$movie['Year']."','".$movie['Released']."','".$movie['Runtime']."','".$movie['Genre']."','".mysql_prep($movie['Director'])."','".mysql_prep($movie['Writer'])."','".mysql_prep($movie['Actors'])."','".mysql_prep($movie['Plot'])."','".$movie['Language']."','".$movie['Country']."','".$movie['Poster']."','".$movie['imdbRating']."','".$movie['imdbVotes']."','".$movie['imdbID']."','".$movie['Type']."','".$movie['totalSeasons']."','".$date_now."')";
		    } else {
		        $query = "INSERT INTO `imdb` (`Title`,`Year`,`Released`,`Runtime`,`Genre`,`Director`,`Writer`,`Actors`,`Plot`,`Language`,`Country`,`Poster`,`imdbRating`,`imdbVotes`,`imdbID`,`Type`,`totalSeasons`,`when`) 
				          VALUES ('".mysql_prep($movie['Title'])."','".$movie['Year']."','".$movie['Released']."','".$movie['Runtime']."','".$movie['Genre']."','".mysql_prep($movie['Director'])."','".mysql_prep($movie['Writer'])."','".mysql_prep($movie['Actors'])."','".mysql_prep($movie['Plot'])."','".$movie['Language']."','".$movie['Country']."','".$movie['Poster']."','".$movie['imdbRating']."','".$movie['imdbVotes']."','".$movie['imdbID']."','".$movie['Type']."','0','".$date_now."')";
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