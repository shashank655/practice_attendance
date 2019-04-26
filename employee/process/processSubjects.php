<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Subjects.php';
$subjects = new Subjects();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $subjects->addSubjects($data);
    if ($result) {
        $_SESSION['Msg'] = "Subjects added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'subject-lists.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'subject-lists.php');
    }
}  else if ($_POST['type'] == 'Update' && $_POST['subjectId'] != NULL) {
    $result = $subjects->subjectInfoUpdate($_POST);
    if ($result) {
        $_SESSION['Msg'] = "Subjects name updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'subject-lists.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'subject-lists.php');
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
} else if ($_POST['type'] == 'deleteEvent' && $_POST['id'] != NULL) {
    $result = $events->eventDelete($_POST['id']);
    if ($result) {
        return true;
    }    
} else {
    header("Location: ". BASE_ROOT);
}
?>
