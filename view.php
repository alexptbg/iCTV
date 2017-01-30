<!DOCTYPE html>
<html>
<?php
define('start',TRUE);
include('inc/classes.php');
include('inc/db.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/functions.php');
check_login();
$tt = $_GET['tt'];
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="Alex Soares" />
    <!-- App Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <!-- App title -->
    <title>iCTV</title>
    <!-- Notification css (Toastr) -->
    <link href="assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
    <!-- App CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/animate.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/core.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/components.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/icons.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/pages.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/menu.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/extend.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="assets/js/html5shiv.js"></script>
    <script type="text/javascript" src="assets/js/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="assets/js/modernizr.min.js"></script>
</head>
<body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">
            <!-- Top Bar Start -->
            <div class="topbar">
                <!-- LOGO -->
                <div class="topbar-left">
                    <a href="index.php" class="logo"><span><strong>i</strong><em><span>CT<span>V</span></span></em></span><i class="zmdi zmdi-layers"></i></a>
                </div>
                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <!-- Page title -->
                        <ul class="nav navbar-nav navbar-left">
                            <li>
                                <button class="button-menu-mobile open-left"><i class="zmdi zmdi-menu"></i></button>
                            </li>
                            <li>
                                <h4 class="page-title"><em><?php echo $tt; ?></em></h4>
                            </li>
                        </ul>
                        <!-- Right(Notification and Searchbox -->
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <!-- Notification -->
                                <div class="notification-box">
                                    <ul class="list-inline m-b-0">
                                        <li>
                                            <a href="javascript:void(0);" class="right-bar-toggle"><i class="zmdi zmdi-notifications-none"></i></a>
                                            <div class="noti-dot">
                                                <span class="dot"></span>
                                                <span class="pulse"></span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End Notification bar -->
                            </li>
                            <li class="hidden-xs">
                                <form role="search" class="app-search" action="search.php" method="get">
                                    <input type="text" placeholder="Search..." class="form-control" name="search" />
                                    <a href="javascript:void(0);"><i class="fa fa-search"></i></a>
                                </form>
                            </li>
                        </ul>
                    </div><!-- end container -->
                </div><!-- end navbar -->
            </div>
            <!-- Top Bar End -->

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!-- User -->
                    <div class="user-box">
                        <div class="user-img">
                            <img src="assets/images/users/avatar.jpg" alt="user-img" title="Alex Soares" class="img-circle img-thumbnail img-responsive" />
                            <div class="user-status online"><i class="zmdi zmdi-dot-circle"></i></div>
                        </div>
                        <h5><a href="#">Alex Soares</a> </h5>
                        <ul class="list-inline">
                            <li><a href="#"><i class="zmdi zmdi-settings"></i></a></li>
                            <li><a href="#" class="text-themed"><i class="zmdi zmdi-power"></i></a></li>
                        </ul>
                    </div>
                    <!-- End User -->
                    <!--- Sidebar -->
                    <div id="sidebar-menu">
                        <ul>
                        	<!--<li class="text-muted menu-title">Navigation</li>-->
                            <li><a href="index.php" class="waves-effect"><i class="fa fa-home"></i><span>Dashboard</span></a></li>
                            <li><a href="imdb.php?Type=all" class="waves-effect"><i class="fa fa-ticket"></i><span>All</span></a></li>
                            <li><a href="imdb.php?Type=movie" class="waves-effect"><i class="fa fa-film"></i><span>Movies</span></a></li>
                            <li><a href="imdb.php?Type=series" class="waves-effect"><i class="fa fa-video-camera"></i><span>Series</span></a></li>
                            <!--
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-view-list"></i><span>Test Menu</span><span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                	<li><a href="#">PDF</a></li>
                                    <li><a href="#">EXCEL</a></li>
                                    <li><a href="#">WORD</a></li>
                                    <li><a href="#">PHOTOS</a></li>
                                    <li><a href="#">VIDEOS</a></li>
                                </ul>
                            </li>
                            -->
                            <!--<li class="text-muted menu-title">Settings</li>-->
                            <!--<li><a href="settings.php" class="waves-effect"><i class="fa fa-cog"></i><span>Settings</span></a></li>-->
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <!-- Sidebar -->
                    <div class="clearfix"></div>
                    <div class="lg"><img src="assets/images/lg.png" alt="lg.png" /></div>
                </div>
            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                        <?php
                            $sql = "SELECT * FROM `imdb` WHERE `imdbID`='".$tt."'";
                            $res = mysql_query($sql);
                            confirm_query($res);
                            $rows = mysql_num_rows($res);
                            if ($rows != 0) {
                            	echo "";
                            	while($t = mysql_fetch_array($res)) {
		                            if (!file_exists("cache/".$t['imdbID'].".jpg")) {
			                            imdb_download_image($t['Poster'],$t['imdbID']);
		                            }
	                                if ($t['Type'] == "series") {
			                            $label_class = "success";
		                                if ($t['repeat'] == 1) {
										    $repeat_class = "success";
										    $repeat_text = "YES";
									    } else {
										    $repeat_class = "warning";
										    $repeat_text = "NO";
									    }
		                            } elseif ($t['Type'] == "movie") {
			                            $label_class = "primary";
		                            } else {
		                                $label_class = "warning";
		                            }
		                            if ((file_exists("cache/".$t['imdbID'].".jpg")) && (filesize("cache/".$t['imdbID'].".jpg") > 1000)) {
		                                $img = "cache/".$t['imdbID'].".jpg";
		                                //$img = "assets/images/tt_no_img.jpg";
		                            } else {
			                            $img = "assets/images/tt_no_img.jpg";
		                            }
		                            $totalMinutes = $t['Runtime'];
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
                    <div class=\"container m-b-20\">
                        <div class=\"row card-box imdb\">
                            <div class=\"col-sm-3\">
                                <div class=\"bg-picture\">
                                    <div class=\"profile-info-name\">
                                        <img src=\"".$img."\" class=\"img-thumbnail\" alt=\"profile-image\" />
                                        <div class=\"clearfix\"></div>
                                    </div>
                                </div>
                            </div>
                            <div class=\"col-sm-9\">
                                <div class=\"bg-picture\">
                                    <div class=\"profile-info-name\">
                                        <div class=\"profile-info-detail\">
                                            <h3 class=\"m-t-0 m-b-0\"><strong>".$t['Title']."</strong>&nbsp;/&nbsp;(".$t['Year'].")&nbsp;/&nbsp;(".$t['Released'].")
                                                <span class=\"mrating\">".$t['imdbRating']."&nbsp;<i class=\"fa fa-star\"></i></span></h3>
                                            <p class=\"text-muted m-b-10\"><i>".$t['Genre']."</i>
                                                <span class=\"mrating\"><small>".$t['imdbVotes']."</small>&nbsp;&nbsp;<i class=\"fa fa-users\"></i></span></p>
                                            <p class=\"m-b-0\">Plot:</p>
                                            <p>".$t['Plot']."</p>
                                            <p class=\"m-b-0\">Director(s):</p>
                                            <p>".$t['Director']."</p>
                                            <p class=\"m-b-0\">Writter(s):</p>
                                            <p>".$t['Writer']."</p>
                                            <p class=\"m-b-0\">Actors:</p>
                                            <p>".$t['Actors']."</p>
                                            <p class=\"m-b-0\">Language(s):</p>
                                            <p>".$t['Language']."</p>
                                            <p class=\"m-b-0\">Country:</p>
                                            <p>".$t['Country']."</p>
                                            <p class=\"m-b-0\">Runtime:</p>
                                            <p>".$runtime."</p>";
                                            if($t['Type'] == "series") {
			                                    echo "
			                                    <p>Type:</p>
			                                <p class=\"m-b-10\"><span class=\"label label-".$label_class."\">".strtoupper($t['Type'])."</span></p>
                                            <p class=\"m-b-0\">Seasons: (".$t['totalSeasons'].")&nbsp;&nbsp;

                                    <div id=\"myModal-".$t['imdbID']."\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
                                        <div class=\"modal-dialog\">
                                          <form class=\"form-seasons\" id=\"form-".$t['imdbID']."\">
                                            <div class=\"modal-content\">
                                                <div class=\"modal-header\">
                                                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>
                                                    <h3 class=\"modal-title\" id=\"myModalLabel\">".$t['Title']."</h3>
                                                </div>
                                                <div class=\"modal-body\">
                                                <h4 class=\"modal-title\" id=\"myModalLabel\">Edit seen seasons</h4>
	                                            <div class=\"form-group\">
	                                                <input type=\"hidden\" class=\"form-control\" readonly=\"\" value=\"".$t['imdbID']."\" name=\"tt\" id=\"tt\" />
	                                            </div>";
                                                for ($x = 1; $x <= $t['totalSeasons']; $x++) {
                                                	$seenx = check_seasons($t['imdbID'],$x);
                                                	if ($seenx == TRUE) {
														$checked = "checked=\"checked\"";
													} else {
														$checked = "";
													}
													echo "
													  <div class=\"form-group\">
                                                        <div class=\"checkbox checkbox-success\">
                                                          <input id=\"checkbox-".$x."\" type=\"checkbox\" name=\"seasons[]\" data-parsley-multiple=\"groups\" value=\"".$x."\" $checked />
                                                          <label for=\"checkbox-".$x."\"> Season ".$x." </label>
                                                        </div>
                                                      </div>";
												}
												if ($t['repeat'] == 1) {
													$repeat_value = "checked=\"checked\"";
												} else {
													$repeat_value = "";
												}
												echo "
												      <hr>
													  <div class=\"form-group\">
                                                        <div class=\"checkbox checkbox-success\">
                                                          <input id=\"repeat-box\" type=\"checkbox\" name=\"repeat-box\" data-parsley-multiple=\"groups\" $repeat_value />
                                                          <label for=\"repeat-box\"> Watch it again? </label>
                                                        </div>
                                                      </div>
												";
                                                echo "
                                                </div>
                                                <div class=\"modal-footer\">
                                                    <button type=\"button\" class=\"btn btn-default waves-effect\" data-dismiss=\"modal\">
                                                        <i class=\"fa fa-times\" aria-hidden=\"true\"></i>&nbsp;&nbsp;CLOSE</button>
                                                    <button type=\"submit\" class=\"btn btn-primary waves-effect waves-light\" name=\"submit\" id=\"submit\">
                                                        <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i>&nbsp;&nbsp;SAVE CHANGES</button>
                                                </div>
                                            </div>
                                          </form>
                                        </div>
                                    </div>
                                            <p class=\"m-t-10 m-b-10\">";
                                                for ($x = 1; $x <= $t['totalSeasons']; $x++) {
                                                	$seen = check_seasons($t['imdbID'],$x);
                                                	if ($seen == TRUE) {
														$seen_class = "success";
													} else {
														$seen_class = "warning";
													}
													echo "<span id=\"seasons\" class=\"label label-".$seen_class."\" data=\"".$x."\">".$x."</span>&nbsp;";
												}
                                                echo "
                                            </p>
                                            <p class=\"m-b-10\">Watch it again:</p>
                                            <p><span id=\"repeat\" class=\"label label-".$repeat_class."\">".$repeat_text."</span></p>";
		                                    } else {
		                                    	echo "
		                                    	<p>Type:</p>
												<p><span class=\"label label-".$label_class."\">".strtoupper($t['Type'])."</span>";
											}
		                                    echo "
                                            <p class=\"m-t-20 m-b-0\"><button type=\"button\" class=\"btn btn-danger waves-effect waves-light\" onclick=\"del('".$t['imdbID']."');\">
                                                <i class=\"fa fa-trash\" aria-hidden=\"true\"></i>&nbsp;&nbsp;DEL FROM DB</button>&nbsp;
                                            <button type=\"button\" class=\"btn btn-primary waves-effect waves-light\" onclick=\"update('".$t['imdbID']."');\">
                                                <i class=\"fa fa-database\" aria-hidden=\"true\"></i>&nbsp;&nbsp;UPDATE DB</button>&nbsp;
                                                <button type=\"button\" class=\"btn btn-info waves-effect waves-light\" onclick=\"window.open('http://www.imdb.com/title/".$t['imdbID']."');\"><i class=\"fa fa-eye\" aria-hidden=\"true\"></i>&nbsp;&nbsp;VIEW AT IMDB</button><span style=\"float:right;\">".$t['when']."</span>&nbsp;";
                                            if($t['Type'] == "series") {
                                            	echo "
                                            <button class=\"btn btn-purple waves-effect waves-light\" data-toggle=\"modal\" data-target=\"#myModal-".$t['imdbID']."\">
                                                <i class=\"fa fa-pencil-square-o\"></i>&nbsp;&nbsp;EDIT SEEN SEASONS</button>";
                                            }
                                            echo "
                                            </p>
                                          </div>
                                        <div class=\"clearfix\"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- container -->
                            		";
                            	}
                            }
                            echo "<div id=\"loader\"></div>";
                        ?>
                        <!--
                        <div class="row">
                            <div class="col-sm-12">

                            </div>
                        </div>
                        -->
                        <!-- End row -->

                </div> <!-- content -->

                <footer class="footer">
                    <script type="text/javascript">document.write(new Date().getFullYear())</script>&nbsp;© Alex Soares
                    <span class="fr">iCTV 1.1</span>
                </footer>

            </div>
            <!-- End content-page -->
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->

            <!-- Right Sidebar -->
            <div class="side-bar right-bar">
                <a href="javascript:void(0);" class="right-bar-toggle">
                    <i class="zmdi zmdi-close-circle-o"></i>
                </a>
                <h4 class="">Latest additions</h4>
                <div class="notification-list nicescroll">
                    <ul class="list-group list-no-border user-list">
                        <?php
                            $sql = "SELECT * FROM `imdb` ORDER BY `id` DESC LIMIT 10";
                            $res = mysql_query($sql);
                            confirm_query($res);
                            $rows = mysql_num_rows($res);
                            if ($rows != 0) {
                            	while($l = mysql_fetch_array($res)) {
                            		if ($l['Type'] == "series") {
										$lclass = " active";
									} else {
										$lclass = "";
									}
		                            if ((file_exists("cache/".$l['imdbID'].".jpg")) && (filesize("cache/".$l['imdbID'].".jpg") > 1000)) {
		                                $img = "cache/".$l['imdbID'].".jpg";
		                            } else {
			                            $img = "assets/images/tt_no_img.jpg";
		                            }
                            		echo "
                        <li class=\"list-group-item".$lclass."\">
                            <a href=\"view.php?tt=".$l['imdbID']."\" class=\"user-list-item\">
                                <div class=\"avatar\">
                                    <img src=\"".$img."\" alt=\"".$img."\" />
                                </div>
                                <div class=\"user-desc\">
                                    <span class=\"name\">".$l['Title']."</span>
                                    <span class=\"desc\">".$l['Year']."</span>
                                    <span class=\"time\">".$l['when']."</span>
                                </div>
                            </a>
                        </li>";
                            	}
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <!-- /Right-bar -->

    </div>
    <!-- END wrapper -->
    <script>
        var resizefunc = [];
    </script>
    <!-- jQuery  -->
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/detect.js"></script>
    <script type="text/javascript" src="assets/js/fastclick.js"></script>
    <script type="text/javascript" src="assets/js/jquery.slimscroll.js"></script>
    <script type="text/javascript" src="assets/js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="assets/js/waves.js"></script>
    <script type="text/javascript" src="assets/js/jquery.nicescroll.js"></script>
    <script type="text/javascript" src="assets/js/jquery.scrollTo.min.js"></script>
    <script type="text/javascript" src="assets/js/extend.js"></script>
    <!-- Toastr js -->
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <!-- App js -->
    <script type="text/javascript" src="assets/js/jquery.core.js"></script>
    <script type="text/javascript" src="assets/js/jquery.app.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
    	$('span#seasons').click(function (data) {
    		var season = $(this).attr("data");
    		//alert(season);
    		//console.log(data);
            $.ajax({
                url: "season.php",
                data: { 'tt': '<?php echo $tt; ?>', 'season': season },
                type: "POST",
                success: function(data) {
                    $("#loader").html(data);
                },
                error: function(xhr, status) {
                    //alert("Sorry, there was a problem loading season data!");
                    toastr["error"]("Sorry, there was a problem loading the season data!");
                }
            });
    	});
        $("#submit").click(function(event) {
        	event.preventDefault();
            var id = $(".form-seasons").attr('id');
            var data = $("#"+id).serialize();
            var tt = $('input#tt').val();
            //console.log(data);
            //alert(id);
            $.ajax({
                type: "POST",
                url: 'edit.php',
                data: data,
                success: function(response) {
        	        //console.log(response);
                    if (response == "OK") {
				        toastr["success"](tt+" seasons was updated to the database.");
				        $(".modal").modal("hide");
			        } else if (response == "error-1") {
				        toastr["error"]("An unexpected error has occurred.");
			        } else if (response == "error-2") {
				        toastr["error"](tt+" doesnt exists in the database.");
			        } else {
				        toastr["error"](response);
			        }
                    var delay = 10;
                    setTimeout(function(){ window.location.href = 'view.php?tt=<?php echo $tt; ?>'; }, delay);
                }
            });
        });
    });
//delete from db
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
        	console.log(response);
            if (response == "OK") {
				toastr["success"](tt+" was deleted from database.");
			} else if (response == "error-1") {
				toastr["error"]("An unexpected error has occurred.");
			} else if (response == "error-2") {
				toastr["error"](tt+" doesnt exists in the database.");
			} else {
				toastr["error"](response);
			}
            var delay = 10;
            setTimeout(function(){ window.location.href = 'imdb.php?Type=all'; }, delay);
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
                setTimeout(function(){ window.location.href = 'view.php?tt=<?php echo $tt; ?>'; }, delay);
            }
        });
        return false;
    }
    </script>
</body>
</html>