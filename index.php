<!DOCTYPE html>
<html>
<?php
define('start',TRUE);
include('inc/classes.php');
include('inc/db.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/functions.php');
check_login();
$num_rec_per_page=10;
if (isset($_GET['title'])) {
    $title = $_GET['title'];
    $type = $_GET['type'];
    $check_search_type = startsWith($title,"tt");
    if (empty($_GET['page'])) {
        $page = 1;    
    } else {
        $page = $_GET['page'];                 
    }
    if((!empty($title)) && (!empty($type))) {
        try {
            $omdb = new OMDb();
		    if($check_search_type == TRUE) {
		    	//echo $check_search_type;
				$movie = $omdb->get_by_id($title);
			} else {
				$movie = $omdb->search($title,$type,$page);
			}
        } catch(Exception $e) {
            echo $e->getMessage(); 
        }
        if($check_search_type == FALSE) {
            if (!empty($movie['Search'])) {
	            $total_records = $movie['totalResults'];
	            $total_pages = ceil($total_records / $num_rec_per_page);
	            /*
                print "<pre>";
                print_r($movie);
                print "</pre>";
                */
            }	
		}
    }
    $url = "index.php";
    $url .= "?title=".$title;
    $url .= "&type=".$type;
}
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
    <!-- Custom box css -->
    <link href="assets/plugins/custombox/dist/custombox.min.css" rel="stylesheet">
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
<body class="fixed-left home">
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
                                <h4 class="page-title"><em>Dashboard</em></h4>
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
                            <li><a href="index.php" class="waves-effect active"><i class="fa fa-home"></i><span>Dashboard</span></a></li>
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
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                        			<h4 class="header-title m-t-0 m-b-30">IMDB SEARCH</h4>
                                    <form id="form" action="index.php" method="GET" data-parsley-validate novalidate>
                                        <div class="form-group">
                                            <?php if(isset($_GET['title'])): ?>
                                            <input type="text" class="form-control" required placeholder="Movie/Series Title" name="title" value="<?=$title?>" />
                                            <?php else: ?>
                                            <input type="text" class="form-control" required placeholder="Movie/Series Title" name="title" />
                                            <?php endif; ?>
                                        </div>
	                                    <div class="form-group">
	                                        <select class="form-control" required name="type">
	                                            <option value="all">All</option>
	                                            <option value="movie">Movies</option>
	                                            <option value="series">Series</option>
	                                        </select>
	                                    </div>
                                        <div class="form-group text-right m-b-0">
                                            <button class="btn btn-primary btn-lg waves-effect waves-light" type="submit" name="submit" value="1">
                                                <i class="fa fa-share"></i>&nbsp;&nbsp;SUBMIT
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- end col -->
                            <div class="col-lg-6">
                                <div class="card-box" style="height: 231px;">
                                    <h4 class="header-title m-t-0 m-b-30">DATABASE STATISTICS</h4>
                                    <table class="table table-bordered m-0">
                                        <thead>
                                            <tr>
                                                <th>#YEAR</th>
                                                <th>MOVIES</th>
                                                <th>SERIES</th>
                                                <th>TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $years = array("2017","2016");
                                        $tr_classes = array("now","none","none","none","none");
                                        $total_movies = array();
                                        $total_series = array();
                                        $total = array();
                                        $i = 0;
                                        foreach($years as $year) {
                                            $total_movies_y = count_stats("movie",$year);
                                            $total_series_y = count_stats("series",$year);
                                            $total_y = $total_movies_y+$total_series_y;
                                            //totals
                                            $total_movies[$i] = $total_movies_y;
                                            $total_series[$i] = $total_series_y;
                                            $total[$i] = $total_y;
                                            echo "
                                            <tr class=\"".$tr_classes[$i]."\">
                                                <td>".$year."</td>
                                                <td>".$total_movies_y."</td>
                                                <td>".$total_series_y."</td>
                                                <td>".$total_y."</td>
                                            </tr>
                                            ";
                                            $i++;
										}
                                        ?>
                                        </tbody>
                                        <tfoot>
                                        	<tr class="total">
                                        	    <td>ALL</td>
                                        	    <td><?php echo array_sum($total_movies); ?></td>
                                        	    <td><?php echo array_sum($total_series); ?></td>
                                        	    <td><?php echo array_sum($total); ?></td>
                                        	</tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                        <?php
                        if (isset($_GET['title'])) {
                          //by imdb id
                          if($check_search_type == TRUE) {
                          	if (!empty($movie)) {
	                            /*
                                print "<pre>";
                                print_r($movie);
                                print "</pre>";
                                */
                                echo "
                        <div class=\"row port m-b-0 m-t-0\">
                            <div class=\"portfolioContainer\" id=\"response\">
                                ";
		                            if (!file_exists("cache/".$movie['imdbID'].".jpg")) {
			                            imdb_download_image($movie['Poster'],$movie['imdbID']);
		                            }
		                            if ($movie['Type'] == "series") {
			                            $label_class = "success";
		                            } elseif ($movie['Type'] == "movie") {
			                            $label_class = "primary";
		                            } else {
			                            $label_class = "warning";
		                            }
		                            $checkdb = check($movie['imdbID']);
		                            if ((file_exists("cache/".$movie['imdbID'].".jpg")) && (filesize("cache/".$movie['imdbID'].".jpg") > 1000)) {
			                            $img = "cache/".$movie['imdbID'].".jpg";
			                            //$img = "assets/images/tt_no_img.jpg";
		                            } else {
			                            $img = "assets/images/tt_no_img.jpg";
		                            }
		                            echo "
                                <div class=\"col-sm-6 col-lg-3 col-md-4\">
                                    <div class=\"gal-detail thumb\">
                                        <a href=\"modal.php?tt=".$movie['imdbID']."\" data-toggle=\"modal\" data-target=\".modal-".$movie['imdbID']."\">
                                            <img src=\"".$img."\" class=\"thumb-img\" alt=\"".$movie['imdbID']."\" id=\"".$movie['imdbID']."\" /></a>
                                        <!-- modal dialog -->
                                        <div class=\"modal fade modal-".$movie['imdbID']."\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myLargeModalLabel\" aria-hidden=\"true\" style=\"display: none;\">
                                            <div class=\"modal-dialog modal-lg\">
                                                <div class=\"modal-content\"></div>
                                            </div>
                                        </div>
                                        <h4>".$movie['Title']."</h4>
                                        <p class=\"text-muted\">
                                          <span class=\"label label-info\">".$movie['Year']."</span>&nbsp;
                                            <span class=\"label label-".$label_class."\">".strtoupper($movie['Type'])."</span>&nbsp;
                                              <a href=\"http://www.imdb.com/title/".$movie['imdbID']."\" target=\"_blank\"><span class=\"label label-default\">IMDB</span></a>
                                        </p>
                                        <p class=\"text-muted\">";
                                            if($checkdb == TRUE) {
												echo "<a href=\"view.php?tt=".$movie['imdbID']."\"><span class=\"label label-success\" id=\"db-".$movie['imdbID']."\">IS IN DB</span></a>";
											} else {
												echo "<span class=\"label label-warning\" id=\"db-".$movie['imdbID']."\">NOT IN DB</span>";
											}
                                    echo "
                                        </p>
                                    </div>
                                </div>";
                          	}
                          //by title name
                          } else {
                            $z=1;
                            if (!empty($movie['Search'])) {
	                            /*
                                print "<pre>";
                                print_r($movie['Search']);
                                print "</pre>";
                                */
                                echo "
                        <div class=\"row port m-b-20 m-t-0\">
                            <div class=\"portfolioContainer\" id=\"response\">
                                ";
	                            foreach($movie['Search'] as $single) {
		                            if (!file_exists("cache/".$single['imdbID'].".jpg")) {
			                            imdb_download_image($single['Poster'],$single['imdbID']);
		                            }
		                            if ($single['Type'] == "series") {
			                            $label_class = "success";
		                            } elseif ($single['Type'] == "movie") {
			                            $label_class = "primary";
		                            } else {
			                            $label_class = "warning";
		                            }
		                            $checkdb = check($single['imdbID']);
		                            if ((file_exists("cache/".$single['imdbID'].".jpg")) && (filesize("cache/".$single['imdbID'].".jpg") > 1000)) {
			                            $img = "cache/".$single['imdbID'].".jpg";
			                            //$img = "assets/images/tt_no_img.jpg";
		                            } else {
			                            $img = "assets/images/tt_no_img.jpg";
		                            }
		                            echo "
                                <div class=\"col-sm-6 col-lg-2 col-md-4\">
                                    <div class=\"gal-detail thumb\">
                                        <a href=\"modal.php?tt=".$single['imdbID']."\" data-toggle=\"modal\" data-target=\".modal-".$single['imdbID']."\">
                                            <img src=\"".$img."\" class=\"thumb-img\" alt=\"".$single['imdbID']."\" id=\"".$single['imdbID']."\" /></a>
                                        <!-- modal dialog -->
                                        <div class=\"modal fade modal-".$single['imdbID']."\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myLargeModalLabel\" aria-hidden=\"true\" style=\"display: none;\">
                                            <div class=\"modal-dialog modal-lg\">
                                                <div class=\"modal-content\"></div>
                                            </div>
                                        </div>
                                        <h4>".$single['Title']."</h4>
                                        <p class=\"text-muted\">
                                          <span class=\"label label-info\">".$single['Year']."</span>&nbsp;
                                            <span class=\"label label-".$label_class."\">".strtoupper($single['Type'])."</span>&nbsp;
                                              <a href=\"http://www.imdb.com/title/".$single['imdbID']."\" target=\"_blank\"><span class=\"label label-default\">IMDB</span></a>
                                        </p>
                                        <p class=\"text-muted\">";
                                            if($checkdb == TRUE) {
												echo "<a href=\"view.php?tt=".$single['imdbID']."\"><span class=\"label label-success\" id=\"db-".$single['imdbID']."\">IS IN DB</span></a>";
											} else {
												echo "<span class=\"label label-warning\" id=\"db-".$single['imdbID']."\">NOT IN DB</span>";
											}
                                    echo "
                                        </p>
                                    </div>
                                </div>";
                                    if($z % 6 ==0) {
                                        echo "<div class=\"clearfix\"></div>";
                                    }
                                    $z++;
                                }
                                echo "
                            </div>
                        </div>";
                                echo "<ul class=\"pagination m-t-0 m-b-0\">";
                                if ($page > 4) {
	                                echo "<li><a href=\"".$url."&page=1\"><i class=\"fa fa-fast-backward\"></i></a></li>";
                                }
                                if ($page > 1) {
	                                echo "<li><a href=\"".$url."&page=".($page-1)."\"><i class=\"fa fa-step-backward\"></i></a></li>";
                                }
                                for($i = max(1, $page - 3); $i <= min($page + 3, $total_pages); $i++) {
                                    if ($page == $i) {
	                                    echo "<li class=\"active\"><a href=\"javascript:void(0);\">".$i."</a></li>";
	                                } else {
		                                echo "<li><a href=\"".$url."&page=".$i."\">".$i."</a></li>";
	                                }        
                                };
                                if ($page < $total_pages) {
	                                echo "<li><a href=\"".$url."&page=".($page+1)."\"><i class=\"fa fa-step-forward\"></i></a></li>";
                                }
                                if ($page <= $total_pages-4) {
	                                echo "<li><a href=\"".$url."&page=".$total_pages."\"><i class=\"fa fa-fast-forward\"></i></a></li>";
                                }
                                echo "</ul>";
                            //title not found
                            } else {
                                echo "
											<div class=\"alert alert-danger\">
												<strong>Oh snap!</strong>&nbsp;".$movie['Error']."
											</div>";
							}
						  }
						}
                        ?>
                    </div> <!-- container -->

                </div> <!-- content -->

                <footer class="footer">
                    <script type="text/javascript">document.write(new Date().getFullYear())</script>&nbsp;© Alex Soares
                    <span class="fr">iCTV 1.1</span>
                </footer>
  
            </div>
            <!-- End content-page -->
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
    <!-- isotope filter plugin -->
    <script type="text/javascript" src="assets/plugins/isotope/dist/isotope.pkgd.min.js"></script>
    <!-- Validation js (Parsleyjs) -->
    <script type="text/javascript" src="assets/plugins/parsleyjs/dist/parsley.min.js"></script>
    <!-- Modal-Effect -->
    <script src="assets/plugins/custombox/dist/custombox.min.js"></script>
    <script src="assets/plugins/custombox/dist/legacy.min.js"></script>
    <!-- Toastr js -->
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <!-- App js -->
    <script type="text/javascript" src="assets/js/jquery.core.js"></script>
    <script type="text/javascript" src="assets/js/jquery.app.js"></script>
    <!--
    <script type="text/javascript">
        $(window).load(function(){
            var $container = $('.portfolioContainer');
            $container.isotope({
                filter: '*',
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
            });
            $('.portfolioFilter a').click(function(){
                $('.portfolioFilter .current').removeClass('current');
                $(this).addClass('current');
                var selector = $(this).attr('data-filter');
                $container.isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 750,
                        easing: 'linear',
                        queue: false
                    }
                });
                return false;
            });
        });
	</script>
    -->
</body>
</html>