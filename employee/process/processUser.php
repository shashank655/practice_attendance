<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/User.php';
require_once '../class/Admin.php';
$user = new User();
$admin = new Admin();
$data = $_REQUEST;
date_default_timezone_set('Asia/Kolkata');
if ($data['type'] == 'login') {
        if($data['user_role'] == 'parents') {
            $result = $user->parentsLogin($data);
        } else {
            $result = $user->userLogin($data);
        }
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
} else if ($data['type'] == 'update_admin_info') {
    $result = $admin->updateAdminInfo($data,$_FILES);
    if ($result) {
        $_SESSION['Msg'] = "Admin information updated successfully ";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'admin-profile.php');
    } else {
        $_SESSION['Msg'] = "Email address does not found!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'forgot-password.php');
    }
} elseif ($data['type'] == 'logout') {
    if($_SESSION['user_role'] == '2' || $_SESSION['user_role'] == '3') {
        $result = $user->teacherLoginRecordUpdate($_SESSION['teacher_login_record_id']);
    }
    session_unset();
    session_destroy();
    header('Location: ' . BASE_ROOT);
} else {
    header("Location: ". BASE_ROOT);
}
?>
