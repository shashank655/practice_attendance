<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/CommonFunction.php'; 
require_once 'employee/class/Exams.php';
require_once 'employee/class/Holidays.php';
require_once 'employee/class/Student.php';
$common_function=new CommonFunction(); 
$exams=new Exams();
$student=new Student();
$holidays=new Holidays();
$class_id = (isset($_REQUEST['class_id'])) ? $_REQUEST['class_id'] : NULL;
$get_class_id = $class_id;
$section_id = (isset($_REQUEST['section_id'])) ? $_REQUEST['section_id'] : NULL;
$get_section_id = $section_id;
$roll_number = (isset($_REQUEST['roll_number'])) ? $_REQUEST['roll_number'] : NULL;
$student_name = (isset($_REQUEST['student_name'])) ? $_REQUEST['student_name'] : NULL;

$totalStudent=$common_function->getCountStudent();
$resultClasses = $common_function->getAllClassesName(); 
$totalTeacher = $common_function->getCountTeacher();
$resultAllStudents=$student->getAllStudents($get_class_id,$get_section_id,$roll_number,$student_name);
$resultExamList=$exams->getExamsLists();
$resultHolidays=$holidays->getHolidaysList();
require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>
<div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
               <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-primary"><i class="fa fa-users" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                                <h3><?php echo $totalStudent[0][0]; ?></h3>
                                <span>Students</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-info"><i class="fa fa-user" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                                <h3><?php echo $totalTeacher[0][0]; ?></h3>
                                <span>Teachers</span>
                            </div>
                        </div>
                    </div>
                   <!--  <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-warning"><i class="fa fa-user-plus" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                                <h3><?php //echo $totalStudent[0][0]; ?></h3>
                                <span>Parents</span>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-success"><i class="fa fa-money" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                                <h3>1000</h3>
                                <span>Total Absentees</span>
                            </div>
                        </div>
                    </div>
                    <?php if( ($_SESSION['user_role'] != '1')) { ?>
                     <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-success"><i class="fa fa-money" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                                <h3>news</h3>
                                <span>Global News</span>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if( ($_SESSION['user_role'] == '1')) { ?>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-success"><i class="fa fa-user" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                            <span><a href="#" data-toggle="modal" data-target="#assign_teacher_password">Teacher Global Password</a></span>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                </div>
				<div class="row">
					<div class="col-lg-6">
						<div class="content-page">
							<div class="page-title">Total Members</div>
							<div id="school-chart"></div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="content-page">
							<div class="page-title">Monthly Attendance</div>
							<div id="incomeChart" style="height: 350px;"></div>
						</div>
					</div>
				</div>
				
				<div class="row mt-4">
					<div class="col-lg-6 col-md-12 col-12">
						 <div class="card-box m-b-2">
							<div class="page-title mb-2">
								Events
							</div>
							<div class="card-body p-0">
                            <?php if($_SESSION['user_role'] == '1'){ ?>
                                <div id="calendar"></div>
                            <?php } else { ?>
                                <div id="calendar_teachers"></div>
                            <?php } ?>
							 </div>
                        </div>
					</div>
					<div class="col-lg-6">
						<div class="content-page">
							<div class="row">
								<div class="col-md-12">
									<div class="page-title mb-2">
										Exam-list
									</div>
									<div class="table-responsive">
										<table class="table table-striped custom-table">
											<thead>
												<tr>
													<th style="min-width:50px;">S.No.</th>
			                                        <th style="min-width:50px;">Class</th>
			                                        <th style="min-width:50px;">Sections</th>
			                                        <th style="min-width:50px;">Date of exam</th>
			                                        <th style="min-width:50px;">Exam</th>
												</tr>
											</thead>
											<tbody>
												<?php $i=1; ?>
                                				<?php foreach ($resultExamList as $key => $value) { ?>		
												 <tr>
													<td><?php echo $i; ?></td>
                                        			<td><?php echo $value['class_name']; ?></td>
                                        			<td><?php echo $value['section_name'];?></td>
                                        			<td><?php echo $value['date_of_exam']; ?></td>
                                        			<td><?php echo $value['exam_name']; ?></td>
                                        			<?php if($_SESSION['user_role'] == '1' ) { ?>
													<td class="text-right" >
														<a href="add-exams.php?examId=<?php echo $value[0]; ?>" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<a href="employee/process/processExams.php?type=deleteExams&id=<?php echo $value[0]; ?>" class="btn btn-danger btn-sm mb-1">
                                                			<i class="fa fa-trash" aria-hidden="true"></i>
                                           				</a>
													</td>
												<?php } ?>
												</tr>
												<?php $i++; } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="content-page">
							<div class="row">
								<div class="col-md-12">
									<div class="page-title mb-2">
										Holiday list
									</div>
									<div class="table-responsive">
										<table class="table table-striped custom-table">
											<thead>
												<tr>
													<th style="min-width:50px;">S.No.</th>
			                                        <th style="min-width:50px;">Title</th>
			                                        <th style="min-width:50px;">Holiday Date</th>
												</tr>
											</thead>
											<tbody>
												<?php $i=1; ?>
                                				<?php foreach ($resultHolidays as $key => $value) { ?>		
												 <tr>
													<td><?php echo $i; ?></td>
                                        			<td><?php echo $value['holiday_name']; ?></td>
                                        			<td><?php echo $value['holiday_date'];?></td>
												</tr>
												<?php $i++; } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php if($_SESSION['user_role'] == '1' ) { ?>
				<div class="row mt-2">
					<div class="col-lg-12">
						<div class="content-page">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="page-title mb-2">
										All Students
									</div>
									<div class="content-page">
                <form id="searchStudents" action="dashboard.php" method="get" novalidate="novalidate">
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
                        <button class="btn btn-success btn-block" type="submit">Submit</button>
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
						</div>
					 </div>       
				</div>
			<?php } ?>
			</div>
		</div>
	</div>
	<div id="assign_teacher_password" class="modal" role="dialog">
            <div class="modal-dialog">
				
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Assign Teacher Password</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="teacher_password" action="employee/process/processAddTeacher.php" method="post" novalidate="novalidate">
                        	<input type="hidden" name="type" value="assign_teacher_password" />
                            <div class="form-group custom-mt-form-group">
								<input type="password" id="password" name="password" value="" />
								<label class="control-label">Enter Password <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
                            <div class="form-group custom-mt-form-group">
								<input type="password" name="repeat_password" value="" >
								<label class="control-label">Re-Enter Password <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
                            <div class="m-t-20 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
	var totalStudent = <?php echo $totalStudent[0][0]?> ;
	var totalTeacher = <?php echo $totalTeacher[0][0]?> ;
</script>
<?php
require_once 'includes/footer.php';
?>
<script type="text/javascript">
(function($) {
    'use strict';
    function getStudentMonthlyCartData(class_id = '', section_id = '') {
        $.ajax({
            type: 'GET',
            url: 'employee/process/dashboard-chart-ajax.php',
            data: {
                class_id: class_id,
                section_id: section_id,
                action: 'get-student-monthly-cart-data'
            },
            success: function (res) {
                if (window.studentMonthlyCart) {
                    window.studentMonthlyCart.setData(res);
                }
            }
        });
    }
    getStudentMonthlyCartData();
}(jQuery));
</script>
<script type="text/javascript">
	$( "#delete_student" ).click(function() {
        var id = $(this).attr('val');
        var r = confirm("Are You Sure Delete Student ?");
            if (r==true){
                $.ajax({
                    type: "POST",
                    url: "employee/process/processAddStudent.php",
                    data:{studentId:id,type:'delete'},
                    beforeSend : function () {
                    },
                    success:function(data){
                    	alert('Deleted Successfully');
                    }
                });
            }else{   
            }
    });

    $(function(){
        $("#teacher_password").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                password:{
                    required:true,
                    minlength: 4
                },
                repeat_password:{
                    required:true,
                    equalTo:"#password"
                }
            }
        });
    });
    
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
    </script>