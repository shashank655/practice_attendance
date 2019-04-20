<?php
@session_start();
define("DB_SERVER", "localhost");
define("DB_DATABASE", "practice");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']."/school_dashboard/");
define("ROOT", 'http://'.$_SERVER['HTTP_HOST'].'/school_dashboard/employee/');
define("BASE_ROOT",'http://'.$_SERVER['HTTP_HOST'].'/school_dashboard/');
define("PROFILE_PIC_IMAGE_ROOT",$_SERVER['DOCUMENT_ROOT']."/school_dashboard/employee/upload/");
define("PROFILE_PIC_IMAGE_PATH",ROOT."upload/");
?>