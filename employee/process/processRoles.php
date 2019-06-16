<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Roles.php';
$roles = new Roles();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $roles->addRoles($data);
    if ($result) {
        $_SESSION['Msg'] = "Role added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'roles-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'roles-list.php');
    }
}  else if ($_POST['type'] == 'Update' && $_POST['roleId'] != NULL) {
    $result = $roles->roleInfoUpdate($_POST);
    if ($result) {
        $_SESSION['Msg'] = "Role updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'roles-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'roles-list.php');
    }    
} else if ($data['type'] == 'deleteRoles') {
    $result = $roles->deleteRoles($data['id']);
    if ($result) {
        $_SESSION['Msg'] = "Role deleted successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'roles-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'roles-list.php');
    }   
} else {
    header("Location: ". BASE_ROOT);
}
?>
