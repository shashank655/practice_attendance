<?php
@require_once 'config/config.php';
if (!isset($_SESSION['adminId'])) {
    header('Location:' . BASE_ROOT);
} 
?>
<!DOCTYPE html>
<html lang="en">    
    <head>
        <title>Send SMS Admin</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="css/fullcalendar.css" />	
        <link rel="stylesheet" href="css/unicorn.main.css" />
        <link rel="stylesheet" href="css/unicorn.grey.css" class="skin-color" />                
		<link rel="stylesheet" href="css/uniform.css" />
		<link rel="stylesheet" href="css/select2.css" />
        <link rel="stylesheet" href="css/datepicker.css" />
        <link rel="stylesheet" href="css/timepicker.css" />
    </head>
    <body>
        <div id="header">
        <span>Send SMS</span>
            <a href="index.php"><h1>Send SMS Admin</h1></a>		
        </div>        
        <div id="user-nav" class="navbar navbar-inverse">
            <ul class="nav btn-group">                                
                <li class="btn btn-inverse"><a title="" href="process/processUser.php?type=logout"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
            </ul>
        </div>