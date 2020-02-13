<?php
@session_start();
define("DB_SERVER", "localhost");
define("DB_DATABASE", "practice");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "123456");
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']."/practice_attendance/");
define("ROOT", 'http://'.$_SERVER['HTTP_HOST'].'/practice_attendance/employee/');
define("BASE_ROOT",'http://'.$_SERVER['HTTP_HOST'].'/practice_attendance/');
define("PROFILE_PIC_IMAGE_ROOT",$_SERVER['DOCUMENT_ROOT']."/practice_attendance/employee/upload/");
define("PROFILE_PIC_IMAGE_PATH",ROOT."upload/");
define("LEAVE_ATTACHMENT",ROOT."upload/leave_attachment/");
define("GALLERY_UPLOADS_ROOT",$_SERVER['DOCUMENT_ROOT']."/practice_attendance/employee/upload/gallery_uploads/");
define("GALLERY_UPLOADS_PATH",ROOT."upload/gallery_uploads/");

define("LEAVES_ATTACHMENT_ROOT",$_SERVER['DOCUMENT_ROOT']."/practice_attendance/employee/upload/request_leaves/");
define("LEAVES_ATTACHMENT_PATH",ROOT."upload/request_leaves/");

define("TEACHERS_EXPIRY_TIME","20");
?>