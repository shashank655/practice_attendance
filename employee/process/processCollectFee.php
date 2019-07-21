<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/CollectFees.php';
require_once '../class/FeeGroups.php';
$feeGroup = new FeeGroups;
$collectFees = new CollectFees();
$data = $_REQUEST;
if ($data['feeCollectId'] != '') {   
    $res = $collectFees->updateFees($data);
    if ($res) {
        $feeGroupFees = $feeGroup->getFeeGroupFees($data['fee_group_id']);
        $deleted = $collectFees->removeOldCollectFeeDetails($data['feeCollectId']);
        foreach($feeGroupFees as $amount) { 
            $discount = $feeGroup->calculateDiscount($data['particular_id'], $amount['fee_amount_id'], $amount['amount']);
            $result = $collectFees->updateCollectFeeDetails($amount, $data['feeCollectId'], $discount);
        }
    }
    if ($result) {
        $_SESSION['Msg'] = "Fee Collected updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'fee-collection-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'fee-collection-list.php');
    } 
} else {
    $last_id = $collectFees->submitFees($data);
    if ($last_id) {
        $feeGroupFees = $feeGroup->getFeeGroupFees($data['fee_group_id']);
        foreach($feeGroupFees as $amount) { 
            $discount = $feeGroup->calculateDiscount($data['particular_id'], $amount['fee_amount_id'], $amount['amount']);
            $result = $collectFees->submitCollectFeeDetails($amount, $last_id, $discount);
        }
    }
    if ($result) {
        $_SESSION['Msg'] = "Fee Collected successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'fee-collection-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'fee-collection-list.php');
    } 
}
?>