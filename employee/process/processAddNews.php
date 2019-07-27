<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/GlobalNews.php';
$global_news = new GlobalNews;
$data = $_REQUEST;
if ($data['type'] == 'assign_global_news') {   
    $res = $global_news->AddNews($data);
    if ($res) {
        $_SESSION['Msg'] = "News added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'dashboard.php');
    } else {
        $_SESSION['Msg'] = "Exam Type already added!";
        $_SESSION['success'] = false;
        header('Location: ' . BASE_ROOT.'dashboard.php');
    } 
} else {
    header('Location: ' . BASE_ROOT.'dashboard.php');
}
?>