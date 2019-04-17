<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Teacher.php';
require_once '../class/CommonFunction.php';
$teacher = new Teacher();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $teacher->teacherSignUp($data,$_FILES);
    if ($result) {
        $_SESSION['Msg'] = "Teacher added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'add-teacher.php');
    } else {
        $_SESSION['Msg'] = "Teacher Email address already exist!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'add-teacher.php');
    } 
} else if ($_POST['type'] == 'Update' && $_POST['userId'] != NULL) {
    $result = $teacher->teacherInfoUpdate($_POST,$_FILES);
    if ($result) {
        $_SESSION['Msg'] = "Teacher information updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'add-teacher.php');
    } else {
        $_SESSION['Msg'] = "Teacher Email address already exist!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'add-teacher.php');
    }    
} else if ($_POST['type'] == 'getSection' && $_POST['classID'] != NULL ){
    $common_function = new CommonFunction();
    $sectionData = $common_function->getSectionList($_POST['classID']);
    echo json_encode($sectionData);
    exit;
} else if ($_POST['type'] == 'isCheckEmailAddress' && $_POST['emailAddress'] != NULL) {
    $res = $teacher->isCheckEmailAddress();
    echo $res;exit;
} else if ($_POST['type'] == 'assign_teacher_password' && $_POST['password'] != NULL) {
    $res = $teacher->assignTeacherPassword($_POST);
    if ($res) {
        $_SESSION['Msg'] = "Teacher's password has been created successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'dashboard.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong, please try again!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'dashboard.php');
    }
} else {
    header("Location: ". BASE_ROOT);
}
?>
