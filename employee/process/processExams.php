<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Exams.php';
$exams = new Exams();
$data = $_REQUEST;
if ($data['type'] == 'Add' && $data['class_id']!='') {
    $result = $exams->addExams($data);
    if ($result) {
        $_SESSION['Msg'] = "Exam added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'exams-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'exams-list.php');
    }
}  else if ($_POST['type'] == 'Update' && $_POST['examId'] != NULL) {
    $result = $exams->examInfoUpdate($_POST);
    if ($result) {
        $_SESSION['Msg'] = "Exam updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'exams-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'exams-list.php');
    }    
} else if ($_POST['type'] == 'insertData' && $_POST['title'] != NULL) {
    $result = $events->eventsInsertData($_POST);
    if ($result) {
        header('Location: ' . BASE_ROOT.'events.php');
    }    
} else if ($_POST['type'] == 'insertFormData' && $_POST['title'] != NULL) {
    $result = $events->eventsInsertFormData($_POST);
    if ($result) {
        header('Location: ' . BASE_ROOT.'events.php');
    }    
} else if ($_POST['type'] == 'updateEvent' && $_POST['id'] != NULL ){
    $sectionData = $events->updateEvent($_POST);
    return true;
} else if ($data['type'] == 'deleteExams') {
    $result = $exams->deleteExams($data['id']);
    if ($result) {
        $_SESSION['Msg'] = "Exam deleted successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'exams-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'exams-list.php');
    }   
} else {
    header("Location: ". BASE_ROOT);
}
?>
