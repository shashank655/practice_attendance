<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/StudentMarks.php';
$student_marks = new StudentMarks();
$data = $_REQUEST;
if ($data['type'] == 'student_marks') {
    $result = $student_marks->addingStudentsMarks($data);
    if ($result) {
        $_SESSION['Msg'] = "Subject Marks added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'select-exam-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'select-exam-list.php');
    } 
} else if($data['type'] == 'get_student_marks') {
        $getData = $student_marks->getStudentsMarks($data['examTermId'],$data['student_id']);
        echo json_encode($getData);
} else {
    header("Location: ". BASE_ROOT.'dashboard.php');
}
?>
