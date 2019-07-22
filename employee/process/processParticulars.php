<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Particulars.php';
$fees = new Particulars();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $fees->addParticular($data);
    if ($result) {
        $_SESSION['Msg'] = "Particular added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'particulars-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'particulars-list.php');
    }
}  else if ($_POST['type'] == 'Update' && $_POST['feeId'] != NULL) {
    $result = $fees->particularInfoUpdate($_POST);
    if ($result) {
        $_SESSION['Msg'] = "Particular updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'particulars-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'particulars-list.php');
    }    
} else if ($data['type'] == 'deleteParticulars') {
    $result = $fees->deleteParticulars($data['id']);
    if ($result) {
        $_SESSION['Msg'] = "Particular deleted successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'particulars-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'particulars-list.php');
    }   
} else {
    header("Location: ". BASE_ROOT);
}
?>
