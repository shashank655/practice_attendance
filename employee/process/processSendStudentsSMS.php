<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/SendStudentsSMS.php';
$send_sms = new SendStudentsSMS();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $send_sms->addStudentsInfo($data);
    if ($result) {
        $_SESSION['Msg'] = "Student Information added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'students-sms-listing.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'students-sms-listing.php');
    }
} else if ($_POST['type'] == 'Update' && $_POST['studentId'] != NULL) {
    $result = $send_sms->studentInfoUpdate($_POST);
    if ($result) {
        $_SESSION['Msg'] = "Student Information updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'students-sms-listing.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'students-sms-listing.php');
    }    
} else {
    header("Location: ". BASE_ROOT.'dashboard.php');
}
?>
