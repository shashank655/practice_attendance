<?php require_once 'employee/config/config.php';
if (!isset($_SESSION['userId'])) {
    header('Location:' . BASE_ROOT);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <title>Preschool - Bootstrap Admin Template</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_ROOT ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_ROOT ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_ROOT ?>assets/css/fullcalendar.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_ROOT ?>assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_ROOT ?>assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_ROOT ?>assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_ROOT ?>assets/plugins/morris/morris.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_ROOT ?>assets/css/style.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>

<body>
    <div class="main-wrapper">
        <div class="header"> <!-- Header start -->
            <div class="header-left">
                <a href="index.html" class="logo">
                    <img src="<?php echo BASE_ROOT ?>assets/img/logo.png" width="40" height="40" alt="">
					<span class="text-uppercase">Preschool</span>
                </a>
            </div>
            <div class="page-title-box float-left">
              <h3 class="text-uppercase">Preschool</h3>
            </div>
            <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars" aria-hidden="true"></i></a>
            <ul class="nav user-menu float-right">
                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                        <span class="user-img"><img class="rounded-circle" src="<?php echo BASE_ROOT ?>assets/img/user.jpg" width="40" alt="Admin">
							<span class="status online"></span></span>
                        <span>Admin</span>
                    </a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="profile.html">My Profile</a>
						<a class="dropdown-item" href="edit-profile.html">Edit Profile</a>
						<a class="dropdown-item" href="settings.html">Settings</a>
						<a class="dropdown-item" href="employee/process/processUser.php?type=logout">Logout</a>
					</div>
                </li>
            </ul>
            <div class="dropdown mobile-user-menu float-right"> <!-- mobile menu -->
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.html">My Profile</a>
                    <a class="dropdown-item" href="edit-profile.html">Edit Profile</a>
                    <a class="dropdown-item" href="settings.html">Settings</a>
                    <a class="dropdown-item" href="login.html">Logout</a>
                </div>
            </div>
        </div>