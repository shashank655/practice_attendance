<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Teacher.php'; 
require_once 'employee/class/CommonFunction.php'; 
$common_function=new CommonFunction(); 
$resultAllStudents=$common_function->getAllStudents();  
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
                            <h5 class="text-uppercase">All Students</h5>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                            <ul class="list-inline breadcrumb float-right">
                                <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                                <li class="list-inline-item"><a href="add-student.php">Students</a></li>
                                <li class="list-inline-item"> All Students</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-3">
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="add-student.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Student</a>
                        <div class="view-icons">
                            <a href="all-students.php" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                            <a href="students-list.php" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
                        </div>
                    </div>
                </div>
            <div class="content-page">
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group custom-mt-form-group">
                            <input type="text"  />
                            <label class="control-label">Student ID</label><i class="bar"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group custom-mt-form-group">
                            <input type="text"  />
                            <label class="control-label">Student Name</label><i class="bar"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group custom-mt-form-group">
                            <select >
                                <option>Select class</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                             </select>
                             <label class="control-label">Class</label><i class="bar"></i>
                        </div>  
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <a href="#" class="btn btn-success btn-block mt-4 mb-2"> Search </a>
                    </div>
                </div>
                <div class="row staff-grid-row">
                <?php foreach ($resultAllStudents as $key => $value) { 
                    if(!empty($value['student_profile_image'])) {
                        $imageData = PROFILE_PIC_IMAGE_PATH . $value['student_profile_image'];
                    } else {
                        $imageData = 'assets/img/user.jpg';
                    }
                ?>
                    <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                        <div class="profile-widget">
                            <div class="profile-img">
                                <a href="student-profile.php?studentId=<?php echo $value[0]; ?>"><img class="avatar" src="<?php echo $imageData; ?>" alt=""></a>
                            </div>
                            <div class="dropdown profile-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="add-student.php?studentId=<?php echo $value[0]; ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a class="dropdown-item" val="<?php echo $value[0]; ?>" href="#" id="delTeacher"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>
                            <h4 class="user-name m-t-10 m-b-0 text-ellipsis"><a href="profile.html"><?php echo $value['first_name'].' '.$value['last_name']; ?></a></h4>
                            <div class="small text-muted"><?php echo $value['gender']; ?></div>
                            <div class="small text-muted"><?php 
                                echo $value['admission_no'];
                            ?></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                </div>
            </div>
			</div>
        </div>
		  <div id="delete_employee" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Employee</h4>
                    </div>
                    <form>
                        <div class="modal-body card-box">
                            <p>Are you sure want to delete this?</p>
                            <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>