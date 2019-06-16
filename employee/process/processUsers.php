<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Users.php';
$users = new Users();
$data = $_REQUEST;
if ($_POST['type'] == 'Update' && $_POST['userId'] != NULL) {
    $result = $users->userInfoUpdate($_POST);
    if ($result) {
        $_SESSION['Msg'] = "User updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'users-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'users-list.php');
    }    
} else {
    header("Location: ". BASE_ROOT);
}
?>
