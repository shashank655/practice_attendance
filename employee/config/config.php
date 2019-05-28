<?php
@session_start();
define("DB_SERVER", "localhost");
define("DB_DATABASE", "practice");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']."/practice_attendance/");
define("ROOT", 'http://'.$_SERVER['HTTP_HOST'].'/practice_attendance/employee/');
define("BASE_ROOT",'http://'.$_SERVER['HTTP_HOST'].'/practice_attendance/');
define("PROFILE_PIC_IMAGE_ROOT",$_SERVER['DOCUMENT_ROOT']."/practice_attendance/employee/upload/");
define("PROFILE_PIC_IMAGE_PATH",ROOT."upload/");
define("LEAVE_ATTACHMENT",ROOT."upload/leave_attachment/");
?>