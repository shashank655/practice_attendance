<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/UploadCSV.php';
$upload_csv = new UploadCSV();
$data = $_REQUEST;
if ($data['type'] == 'upload_student_csv') {
    $result = $upload_csv->UploadStudentRecordCSV($data);
} else if ($data['type'] == 'download_teachers_csv') {
    $result = $upload_csv->DownloadTeachersRecordCSV();
} else {
    header("Location: ". BASE_ROOT.'dashboard.php');
}
?>