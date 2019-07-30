<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/SendSMS.php';
$send_sms = new SendingSMS;
$data = $_REQUEST;
if ($data['type'] == 'send_sms') {   
    $res = $send_sms->sendSMS($data);
    if ($res) {
        $_SESSION['Msg'] = "SMS sent successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'holidays.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'holidays.php');
    } 
} else {
    header('Location: ' . BASE_ROOT.'holidays.php');
}
?>