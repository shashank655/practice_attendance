<?php
@session_start();
define("DB_SERVER", "127.0.0.1");
define("DB_DATABASE", "upglobalschool");
define("DB_USERNAME", "upglobalschool");
define("DB_PASSWORD", "upglobalschool");
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']."/");
define("ROOT", 'http://'.$_SERVER['HTTP_HOST'].'/employee/');
define("BASE_ROOT",'http://'.$_SERVER['HTTP_HOST'].'/');
define("PROFILE_PIC_IMAGE_ROOT",$_SERVER['DOCUMENT_ROOT']."/employee/upload/");
define("PROFILE_PIC_IMAGE_PATH",ROOT."upload/");
define("LEAVE_ATTACHMENT",ROOT."upload/leave_attachment/");
define("GALLERY_UPLOADS_ROOT",$_SERVER['DOCUMENT_ROOT']."/employee/upload/gallery_uploads/");
define("GALLERY_UPLOADS_PATH",ROOT."upload/gallery_uploads/");

define("LEAVES_ATTACHMENT_ROOT",$_SERVER['DOCUMENT_ROOT']."/employee/upload/request_leaves/");
define("LEAVES_ATTACHMENT_PATH",ROOT."upload/request_leaves/");

define("PDF_ATTACHMENT_ROOT",$_SERVER['DOCUMENT_ROOT']."/employee/upload/pdf_attachments/");
define("PDF_ATTACHMENT_PATH",ROOT."upload/pdf_attachments/");

define("UPLOAD_CSV_PATH",ROOT."upload/upload_csv/");
define("UPLOAD_CSV_ROOT",$_SERVER['DOCUMENT_ROOT']."/employee/upload/upload_csv/");

define("TEACHERS_EXPIRY_TIME","2000");

define('CCAvenueTestMode', false);

define('CCAvenueTestMerchantID', '');
define('CCAvenueTestAccessCode', '');
define('CCAvenueTestWorkingKey', '');

define('CCAvenueMerchantID', '');
define('CCAvenueAccessCode', '');
define('CCAvenueWorkingKey', '');

define('MinavoVSMSAuthKey', '');
define('MinavoVSMSSenderId', '');
