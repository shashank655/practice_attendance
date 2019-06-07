<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Gallery.php';
$gallery = new Gallery();
$data = $_REQUEST;
if ($data['type'] == 'Add') {
    $result = $gallery->addGallery();
    if ($result) {
        $_SESSION['Msg'] = "Gallery added successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'gallery.php');
    } 
}  else {
    header("Location: ". BASE_ROOT.'dashboard.php');
}
?>
