<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Admissions.php';
$admissions = new Admissions();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $admissions->addAdmissions($data,$_FILES);
    if ($result) {
        $_SESSION['Msg'] = "Admission added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'admission-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'admission-list.php');
    }
}  else if ($_POST['type'] == 'Update' && $_POST['admissionId'] != NULL) {
    $result = $admissions->admissionInfoUpdate($_POST,$_FILES);
    if ($result) {
        $_SESSION['Msg'] = "Admission updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'admission-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'admission-list.php');
    }    
} else if ($data['type'] == 'deleteAdmission') {
    $result = $admissions->deleteAdmission($data['id']);
    if ($result) {
        $_SESSION['Msg'] = "Admission deleted successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'admission-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'admission-list.php');
    }   
} else if ($_POST['type'] == 'getSection' && $_POST['classID'] != NULL ){
    $common_function = new CommonFunction();
    $sectionData = $common_function->getSectionList($_POST['classID']);
    echo json_encode($sectionData);
    exit;
} else {
    header("Location: ". BASE_ROOT);
}
?>
