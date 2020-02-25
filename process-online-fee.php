<?php

require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';
require_once 'employee/class/CCAvenue.php';
require_once 'employee/class/Optional.php';

$accounts = new Accounts();
$type = $accounts->processOnlinePayment($_POST);
if ($type) {
    $accounts->redirect(BASE_ROOT . $type . '-fee-list.php');
} else {
    $accounts->redirect(BASE_ROOT . 'dashboard.php');
}
