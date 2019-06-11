<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Events.php';
$events = new Events();
$data = $_REQUEST;
if ($data['type'] == 'loadData') {
    $result = $events->eventsLoadData($data);
    echo json_encode($result);
} else if ($data['type'] == 'loadEventsHolidaysData') {
    $result = $events->eventsLoadEventsHolidaysData($data);
    echo json_encode($result);
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
