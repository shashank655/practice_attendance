<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/DownloadCSV.php';
$download = new DownloadCSV();
$data = $_REQUEST;
if ($data['type'] == 'download_student_csv') {
    $result = $download->DownloadStudentRecordCSV($data);
} else if ($data['type'] == 'download_teachers_csv') {
    $result = $download->DownloadTeachersRecordCSV();
} else {
    header("Location: ". BASE_ROOT.'dashboard.php');
}
?>