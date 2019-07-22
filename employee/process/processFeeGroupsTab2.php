<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/FeeGroups.php';
$fees = new FeeGroups();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $fees->addFeeGroupTab2($data);
    if ($result) {
        $_SESSION['Msg'] = "Fee group added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'fee-groups-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'fee-groups-list.php');
    }
}  else if ($_POST['type'] == 'Update' && $_POST['feeId'] != NULL) {
    $result = $fees->feeGroupInfoUpdateTab2($_POST);
    if ($result) {
        $_SESSION['Msg'] = "Fee Group updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'fee-groups-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'fee-groups-list.php');
    }    
} else if ($data['type'] == 'deleteFeeClassGroupsTab2') {
    $result = $fees->deleteFeeGroupsTab2($data['id']);
    if ($result) {
        $_SESSION['Msg'] = "Fee groups deleted successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'fee-groups-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'fee-groups-list.php');
    }   
} else {
    header("Location: ". BASE_ROOT);
}
?>
