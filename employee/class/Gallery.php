<?php
class Gallery extends MySQLCN {

    function addGallery() {
        foreach ($_FILES['gallery_images']['name'] as $key => $value) {
                if ($_FILES['gallery_images']['error'][$key] == '0') {
                    $galleryName = time() . strtolower(basename($_FILES['gallery_images']['name'][$key]));
                    $target = GALLERY_UPLOADS_ROOT . $galleryName;
                    move_uploaded_file($_FILES['gallery_images']['tmp_name'][$key], $target);
                } else {
                    $galleryName = '';
                }
                    $qry = "INSERT INTO `gallery_uploads` 
                    ( `galleryName`) 
                    VALUES 
                    ( '{$galleryName}')";
                    $res = $this->insert($qry);   
            }
        return true;    
    }

    function getAllGalleryList() {
        $fetch = "SELECT * FROM `gallery_uploads`";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }
}
?>