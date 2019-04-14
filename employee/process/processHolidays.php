<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Holidays.php';
require_once '../class/CommonFunction.php';
$holidays = new Holidays();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $holidays->AddHoliday($data);
    if ($result) {
        $_SESSION['Msg'] = "Holiday added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'holidays.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'holidays.php');
    } 
} else if ($_POST['type'] == 'Update' && $_POST['studentId'] != NULL) {
    $result = $student->StudentInfoUpdate($_POST,$_FILES);
    if ($result) {
        $_SESSION['Msg'] = "Student information updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'add-student.php');
    } else {
        $_SESSION['Msg'] = "Student Email address already exist!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'add-student.php');
    }    
} else if ($_POST['type'] == 'delete' && $_POST['holidayId'] != NULL) {
    $res = $holidays->DeleteHoliday($_POST['holidayId']);
    if ($res) {
        $_SESSION['Msg'] = "Holiday deleted successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'holidays.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'holidays.php');
    } 
} else {
    header("Location: ". BASE_ROOT);
}
?>
