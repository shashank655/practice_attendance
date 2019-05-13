<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/StudentAttendance.php';
require_once '../class/CommonFunction.php';
$student_attendance = new StudentAttendance();
$data = $_REQUEST;
if ($data['type'] == 'student_attendance') {
    $result = $student_attendance->addingStudentsAttendance($data);
    if ($result) {
        $_SESSION['Msg'] = "Attendance marked successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'student-attendance-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'student-attendance-list.php');
    } 
} else {
    header("Location: ". BASE_ROOT.'dashboard.php');
}
?>
