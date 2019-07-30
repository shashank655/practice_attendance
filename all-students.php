<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Student.php'; 
require_once 'employee/class/CommonFunction.php';
$common_function=new CommonFunction();
$student = new Student(); 
$resultClasses = $common_function->getAllClassesName(); 
$class_id = (isset($_REQUEST['class_id'])) ? $_REQUEST['class_id'] : NULL;
$get_class_id = $class_id;
$section_id = (isset($_REQUEST['section_id'])) ? $_REQUEST['section_id'] : NULL;
$get_section_id = $section_id;
$roll_number = (isset($_REQUEST['roll_number'])) ? $_REQUEST['roll_number'] : NULL;
$student_name = (isset($_REQUEST['student_name'])) ? $_REQUEST['student_name'] : NULL;

$resultAllStudents=$student->getAllStudents($get_class_id,$get_section_id,$roll_number,$student_name);

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
                                <li class="list-inline-item"> All Students</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php if($_SESSION['user_role'] == '1') { ?>
                <div class="row">
                    <div class="col-sm-4 col-3">
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="add-student.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Student</a>
                        <a href="#" class="btn btn-primary btn-rounded float-right" data-toggle="modal" data-target="#student_csv_report"><i class="fa fa-plus"></i> Download CSV Report</a>
                        <a href="" class="btn btn-primary btn-rounded float-right"></i>Upload CSV</a>
                        <div class="view-icons">
                            <a href="all-students.php" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            <div class="content-page">
                <form id="searchStudents" action="all-students.php" method="get" novalidate="novalidate">
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group custom-mt-form-group">
                            <select id="class_id" name="class_id" onchange="getSections(this.value);">
                                <option value='' >Select Class</option>
                                    <?php for ($i=0 ; $i < count($resultClasses); $i++) : ?>
                                        <option <?php if (isset($get_class_id)) { if ($get_class_id==$resultClasses[$i]['id']) { echo 'selected'; } } ?> value="<?php echo $resultClasses[$i][ 'id']; ?>"><?php echo $resultClasses[$i][ 'class_name']; ?></option>
                                    <?php endfor; ?>
                             </select>
                             <label class="control-label">Select Class</label><i class="bar"></i>
                        </div>  
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group custom-mt-form-group">
                            <select name="section_id" id="section_id">
                                <option value='' disabled="" selected="">Select Section</option>
                            </select>
                             <label class="control-label">Select Section</label><i class="bar"></i>
                        </div>  
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group custom-mt-form-group">
                            <input type="text" value="<?php if(isset($roll_number)) { echo $roll_number; } ?>"  name="roll_number" />
                            <label class="control-label">Roll Number</label><i class="bar"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group custom-mt-form-group">
                            <input type="text" value="<?php if(isset($student_name)) { echo $student_name; } ?>" name="student_name" />
                            <label class="control-label">Student Name</label><i class="bar"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group custom-mt-form-group">
                        <button class="btn btn-primary btn-block" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
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
                            <?php if($_SESSION['user_role'] == '1') { ?>
                            <div class="dropdown profile-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="add-student.php?studentId=<?php echo $value[0]; ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a class="dropdown-item" val="<?php echo $value[0]; ?>" href="#" id="delTeacher"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>
                            <?php } ?>
                            <h4 class="user-name m-t-10 m-b-0 text-ellipsis"><a href="student-profile.php?studentId=<?php echo $value[0]; ?>"><?php echo $value['first_name'].' '.$value['last_name']; ?></a></h4>
                            <div class="small text-muted"><?php echo ucfirst($value['gender']); ?></div>
                            <div class="small text-muted"><?php 
                                echo $value['class_name'];
                            ?></div>
                            <div class="small text-muted"><?php 
                                echo $value['section_name'];
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

        <div id="student_csv_report" class="modal" role="dialog">
            <div class="modal-dialog">
                
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Download Report</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="csvReport" action="employee/process/processDownloadCSV.php" method="post" novalidate="novalidate">
                            <input type="hidden" name="type" value="download_student_csv" />
                        <div class="form-group custom-mt-form-group">
                            <select id="class_id_csv" name="class_id_csv" onchange="getSectionsCSV(this.value);">
                                <option value='all'>All Classes</option>
                                    <?php for ($i=0 ; $i < count($resultClasses); $i++) : ?>
                                        <option <?php if (isset($get_class_id)) { if ($get_class_id==$resultClasses[$i]['id']) { echo 'selected'; } } ?> value="<?php echo $resultClasses[$i][ 'id']; ?>"><?php echo $resultClasses[$i][ 'class_name']; ?></option>
                                    <?php endfor; ?>
                             </select>
                             <label class="control-label">Select Class</label><i class="bar"></i>
                        </div>
                        <div class="form-group custom-mt-form-group">
                            <select name="section_id_csv" id="section_id_csv">
                                <option value='' disabled="" selected="">Select Section</option>
                            </select>
                             <label class="control-label">Select Section</label><i class="bar"></i>
                        </div>
                            <div class="m-t-20 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Download</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php require_once 'includes/footer.php'; ?>
    <script type="text/javascript">
    
        <?php  if($get_class_id!=''){ ?>
            section_id='<?php echo $get_section_id; ?>';        
            getSections('<?php echo $get_class_id; ?>');
        <?php }?>

        function getSections(classID){
        $.ajax({
            type: "POST",
            url: "employee/process/processAddTeacher.php",
            data:{type:'getSection',classID:classID},
            beforeSend : function () {
                //$('#wait').html("Wait for checking");
            },
            success:function(data){                
                
                data = $.parseJSON(data); 
                console.log(data);        
                if(data.length > 0){
                    $("#section_id").html("<option value=''>Select Section</option>");
                    for(var i=0;i<data.length;i++){        
                       var option="<option value='"+data[i].id+"'";
                            if(data[i].id==section_id){
                               option+=" selected";
                            }
                           option+=" >"+data[i].section_name+"</option>"
                        $("#section_id").append(option);
                    }                    
                }else{
                    $("#section_id").html("<option value='' selected >No Section Found</option>");
                }
            }
        });
    }

    function getSectionsCSV(classID){
        $.ajax({
            type: "POST",
            url: "employee/process/processAddTeacher.php",
            data:{type:'getSection',classID:classID},
            beforeSend : function () {
                //$('#wait').html("Wait for checking");
            },
            success:function(data){                
                
                data = $.parseJSON(data); 
                console.log(data);        
                if(data.length > 0){
                    $("#section_id_csv").html("<option value=''>Select Section</option>");
                    for(var i=0;i<data.length;i++){        
                       var option="<option value='"+data[i].id+"'";
                           option+=" >"+data[i].section_name+"</option>"
                        $("#section_id_csv").append(option);
                    }                    
                }else{
                    $("#section_id_csv").html("<option value='' selected >No Section Found</option>");
                }
            }
        });
    }
    </script>