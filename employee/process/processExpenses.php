<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Expenses.php';
$expenses = new Expenses();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $expenses->addExpense($data);
    if ($result) {
        $_SESSION['Msg'] = "Expense added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'expenses-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'expenses-list.php');
    }
}  else if ($_POST['type'] == 'Update' && $_POST['expenseId'] != NULL) {
    $result = $expenses->expenseInfoUpdate($_POST);
    if ($result) {
        $_SESSION['Msg'] = "Expense updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'expenses-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'expenses-list.php');
    }    
} else if ($data['type'] == 'deleteExpense') {
    $result = $expenses->deleteExpense($data['id']);
    if ($result) {
        $_SESSION['Msg'] = "Expense deleted successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'expenses-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'expenses-list.php');
    }   
} else {
    header("Location: ". BASE_ROOT);
}
?>
