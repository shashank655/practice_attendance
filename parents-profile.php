<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Student.php'; 
require_once 'employee/class/CommonFunction.php'; 
$common_function=new CommonFunction(); 
$student = new Student(); 
$userId = (isset($_REQUEST['userId'])) ? $_REQUEST['userId'] : NULL; 
if ($userId != NULL) { $result = $student->getStudentInfo($userId); 
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
							<h5 class="text-uppercase">Parents Profile</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="#">Home</a></li>
								<li class="list-inline-item"><a href="dashboard.php">Dashboard</a></li>
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
                                            if(!empty($result[0]['student_profile_image'])) {
                                                $imageData = PROFILE_PIC_IMAGE_PATH . $result[0]['student_profile_image'];
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
                                                <div class="staff-id">Class : <?php if(isset($result[0]['class_name'])){echo $result[0]['class_name'];} ?></div>
                                                <div class="staff-id">Section : <?php if(isset($result[0]['class_name'])){echo $result[0]['section_name'];}?></div>
                                                <div class="staff-id">Admission No. : <?php echo $result[0]['admission_no'];?></div>

                                                <div class="staff-id">Father's Name: <?php echo $result[0]['fathers_name'];?></div>
                                                <div class="staff-id">Father's occupation : <?php echo $result[0]['fathers_occupation'];?></div>
                                                </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <span class="title">Phone:</span>
                                                    <span class="text"><?php echo $result[0]['parents_mobile_number'];?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Parents Email:</span>
                                                    <span class="text"><?php echo $result[0]['parents_email_address'];?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Birthday:</span>
                                                    <span class="text"><?php echo $result[0]['dob'];?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Permanent Address:</span>
                                                    <span class="text"><?php echo $result[0]['permanent_address'];?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Mother's Name:</span>
                                                    <span class="text"><?php echo $result[0]['mothers_name'];?></span>
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
    <script type="text/javascript">
        $(function(){
        $("#addProfilePic").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                profile_image:{
                    required:true
                }
            }
        });
    });
    </script>