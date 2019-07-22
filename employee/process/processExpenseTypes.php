<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/ExpenseTypes.php';
$expenses = new ExpenseTypes();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $expenses->addExpenseType($data);
    if ($result) {
        $_SESSION['Msg'] = "Expense Type added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'expense-types-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'expense-types-list.php');
    }
}  else if ($_POST['type'] == 'Update' && $_POST['expenseId'] != NULL) {
    $result = $expenses->expenseTypeInfoUpdate($_POST);
    if ($result) {
        $_SESSION['Msg'] = "Expense Type updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'expense-types-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'expense-types-list.php');
    }    
} else if ($data['type'] == 'deleteExpenseType') {
    $result = $expenses->deleteExpenseType($data['id']);
    if ($result) {
        $_SESSION['Msg'] = "Expense Type deleted successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'expense-types-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'expense-types-list.php');
    }   
} else {
    header("Location: ". BASE_ROOT);
}
?>
