<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/FeeAmounts.php';
$fee_amounts = new FeeAmounts();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $fee_amounts->addFeeAmounts($data);
    if ($result) {
        $_SESSION['Msg'] = "Fee Amount added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'fee-amounts-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'fee-amounts-list.php');
    }
}  else if ($_POST['type'] == 'Update' && $_POST['feeAmountId'] != NULL) {
    $result = $fee_amounts->feeAmountInfoUpdate($_POST);
    if ($result) {
        $_SESSION['Msg'] = "Fee Amount updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'fee-amounts-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'fee-amounts-list.php');
    }    
} else if ($data['type'] == 'deleteFeeAmounts') {
    $result = $fee_amounts->deleteFeeAmounts($data['id']);
    if ($result) {
        $_SESSION['Msg'] = "Fee Amount deleted successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'fee-amounts-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'fee-amounts-list.php');
    }   
} else {
    header("Location: ". BASE_ROOT);
}
?>
