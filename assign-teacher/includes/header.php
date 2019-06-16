<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <title>Adhyay</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_ROOT ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_ROOT ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/plugins/light-gallery/css/lightgallery.min.css">
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
<!-- Modal Success Popup -->
<?php if (isset($_SESSION[ 'Msg']) && $_SESSION[ 'Msg'] !='' ) { 
    if($_SESSION['success']) {
        $alertValue = 'Success';
    } else {
        $alertValue = 'Error';
    }
?>
<div id="myModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $alertValue; ?>!</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p><?php echo $_SESSION[ 'Msg']; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Done</button>
                </div>
            </div>
        </div>
    </div>
<?php 
    $_SESSION[ 'Msg']='' ; unset($_SESSION[ 'Msg']);
} ?>
    <div class="main-wrapper">
        <div class="header"> <!-- Header start -->
            <div class="header-left">
                <a href="dashboard.php" class="logo">
                    <img src="<?php echo BASE_ROOT ?>assets/img/logo.png" alt="">
                    <!-- <span class="text-uppercase">Preschool</span> -->
                </a>
            </div>
            <div class="page-title-box float-left">
              <h3 class="text-uppercase">Preschool</h3>
            </div>
            <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars" aria-hidden="true"></i></a>
            
            <div class="dropdown mobile-user-menu float-right"> <!-- mobile menu -->
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <?php  if (!empty($adminData[0]['admin_profile_image']) && $_SESSION['user_role'] == '1') { ?>
                        <a class="dropdown-item" href="admin-profile.php">My Profile</a>
                        <a class="dropdown-item" href="edit-admin-profile.php">Edit Profile</a>
                        <a class="dropdown-item" href="employee/process/processUser.php?type=logout">Logout</a>
                    <?php } else { ?>
                        <a class="dropdown-item" href="teacher-profile.php?userId=<?php echo $_SESSION['userId']?>">My Profile</a>
                        <a class="dropdown-item" href="employee/process/processUser.php?type=logout">Logout</a>
                    <?php } ?> 
                </div>
            </div>
        </div>