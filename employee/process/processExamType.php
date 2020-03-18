<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/ExamType.php';
$exam_type = new ExamType();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $exam_type->addExamType($data);
    if ($result) {
        $_SESSION['Msg'] = "Exam Type added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'exam-types-lists.php');
    } else {
        $_SESSION['Msg'] = "Exam Type already added!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'exam-types-lists.php');
    }
}  else if ($_POST['type'] == 'Update' && $_POST['examTypeId'] != NULL) {
    $result = $exam_type->examTypeInfoUpdate($_POST);
    if ($result) {
        $_SESSION['Msg'] = "Exam Type updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'exam-types-lists.php');
    } else {
        $_SESSION['Msg'] = "Exam Type already added!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'exam-types-lists.php');
    }    
} else if ($data['type'] == 'deleteExamType') {
    $result = $exam_type->deleteExamType($data['id']);
    if ($result) {
        $_SESSION['Msg'] = "Exam Type deleted successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'exam-types-lists.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'subject-lists.php');
    }   
} else if ($data['type'] == 'AddExamTerm') {
    $result = $exam_type->addExamTerm($data);
    if ($result) {
        $_SESSION['Msg'] = "Exam Term added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'manage-exam-terms-lists.php');
    } else {
        $_SESSION['Msg'] = "This Exam Term already added!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'manage-exam-terms-lists.php');
    }
} else if ($data['type'] == 'deleteExamTerm') {
    $result = $exam_type->deleteExamTerm($data['id']);
    if ($result) {
        $_SESSION['Msg'] = "Exam Term deleted successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'manage-exam-terms-lists.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'manage-exam-terms-lists.php');
    }   
} else if ($_POST['type'] == 'UpdateExamTerm' && $_POST['examTermId'] != NULL) {
    $result = $exam_type->examTermInfoUpdate($_POST);
    if ($result) {
        $_SESSION['Msg'] = "Exam Type updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'manage-exam-terms-lists.php');
    } else {
        $_SESSION['Msg'] = "This Exam Term already added!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'manage-exam-terms-lists.php');
    }    
} else if ($_POST['type'] == 'getExamTerm' && $_POST['examTypeID'] != NULL ){
    $result = $exam_type->getExamTermList($_POST['examTypeID']);
    echo json_encode($result);
    exit;
} else if ($_POST['type'] == 'getExamsSubjects' && $_POST['sectionID'] != NULL ){
    $result = $exam_type->getExamsSubjectsList($_POST['sectionID']);
    echo json_encode($result);
    exit;
} else if ($_POST['type'] == 'getExamNameList' && $_POST['examTypeID'] != NULL && $_POST['classId'] != NULL && $_POST['sectionId'] != NULL ){
    $result = $exam_type->getExamNameList($_POST['examTypeID'],$_POST['classId'],$_POST['sectionId']);
    echo json_encode($result);
    exit;
} else {
    header("Location: ". BASE_ROOT);
}
?>
