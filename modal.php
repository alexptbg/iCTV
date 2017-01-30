<?php
define('start',TRUE);
include('inc/classes.php');
include('inc/db.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/functions.php');
$tt = $_GET['tt'];
if(!empty($tt)) {
    try {
        $omdb = new OMDb();
        $movie = $omdb->get_by_id($tt);
    } catch(Exception $e) {
        echo $e->getMessage(); 
    }
    if (!empty($movie)) {
    	/*
        print "<pre>";
        print_r($movie);
        print "</pre>";
        */
		if (!file_exists("cache/".$movie['imdbID'].".jpg")) {
			imdb_download_image($movie['Poster'],$movie['imdbID']);
		}
		$checkdb = check($movie['imdbID']);
	    if ($movie['Type'] == "series") {
			$label_class = "success";
		} elseif ($movie['Type'] == "movie") {
			$label_class = "primary";
		} else {
		    $label_class = "warning";
		}
		if ((file_exists("cache/".$movie['imdbID'].".jpg")) && (filesize("cache/".$movie['imdbID'].".jpg") > 1000)) {
		    $img = "cache/".$movie['imdbID'].".jpg";
		    //$img = "assets/images/tt_no_img.jpg";
		} else {
			$img = "assets/images/tt_no_img.jpg";
		}
		$totalMinutes = $movie['Runtime'];
        $hours = intval($totalMinutes/60);
        $minutes = $totalMinutes - ($hours * 60);
        if($totalMinutes > 60) {
            if ($hours < 10) {
				$hours = "0".$hours;
			}
            if ($minutes < 10) {
				$minutes = "0".$minutes;
			}
			$runtime = $hours.":".$minutes;
		} else {
			$runtime = $totalMinutes." minutes";
		}
        echo "
    <div class=\"modal-header\">
      <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\"><i class=\"fa fa-times\"></i></button>
        <h3 class=\"m-t-0 m-b-0\"><strong>".$movie['Title']."</strong>&nbsp;/&nbsp;(".$movie['Year'].")&nbsp;/&nbsp;(".$movie['Released'].")
          <span class=\"mrating\">".$movie['imdbRating']."&nbsp;<i class=\"fa fa-star\"></i></span></h3>
        <p class=\"text-muted m-b-0\"><i>".$movie['Genre']."</i>
          <span class=\"mrating\"><small>".$movie['imdbVotes']."</small>&nbsp;&nbsp;<i class=\"fa fa-users\"></i></span></p>
    </div>
    <div class=\"modal-body\">
      <div class=\"row\">
        <div class=\"col-sm-4\">
          <div class=\"bg-picture\">
            <div class=\"profile-info-name\">
              <img src=\"".$img."\" class=\"img-thumbnail\" alt=\"profile-image\" />
              <div class=\"clearfix\"></div>
            </div>
          </div>
        </div>
        <div class=\"col-md-8\">
          <div class=\"profile-info-name\">
            <div class=\"profile-info-detail\">
              <p class=\"m-b-0\">Plot:</p>
              <p>".$movie['Plot']."</p>
              <p class=\"m-b-0\">Director(s):</p>
              <p>".$movie['Director']."</p>
              <p class=\"m-b-0\">Writter(s):</p>
              <p>".$movie['Writer']."</p>
              <p class=\"m-b-0\">Actors:</p>
              <p>".$movie['Actors']."</p>
              <p class=\"m-b-0\">Language(s):</p>
              <p>".$movie['Language']."</p>
              <p class=\"m-b-0\">Country:</p>
              <p>".$movie['Country']."</p>
              <p class=\"m-b-0\">Runtime:</p>
              <p>".$runtime."</p>";
        if($movie['Type'] == "series") {
        	if($checkdb == TRUE) {
        		$repeat = checkRepeat($movie['imdbID']);
		        if ($repeat == 1) {
					$repeat_class = "success";
					$repeat_text = "YES";
				} else {
					$repeat_class = "warning";
					$repeat_text = "NO";
				}
        		echo "
        		<p class=\"m-b-0\">Type:</p>
        		<p><span class=\"label label-".$label_class."\">".strtoupper($movie['Type'])."</span></p>
        		<p class=\"m-b-0\">Seasons: (".$movie['totalSeasons'].")</p>
                                            <p class=\"m-t-0 m-b-10\">";
                                                for ($x = 1; $x <= $movie['totalSeasons']; $x++) {
                                                	$seen = check_seasons($movie['imdbID'],$x);
                                                	if ($seen == TRUE) {
														$seen_class = "success";
													} else {
														$seen_class = "warning";
													}
													echo "<span id=\"seasons\" class=\"label label-".$seen_class."\" data=\"".$x."\">".$x."</span>&nbsp;";
												}
                                                echo "
                                            </p>
                <p class=\"m-b-0\">Watch it again?</p>
                <p><span id=\"repeat\" class=\"label label-".$repeat_class."\">".$repeat_text."</span></p>";      
        	} else {
			echo "
              <p class=\"m-b-0\">Seasons:</p>
              <p><span class=\"label label-warning\">".$movie['totalSeasons']."</span></p>";
			}
		} else {
        echo "
              <p class=\"m-b-0\">Type:</p>
              <p><span class=\"label label-".$label_class."\">".strtoupper($movie['Type'])."</span></p>";
		}
        if($checkdb == TRUE) {
			echo "<p class=\"m-b-0\"><span class=\"label label-success\">IS IN DB</span></p>";
		} else {
			echo "<p class=\"m-b-0\"><span class=\"label label-warning\">NOT IN DB</span></p>";
		}
        echo "
              </p>
            </div>
          <div class=\"clearfix\"></div>
        </div>
        </div>
      </div>
    </div>
    <div class=\"modal-footer\">";
        if($checkdb == TRUE) {
            echo "
      <button type=\"button\" class=\"btn btn-danger waves-effect waves-light\" onclick=\"del('".$movie['imdbID']."');\">
          <i class=\"fa fa-trash\" aria-hidden=\"true\"></i>&nbsp;&nbsp;DEL FROM DB</button>
      <button type=\"button\" class=\"btn btn-primary waves-effect waves-light\" onclick=\"update('".$movie['imdbID']."');\">
          <i class=\"fa fa-database\" aria-hidden=\"true\"></i>&nbsp;&nbsp;UPDATE DB</button>";
        } else {
			echo "
	  <button type=\"button\" class=\"btn btn-success waves-effect waves-light\" onclick=\"add('".$movie['imdbID']."')\">
	      <i class=\"fa fa-plus\" aria-hidden=\"true\"></i>&nbsp;&nbsp;ADD TO DB</button>";
		}
        echo "
      <button type=\"button\" class=\"btn btn-info waves-effect waves-light\" onclick=\"window.open('http://www.imdb.com/title/".$movie['imdbID']."');\">
          <i class=\"fa fa-eye\" aria-hidden=\"true\"></i>&nbsp;&nbsp;VIEW AT IMDB</button>";
      if($checkdb == TRUE) {
          echo "
            <a class=\"btn btn-purple waves-effect waves-light\" href=\"view.php?tt=".$movie['imdbID']."\"><i class=\"fa fa-eye\"></i>&nbsp;&nbsp;VIEW</a>";	
      }
      echo "
      <button type=\"button\" class=\"btn btn-default waves-effect\" data-dismiss=\"modal\">
          <i class=\"fa fa-times\" aria-hidden=\"true\"></i>&nbsp;&nbsp;CLOSE</button>
    </div>";
    }
}
?>
<script type="text/javascript">
//del from database
function del(tt) {
	var answer = confirm("Are you sure that you want to delete "+tt+"?");
	if (answer){ ttdel(tt); }
	else{ alert(tt+" wasn't deleted."); }
}
function ttdel(tt) {
    $.ajax({
        type: "POST",
        url: "del.php",
        data: { 'tt': tt },
        success: function(response){
        	//console.log(response);
            if (response == "OK") {
				toastr["success"](tt+" was deleted from database.");
				$(".modal").modal("hide");
			} else if (response == "error-1") {
				toastr["error"]("An unexpected error has occurred.");
			} else if (response == "error-2") {
				toastr["error"](tt+" doesnt exists in the database.");
			} else {
				toastr["error"](response);
			}
            var delay = 10;
            setTimeout(function(){ location.reload(); }, delay);
        }
    });
    return false;
}
//add to database
function add(tt) {
	var answer = confirm("Are you sure that you want to add "+tt+" to the database?");
	if (answer){ ttadd(tt); }
	else{ alert(tt+" wasn't added."); }
}
function ttadd(tt) {
    $.ajax({
        type: "POST",
        url: "add.php",
        data: { 'tt': tt },
        success: function(response){
        	//console.log(response);
            if (response == "OK") {
				toastr["success"](tt+" was added to the database.");
				$(".modal").modal("hide");
			} else if (response == "error-1") {
				toastr["error"]("An unexpected error has occurred.");
			} else if (response == "error-2") {
				toastr["error"](tt+" doesnt exists in the database.");
			} else {
				toastr["error"](response);
			}
            var delay = 10;
            setTimeout(function(){ location.reload(); }, delay);
        }
    });
    return false;
}
//update to db
function update(tt) {
	var answer = confirm("Synchronise "+tt+" from IMDB?");
	if (answer){ ttupdate(tt); }
	else{ alert(tt+" wasn't synchronised."); }
}
function ttupdate(tt) {
    $.ajax({
        type: "POST",
        url: "update.php",
        data: { 'tt': tt },
        success: function(response){
        	//console.log(response);
            if (response == "OK") {
				toastr["success"](tt+" was update to the database.");
			} else if (response == "error-1") {
				toastr["error"]("An unexpected error has occurred.");
			} else if (response == "error-2") {
				toastr["error"](tt+" doesnt exists in the database.");
			} else {
				toastr["error"](response);
			}
            var delay = 10;
            setTimeout(function(){ location.reload(); }, delay);
        }
    });
    return false;
}
</script>   