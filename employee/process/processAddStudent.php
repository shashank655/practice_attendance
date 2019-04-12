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
        $_SESSION['Msg'] = "Student Email address already exist!";
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
        $_SESSION['Msg'] = "Student Email address already exist!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'add-student.php');
    }    
} else if ($_POST['type'] == 'delete' && $_POST['studentId'] != NULL) {
    $res = $student->DeleteStudent($_POST['studentId']);
    echo "Student Deleted Sucessfully.";
} else if ($_POST['type'] == 'getSection' && $_POST['classID'] != NULL ){
    $common_function = new CommonFunction();
    $sectionData = $common_function->getSectionList($_POST['classID']);
    echo json_encode($sectionData);
    exit;
} else {
    header("Location: ". BASE_ROOT);
}
?>
