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
        $_SESSION['Msg'] = "Sign up successfully";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT);
    } else {
        $_SESSION['Msg'] = "Email address already exist , please login!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT);
    }
} else if ($data['type'] == 'email_verfication') {
    $result = $user->userEmailVerification($data);
    if ($result) {
        $_SESSION['Msg'] = "Sign up successfully";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT);
    } else {
        $_SESSION['Msg'] = "Email address already exist , please login!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT);
    }
} elseif ($data['type'] == 'logout') {
    session_unset();
    session_destroy();
    header('Location: ' . BASE_ROOT);
} else {
    header("Location: ". BASE_ROOT);
}
?>
