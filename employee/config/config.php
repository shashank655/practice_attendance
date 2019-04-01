<?php
@session_start();
define("DB_SERVER", "localhost");
define("DB_DATABASE", "attendance");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']."/practice_attendance/");
define("ROOT", 'http://'.$_SERVER['HTTP_HOST'].'/practice_attendance/employee/');
define("BASE_ROOT",'http://'.$_SERVER['HTTP_HOST'].'/practice_attendance/');
?>