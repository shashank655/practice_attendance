<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Admin.php'; 
require_once 'employee/class/CommonFunction.php'; 
$common_function=new CommonFunction(); 
$admin = new Admin(); 
$adminData = $admin->getAdminInfo($_SESSION['userId']);
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
							<h5 class="text-uppercase">my Profile</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="#">Home</a></li>
								<li class="list-inline-item"><a href="#">Pages</a></li>
								<li class="list-inline-item"> Profile</li>
							</ul>
						</div>
					</div>
				</div>
                <div class="card-box m-b-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                    <?php
                                        if (!empty($adminData[0]['admin_profile_image'])) {
                                            $userImage = PROFILE_PIC_IMAGE_PATH . $adminData[0]['admin_profile_image'];
                                        } else {
                                            $userImage = 'assets/img/user.jpg';
                                        }
                                    ?>
                                        <a href=""><img class="avatar" src="<?php echo $userImage; ?>" alt=""></a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0"><?php echo $adminData[0]['first_name'].' '.$adminData[0]['last_name']?></h3>
											</div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <span class="title">Email:</span>
                                                    <span class="text"><?php echo $adminData[0]['email_address'];?></span>
                                                </li>
                                                <li>
                                                    <span class="title">School Name:</span>
                                                    <span class="text"><?php echo $adminData[0]['school_name'];?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Phone:</span>
                                                    <span class="text"><?php echo $adminData[0]['phone_number'];?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Address:</span>
                                                    <span class="text"><?php echo $adminData[0]['address'];?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Designation:</span>
                                                    <span class="text"><?php echo $adminData[0]['designation'];?></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>