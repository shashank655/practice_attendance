<?php
require_once '../class/dbclass.php'; 
require_once '../config/config.php';
require_once '../class/TeacherModel.php';
$teachers = new TeacherModel();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $teachers->assignTeacher($data);
    if ($result) {
        $_SESSION['Msg'] = "Assign Teacher successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'/teachers.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'/teachers.php');
    }
} else {
    header("Location: ". BASE_ROOT);
}
?>
