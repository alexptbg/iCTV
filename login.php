<!DOCTYPE html>
<html>
<?php
define('start',TRUE);
include('inc/classes.php');
include('inc/db.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/functions.php');
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
    <link rel="stylesheet" type="text/css" href="assets/plugins/toastr/toastr.min.css" />
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
<body>
        <div class="account-pages p-t-40 m-b-40"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
        	<div class="m-t-40 card-box">
                <div class="text-center">
                    <a href="index.php" class="logo-login"><span><strong>i</strong><em><span>CT<span>V</span></span></em></span><i class="zmdi zmdi-layers"></i></a>
                </div>
                <div class="panel-body">
                    <form id="form" action="check.php" method="post" data-parsley-validate novalidate>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" required="" placeholder="Password" name="password" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <br/><br/>
                            </div>
                        </div>
                        <div class="form-group text-center p-b-40">
                            <div class="col-xs-12">
                                <button class="btn btn-custom btn-bordred btn-primary btn-block waves-effect waves-light" type="submit" name="submit">
                                    <i class="fa fa-sign-in" aria-hidden="true">&nbsp;&nbsp;</i>LOG IN</button>
                            </div>
                        </div>
                    </form>
                </div>
                <p></p>
                <p></p>
                <p></p>
            </div>
            <!-- end card-box-->
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
    <!-- Validation js (Parsleyjs) -->
    <script type="text/javascript" src="assets/plugins/parsleyjs/dist/parsley.min.js"></script>
    <!-- Modal-Effect -->
    <script type="text/javascript" src="assets/plugins/custombox/dist/custombox.min.js"></script>
    <script type="text/javascript" src="assets/plugins/custombox/dist/legacy.min.js"></script>
    <!-- Toastr js -->
    <script type="text/javascript" src="assets/plugins/toastr/toastr.min.js"></script>
    <!-- App js -->
    <script type="text/javascript" src="assets/js/jquery.core.js"></script>
    <script type="text/javascript" src="assets/js/jquery.app.js"></script>
</body>
</html>