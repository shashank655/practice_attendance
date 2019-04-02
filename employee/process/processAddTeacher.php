<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Teacher.php';
$teacher = new Teacher();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $teacher->teacherSignUp($data,$_FILES);
    if ($result) {
        $_SESSION['Msg'] = "Teacher added successfully!";
        header('Location: ' . BASE_ROOT.'add-teacher.php');
    } else {
        $_SESSION['Msg'] = "Teacher Email address already exist!";
        header('Location: ' . BASE_ROOT.'add-teacher.php');
    } 
} else if ($_POST['type'] == 'Update' && $_POST['userId'] != NULL) {
    $result = $teacher->teacherInfoUpdate($_POST,$_FILES);
    if ($result) {
        $_SESSION['Msg'] = "Teacher information updated successfully!";
        header('Location: ' . BASE_ROOT.'add-teacher.php');
    } else {
        $_SESSION['Msg'] = "Teacher Email address already exist!";
        header('Location: ' . BASE_ROOT.'add-teacher.php');
    }    
} else {
    header("Location: ". BASE_ROOT);
}
?>
