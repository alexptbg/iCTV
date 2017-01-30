<?php
define('start',TRUE);
include('inc/classes.php');
include('inc/db.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/functions.php');
if ((isset($_POST['tt'])) && (!empty($_POST['tt'])) && (isset($_POST['season']))) {
    $tt = $_POST['tt'];
    $season = $_POST['season'];
    $checkdb = check($tt);
$omdb = new OMDb();
$movie = $omdb->get_season($tt,$season);

echo "
<div class=\"container m-b-20\">
    <div class=\"row card-box imdb\">";
//return data
if (!empty($movie)) {
	
	echo "<h3>".$movie['Title']." / ".$movie['Season']." <small class=\"small\">(".$movie['totalSeasons'].")</small></h3>";
	echo "
    <table class=\"table table-bordered m-0\">
        <thead>
            <tr>
                <th>#</th>
                <th>TITLE</th>
                <th>imdbRATING</th>
                <th>imdbID</th>
                <th>RELEASED</th>
            </tr>
        </thead>
        <tbody>";
	foreach($movie['Episodes'] as $alone) {
		$s = json_decode(json_encode($alone),true);
		echo "
            <tr>
                <td scope=\"row\">".$s['Episode']."</td>
                <td>".$s['Title']."</td>
                <td>".$s['imdbRating']."</td>
                <td><a href=\"http://www.imdb.com/title/".$s['imdbID']."\" target=\"_blank\">".$s['imdbID']."</a></td>
                <td>".$s['Released']."</td>
            </tr>";
	}
    echo "
        </tbody>
    </table>";
}
/*
print "<pre>";
print_r($movie);
print "</pre>";
*/
echo "
    </div>
</div>";
}
?>