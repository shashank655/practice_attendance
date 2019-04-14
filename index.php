<?php require_once 'employee/config/config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_ROOT ?>assets/img/favicon.png">
    <title>Bootstrap Admin Template</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_ROOT ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_ROOT ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_ROOT ?>assets/css/style.css">
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>
     <div class="main-wrapper">
        <div class="account-page">
            <div class="container">
            <?php if (isset($_SESSION[ 'Msg']) && $_SESSION[ 'Msg'] !='' ) { 
                                if($_SESSION['success']) {
                                    $alertClass = 'success';
                                    $alertValue = 'Success';
                                } else {
                                    $alertClass = 'danger';
                                    $alertValue = 'Error';
                                }
                            ?>    
                <div class="alert alert-<?php echo $alertClass; ?> alert-dismissible fade show" role="alert">
                    <strong><?php echo $alertValue; ?>!</strong> <?php echo $_SESSION['Msg']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                setTimeout(function() {
                    $(".alert").fadeOut("slow");
                }, 5000)
                </script>
            <?php 
                $_SESSION['Msg'] = '';
                unset($_SESSION['Msg']); 
            } ?>
            <!-- <h3 class="account-title text-white">Login</h3> -->
                <div class="account-box">
                    <div class="account-wrapper">
                    <!-- <div class="account-logo">
                            <a href="index.html"><img src="assets/img/logo.png" alt="SchoolAdmin"></a>
                        </div> -->
                        <form id="loginform" action="employee/process/processUser.php" method="post">
                        <input type="hidden" value="login" name="type" />
							<div class="form-group custom-mt-form-group">
								<input type="text" placeholder="Email Address"/ name="email_address">
                                <i class="bar"></i>
							</div>
                            <div class="form-group custom-mt-form-group">
								<input type="password"  placeholder="Password"/ name="password">
								<!-- <label class="control-label">Password</label> -->
                                <i class="bar"></i>
							</div>
                            <div class="form-group text-center custom-mt-form-group">
                                <button class="btn btn-primary account-btn" type="submit">Login</button>
                            </div>
                            <div class="d-flex text-center justify-content-between">
                                <a href="forgot-password.html">Forgot your password?</a>
                                <a href="signup.php">Proceed to SignUp</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
    <script type="text/javascript" src="<?php echo BASE_ROOT ?>assets/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_ROOT ?>assets/js/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_ROOT ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_ROOT ?>assets/js/jquery.slimscroll.js"></script>
    <script type="text/javascript" src="<?php echo BASE_ROOT ?>assets/js/app.js"></script>
    <script src="<?php echo BASE_ROOT ?>assets/js/jquery.validate.js"></script>
</body>
</html>
<script type="text/javascript">
    $(function(){
        $("#loginform").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                email_address:{
                    required:true,
                    email:true
                },                
                password:{
                    required:true
                }
            }
        });
    });    
</script>