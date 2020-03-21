<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/SessionTerms.php';
$sessionTerms = new SessionTerms();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $sessionTerms->addSessionTerm($data);
    if ($result) {
        $_SESSION['Msg'] = "Session Terms added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'session-terms-list.php');
    } else {
        $_SESSION['Msg'] = "This Session terms already exist!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'session-terms-list.php');
    }
} else if ($_POST['type'] == 'Update' && $_POST['sessionId'] != NULL) {
    $result = $sessionTerms->sessionTermInfoUpdate($_POST);
    if ($result) {
        $_SESSION['Msg'] = "Session Terms updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'session-terms-list.php');
    }     
} else if ($data['type'] == 'deleteSession') {
    $result = $sessionTerms->deleteSession($data['id']);
    if ($result) {
        $_SESSION['Msg'] = "Session deleted successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'session-terms-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'class-section-list.php');
    }   
} else {
    header("Location: ". BASE_ROOT);
}
?>
