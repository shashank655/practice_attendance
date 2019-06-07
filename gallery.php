<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Gallery.php'; 
$gallery=new Gallery(); 
    $resultData = $gallery->getAllGalleryList();
?>

<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php'; 
?>
<div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
                <div class="page-header">
					<div class="row">
						<div class="col-lg-7 col-md-12 col-sm-12 col-12">
							<h5 class="text-uppercase">gallery</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="#">Home</a></li>
								<li class="list-inline-item"> Gallery</li>
							</ul>
						</div>
					</div>
				</div>
                <?php if($_SESSION['user_role'] == '1') { ?>
                <div class="row">
                    <div class="col-sm-4 col-5">
                        
                    </div>
                    <div class="col-sm-8 col-7 text-right m-b-30">
                        <a href="#" class="btn btn-primary btn-rounded float-right" data-toggle="modal" data-target="#add_gallery"><i class="fa fa-plus"></i> Add Gallery</a>
                    </div>
                </div>
                <?php } ?>
                <div id="lightgallery" class="row">
                <?php foreach ($resultData as $key => $value) { ?>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 m-b-20">
                        <a href="<?php if (isset($value['galleryName'])) echo GALLERY_UPLOADS_PATH . $value['galleryName']; ?>">
                            <img class="img-thumbnail" src="<?php if (isset($value['galleryName'])) echo GALLERY_UPLOADS_PATH . $value['galleryName']; ?>" alt="">
                        </a>
                    </div>
                <?php } ?>    
                </div>
            </div>
        </div>
    </div>
    <div id="add_gallery" class="modal" role="dialog">
            <div class="modal-dialog">
                
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Holiday</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="addGallery" action="employee/process/processGallery.php" method="post" enctype="multipart/form-data" novalidate="novalidate">
                            <input type="hidden" name="type" value="Add" />
                            <div class="form-group custom-mt-form-group">
                                <input type="file" multiple="multiple" name="gallery_images[]" id="gallery_images" style="margin-bottom:10px;">
                                <label class="control-label">Add Gallery <span class="text-danger">*</span></label><i class="bar"></i>
                            </div>
                            <div class="m-t-20 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Add Gallery</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php require_once 'includes/footer.php'; ?>