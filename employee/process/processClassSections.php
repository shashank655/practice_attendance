<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/ClassSections.php';
$classes = new ClassSections();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $classes->addClasses($data);
    if ($result) {
        $_SESSION['Msg'] = "Class and Section added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'class-section-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'class-section-list.php');
    }
} else if ($_POST['type'] == 'Update' && $_POST['classId'] != NULL) {
    $result = $classes->classInfoUpdate($_POST);
    if ($result) {
        $_SESSION['Msg'] = "Class and Section updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'class-section-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'class-section-list.php');
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
} else if ($data['type'] == 'deleteClasses') {
    $result = $classes->deleteClasses($data['id']);
    if ($result) {
        $_SESSION['Msg'] = "Class & Sections deleted successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'class-section-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'class-section-list.php');
    }   
} else {
    header("Location: ". BASE_ROOT);
}
?>
