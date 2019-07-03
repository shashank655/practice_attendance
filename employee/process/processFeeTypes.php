<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/FeeTypes.php';
$fee_types = new FeeTypes();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $fee_types->addFeeTypes($data);
    if ($result) {
        $_SESSION['Msg'] = "Fee Type added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'fee-types-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'fee-types-list.php');
    }
}  else if ($_POST['type'] == 'Update' && $_POST['feeTypeId'] != NULL) {
    $result = $fee_types->feeTypeInfoUpdate($_POST);
    if ($result) {
        $_SESSION['Msg'] = "Fee Type updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'fee-types-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'fee-types-list.php');
    }    
} else if ($data['type'] == 'deleteFeeTypes') {
    $result = $fee_types->deleteFeeTypes($data['id']);
    if ($result) {
        $_SESSION['Msg'] = "Fee Types deleted successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'fee-types-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'fee-types-list.php');
    }   
} else {
    header("Location: ". BASE_ROOT);
}
?>
