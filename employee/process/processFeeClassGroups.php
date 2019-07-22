<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/FeeClassGroup.php';
$fees = new FeeClassGroup();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $fees->addFeeClassGroup($data);
    if ($result) {
        $_SESSION['Msg'] = "Fee class group added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'fee-class-groups-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'fee-class-groups-list.php');
    }
}  else if ($_POST['type'] == 'Update' && $_POST['feeId'] != NULL) {
    $result = $fees->feeClassGroupInfoUpdate($_POST);
    if ($result) {
        $_SESSION['Msg'] = "Fee updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'fee-class-groups-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'fee-class-groups-list.php');
    }    
} else if ($data['type'] == 'deleteFeeClassGroups') {
    $result = $fees->deleteFeeClassGroups($data['id']);
    if ($result) {
        $_SESSION['Msg'] = "Fee class groups deleted successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'fee-class-groups-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'fee-class-groups-list.php');
    }   
} else {
    header("Location: ". BASE_ROOT);
}
?>
