<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Student.php';
require_once '../class/CommonFunction.php';
$student = new Student();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $student->StudentSignUp($data,$_FILES);
    if ($result) {
        $_SESSION['Msg'] = "Student added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'add-student.php');
    } else {
        $_SESSION['Msg'] = "Student admission number already exist!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'add-student.php');
    } 
} else if ($_POST['type'] == 'Update' && $_POST['studentId'] != NULL) {
    $result = $student->StudentInfoUpdate($_POST,$_FILES);
    if ($result) {
        $_SESSION['Msg'] = "Student information updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'add-student.php');
    } else {
        $_SESSION['Msg'] = "Student admission number already exist!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'add-student.php');
    }    
} else if ($data['type'] == 'delete' && $data['studentId'] != NULL) {
    $res = $student->DeleteStudent($data['studentId']);
    $_SESSION['Msg'] = "Student Deleted successfully!";
    $_SESSION['success'] = false;
    header('Location: ' . BASE_ROOT.'all-students.php');
} else if ($_POST['type'] == 'getSection' && $_POST['classID'] != NULL ){
    $common_function = new CommonFunction();
    $sectionData = $common_function->getSectionList($_POST['classID']);
    echo json_encode($sectionData);
    exit;
} else if ($data['type'] == 'addAdmissionStudent' && $data['admissionNo'] != NULL) {
    $result = $student->AddAdmissionStudent($data);
    if ($result['status']) {
        $_SESSION['Msg'] = "Student added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'admission-form-listing.php');
    } else {
        $_SESSION['Msg'] = $result['message'];
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'admission-form-listing.php');
    } 
} else if ($data['type'] == 'cancelAdmissionForms' && $data['admissionNo'] != NULL) {
    $res = $student->cancelAdmissionForms($data);
    $_SESSION['Msg'] = "Admission Form cancelled successfully!";
    $_SESSION['success'] = true;
    header('Location: ' . BASE_ROOT.'admission-form-listing.php');
} else if ($_POST['type'] == 'isCheckAdmissionNo' && $_POST['admissionNo'] != NULL) {
    $res = $student->isCheckAdmissionNo();
    echo $res;exit;
} else if ($_POST['type'] == 'isCheckParentEmail' && $_POST['parentEmail'] != NULL) {
    $res = $student->isCheckParentEmail();
    echo $res;exit;
} else {
    header("Location: ". BASE_ROOT);
}
?>
