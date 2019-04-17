<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/User.php';
$user = new User();
$data = $_REQUEST;
if ($data['type'] == 'login') {
    $result = $user->userLogin($data);
    if ($result) {
        header('Location: ' . BASE_ROOT.'dashboard.php');
    } else {
        $_SESSION['Msg'] = "Inavalid Email Or Password";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT);
    } 
} else if ($data['type'] == 'super_admin_signup') {
    $result = $user->userRegistration($data);
    if ($result) {
        $_SESSION['Msg'] = "Sign up successfully, please check your email for Email verification!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT);
    } else {
        $_SESSION['Msg'] = "Email address already exist , please login!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT);
    }
} else if ($data['type'] == 'email_verification') {
    $result = $user->userEmailVerification($data);
    if ($result) {
        $_SESSION['Msg'] = "Email has been verified successfully, please login now!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT);
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT);
    }
} else if ($data['type'] == 'forgetPassword') {
    $result = $user->userForgetPassword($data);
    if ($result) {
        $_SESSION['Msg'] = "A link has been sent to your email address, please click on ";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT);
    } else {
        $_SESSION['Msg'] = "Email address does not found!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'forgot-password.php');
    }
} else if ($data['type'] == 'resetPassword') {
    $result = $user->userResetPassword($data);
    if ($result) {
        $_SESSION['Msg'] = "Password has been reset successfully ";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'index.php');
    } else {
        $_SESSION['Msg'] = "Email address does not found!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'forgot-password.php');
    }
} elseif ($data['type'] == 'logout') {
    session_unset();
    session_destroy();
    header('Location: ' . BASE_ROOT);
} else {
    header("Location: ". BASE_ROOT);
}
?>
