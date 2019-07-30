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
           <div class="chat-main-row">
                <div class="chat-main-wrapper">
                    <div class="col-lg-12 message-view">
                        <div class="chat-window">
                            <div class="fixed-header">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="page-title m-b-0 m-t-5">Contacts</h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="navbar justify-content-end">
                                            <div class="search-box m-t-0">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" placeholder="Search" required="">
                                                    <span class="input-group-append">
														<button class="btn" type="button"><i class="fa fa-search"></i></button>
													</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-contents">
                                <div class="chat-content-wrap">
                                    <div class="chat-wrap-inner">
                                        <div class="contact-box">
                                        <div class="row">
                                            <div class="contact-cat col-sm-4 col-lg-3">
                                                <div class="roles-menu m-0">
                                                    <ul>
                                                        <li class="<?php if($search ==''){echo 'active';}?>"><a href="contacts.php">Teachers</a></li>
                                                        <li class="<?php if($search =='students'){echo 'active';}?>"><a href="contacts.php?search=students">students</a></li>
                                                        <li class="<?php if($search =='parents'){echo 'active';}?>"><a href="contacts.php?search=parents">Parents</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="contacts-list col-sm-8 col-lg-9">
                                                <ul class="contact-list">
                                                    <?php if(!empty($resultData)) { ?>
                                                    <?php foreach ($resultData as $key => $value) { 
                                                        if ($search == '') {
                                                            if(!empty($value['profile_image'])) {
                                                                $imageData = PROFILE_PIC_IMAGE_PATH . $value['profile_image'];
                                                            } else {
                                                                $imageData = 'assets/img/user.jpg';
                                                            }
                                                        } else if ($search == 'students') {
                                                            if(!empty($value['student_profile_image'])) {
                                                                $imageData = PROFILE_PIC_IMAGE_PATH . $value['student_profile_image'];
                                                            } else {
                                                                $imageData = 'assets/img/user.jpg';
                                                            }
                                                        } else {
                                                            if(!empty($value['parents_profile_image'])) {
                                                                $imageData = PROFILE_PIC_IMAGE_PATH . $value['parents_profile_image'];
                                                            } else {
                                                                $imageData = 'assets/img/user.jpg';
                                                            }
                                                        }    
                                                    ?>
                                                    <li>
                                                        <div class="contact-cont">
                                                            <div class="float-left user-img m-r-10">
                                                                <a href="profile.html" title="John Doe"><img src="<?php echo $imageData;  ?>" alt="" class="w-40 rounded-circle"><span class="status online"></span></a>
                                                            </div>
                                                            <div class="contact-info">
                                                                <?php if($search == 'parents') { ?>
                                                                <span class="contact-name text-ellipsis"><?php echo $value['fathers_name'];?></span>
                                                                <?php } ?>
                                                                <span class="contact-name text-ellipsis"><?php echo $value['first_name'].' '. $value['last_name']?></span>
                                                                <?php if($search == '') { ?>
                                                                <span class="contact-date"><?php echo $value['subject_name'] ?></span><br>
                                                                <?php } ?>
                                                                <?php if($search == '' || $search == 'students') { ?>
                                                                <span class="contact-date"><?php echo $value['mobile_number'] ?></span><br>
                                                                <?php } ?>
                                                                <?php if($search == 'parents') { ?>
                                                                <span class="contact-date"><?php echo $value['parents_mobile_number'] ?></span><br>
                                                                <?php } ?>
                                                                <?php if(@$value['user_role'] == '2') { ?>
                                                                <span class="contact-date">Class Teacher</span><br>
                                                                <?php } ?>
                                                                <?php if($search == 'students' || $search == 'parents') { ?>
                                                                <span class="contact-date"><?php echo $value['class_name'].' '.$value['section_name'] ?></span><br>
                                                                <?php } ?>   
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php } } ?>
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
        </div>
	</div>
    <?php require_once 'includes/footer.php'; ?>