<?php
require_once '../../employee/class/dbclass.php'; 
require_once '../../employee/config/config.php';
require_once '../models/Teacher.php';
$teachers = new Teacher();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $teachers->assignTeacher($data);
    if ($result) {
        $_SESSION['Msg'] = "Assign Teacher successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'/assign-teacher/all-teachers.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'/assign-teacher/all-teachers.php');
    }
} else {
    header("Location: ". BASE_ROOT);
}
?>
