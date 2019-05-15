<?php
@session_start();
define("DB_SERVER", "localhost");
define("DB_DATABASE", "practice");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "admin");
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']."/practice/");
define("ROOT", 'http://'.$_SERVER['HTTP_HOST'].'/practice/employee/');
define("BASE_ROOT",'http://'.$_SERVER['HTTP_HOST'].'/practice/');
define("PROFILE_PIC_IMAGE_ROOT",$_SERVER['DOCUMENT_ROOT']."/practice/employee/upload/");
define("PROFILE_PIC_IMAGE_PATH",ROOT."upload/");
?>