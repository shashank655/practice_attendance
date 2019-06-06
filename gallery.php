<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Contacts.php'; 
$contacts=new Contacts(); 

$search = (isset($_REQUEST['search'])) ? $_REQUEST['search'] : NULL; 
    if($search == 'students') {
        $resultData = $contacts->getAllTeachersList($search);
    } else if($search == 'parents') {
        $resultData = $contacts->getAllTeachersList($search);
    } else if($search == '') {
        $resultData = $contacts->getAllTeachersList($search);
    }
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
								<li class="list-inline-item"><a href="#">Pages</a></li>
								<li class="list-inline-item"> Gallery</li>
							</ul>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-sm-4 col-5">
                        
                    </div>
                    <div class="col-sm-8 col-7 text-right m-b-30">
                        <a href="add-employee-salary.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Gallery</a>
                    </div>
                </div>
                <div id="lightgallery" class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 m-b-20">
                        <a href="assets/img/blog/blog-01.jpg">
                            <img class="img-thumbnail" src="assets/img/blog/blog-01.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 m-b-20">
                        <a href="assets/img/blog/blog-02.jpg">
                            <img class="img-thumbnail" src="assets/img/blog/blog-02.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 m-b-20">
                        <a href="assets/img/blog/blog-03.jpg">
                            <img class="img-thumbnail" src="assets/img/blog/blog-03.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 m-b-20">
                        <a href="assets/img/blog/blog-04.jpg">
                            <img class="img-thumbnail" src="assets/img/blog/blog-04.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 m-b-20">
                        <a href="assets/img/blog/blog-01.jpg">
                            <img class="img-thumbnail" src="assets/img/blog/blog-01.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 m-b-20">
                        <a href="assets/img/blog/blog-02.jpg">
                            <img class="img-thumbnail" src="assets/img/blog/blog-02.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 m-b-20">
                        <a href="assets/img/blog/blog-03.jpg">
                            <img class="img-thumbnail" src="assets/img/blog/blog-03.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 m-b-20">
                        <a href="assets/img/blog/blog-04.jpg">
                            <img class="img-thumbnail" src="assets/img/blog/blog-04.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 m-b-20">
                        <a href="assets/img/blog/blog-01.jpg">
                            <img class="img-thumbnail" src="assets/img/blog/blog-01.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 m-b-20">
                        <a href="assets/img/blog/blog-02.jpg">
                            <img class="img-thumbnail" src="assets/img/blog/blog-02.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 m-b-20">
                        <a href="assets/img/blog/blog-03.jpg">
                            <img class="img-thumbnail" src="assets/img/blog/blog-03.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 m-b-20">
                        <a href="assets/img/blog/blog-04.jpg">
                            <img class="img-thumbnail" src="assets/img/blog/blog-04.jpg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>