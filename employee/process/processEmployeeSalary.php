<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/EmployeeSalary.php';
$employee_salary = new EmployeeSalary();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $employee_salary->addEmployeeSalary($data);
    if ($result) {
        $_SESSION['Msg'] = "Employee Salary added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'employee-salary.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'employee-salary.php');
    }
} else if ($_POST['type'] == 'Update' && $_POST['salaryId'] != NULL) {
    $result = $employee_salary->employeeSalaryInfoUpdate($_POST);
    if ($result) {
        $_SESSION['Msg'] = "Employee Salary updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'employee-salary.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'employee-salary.php');
    }    
} else if ($_POST['type'] == 'assign_leave_status' && $_POST['leaveId'] != NULL) {
    $result = $leaves->assignLeaveStatus($data);
    if ($result) {
        $_SESSION['Msg'] = "Leave Status updated successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'leave-requests-list.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'subject-lists.php');
    }    
} else if ($_POST['type'] == 'insertData' && $_POST['title'] != NULL) {
    $result = $events->eventsInsertData($_POST);
    if ($result) {
        header('Location: ' . BASE_ROOT.'events.php');
    }    
} else if ($_POST['type'] == 'insertFormData' && $_POST['title'] != NULL) {
    $result = $events->eventsInsertFormData($_POST);
    if ($result) {
        header('Location: ' . BASE_ROOT.'events.php');
    }    
} else if ($_POST['type'] == 'updateEvent' && $_POST['id'] != NULL ){
    $sectionData = $events->updateEvent($_POST);
    return true;
} else if ($data['type'] == 'adminClickNotification'){
    $result = $leaves->adminClickNotification();
    if ($result) {
            if($_SESSION['user_role'] == '1') {
                header('Location: ' . BASE_ROOT.'leave-requests-list.php');
            } else {
                header('Location: ' . BASE_ROOT.'request-leave-list.php');
            }
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        if($_SESSION['user_role'] == '1') {
            header('Location: ' . BASE_ROOT.'leave-requests-list.php');
        } else {
            header('Location: ' . BASE_ROOT.'request-leave-list.php');
        }
    } 
} else if ($data['type'] == 'deleteLeaves') {
    $result = $leaves->deleteLeaves($data['id']);
    if ($result) {
        $_SESSION['Msg'] = "Leave type deleted successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'leaves-types.php');
    } else {
        $_SESSION['Msg'] = "Something went wrong!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'leaves-types.php');
    }   
} else {
    header("Location: ". BASE_ROOT.'dashboard.php');
}
?>
