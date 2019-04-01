<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Teacher.php';
$teacher = new Teacher();
$data = $_REQUEST;
if ($data['type'] == 'teacher_sign_up') {
    $result = $teacher->teacherSignUp($data,$_FILES);
    if ($result) {
        $_SESSION['Msg'] = "Teacher added successfully!";
        header('Location: ' . BASE_ROOT.'add-teacher.php');
    } else {
        $_SESSION['Msg'] = "Teacher Email address already exist!";
        header('Location: ' . BASE_ROOT.'add-teacher.php');
    } 
} else if ($data['type'] == 'super_admin_signup') {
    $result = $user->userRegistration($data);
    if ($result) {
        $_SESSION['Msg'] = "Sign up successfully";
        header('Location: ' . BASE_ROOT);
    } else {
        $_SESSION['Msg'] = "Email address already exist , please login!";
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
