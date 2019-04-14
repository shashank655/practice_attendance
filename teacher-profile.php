<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Teacher.php'; 
require_once 'employee/class/CommonFunction.php'; 
$common_function=new CommonFunction(); 
$teacher = new Teacher(); 
$userId = (isset($_REQUEST['userId'])) ? $_REQUEST['userId'] : NULL; 
if ($userId != NULL) { $result = $teacher->getTeacherInfo($userId); 
    if ($result == NULL) { $userId = ''; } }
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
							<h5 class="text-uppercase">Teacher Profile</h5>
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
                                            if(!empty($result[0]['profile_image'])) {
                                                $imageData = PROFILE_PIC_IMAGE_PATH . $result[0]['profile_image'];
                                            } else {
                                                $imageData = 'assets/img/user.jpg';
                                            }
                                        ?>
                                        <a href=""><img class="avatar" src="<?php echo $imageData; ?>" alt=""></a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0"><?php echo $result[0]['first_name'].' '.$result[0]['last_name']?></h3>
                                                <h5 class="company-role m-t-0 m-b-0">Preschool</h5>
                                                <div class="staff-id">Teacher NO : <?php echo $result[0]['teacher_id'];?></div>
											</div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <span class="title">Phone:</span>
                                                    <span class="text"><a href=""><?php echo $result[0]['mobile_number'];?></a></span>
                                                </li>
                                                <li>
                                                    <span class="title">Email:</span>
                                                    <span class="text"><a href=""><?php echo $result[0]['email_address'];?></a></span>
                                                </li>
                                                <li>
                                                    <span class="title">Birthday:</span>
                                                    <span class="text"><?php echo $result[0]['dob'];?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Address:</span>
                                                    <span class="text"><?php echo $result[0]['permanent_address'];?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Gender:</span>
                                                    <span class="text"><?php echo $result[0]['gender'];?></span>
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