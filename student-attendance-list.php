<?php
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php';
require_once 'employee/class/StudentAttendance.php'; 
require_once 'employee/class/Teacher.php';
$student_attendance = new StudentAttendance();
$teacher = new Teacher();
$get_current_month_days = date('t');
if($_SESSION['user_role'] == '2') { 
    $output = $teacher->getTeacherClassName($_SESSION['userId']);
    $get_class_id = $output[0]['classId'];
    $get_section_id = $output[0]['sectionId'];
    $get_teacher_id = $_SESSION['userId'];
        $searchYear = (isset($_REQUEST['year'])) ? $_REQUEST['year'] : NULL;
            if ($searchYear != NULL) {
                $get_current_year = $searchYear;
            } else {
                $get_current_year = date('Y');
            }
        $searchMonth = (isset($_REQUEST['month'])) ? $_REQUEST['month'] : NULL;
            if ($searchMonth != NULL) {
                $get_current_month = $searchMonth;
            } else {
                $get_current_month = date('m');
            }       
    $get_student_details = $student_attendance->getStudentDetails($get_class_id , $get_teacher_id , $get_section_id);
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
							<h5 class="text-uppercase">attendance sheet</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="dashboard.php">Home</a></li>
								<li class="list-inline-item"> Attendance List</li>
							</ul>
						</div>

                    <!-- <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="student-attendance.php" class="float-right btn-rounded">Take today's Attendance</a>
                    </div> -->
					</div>
				</div>
                     <div class="row">
                            <div class="col-sm-4 col-3">
                          
                            </div>
                            <div class="col-sm-8 col-9 text-right m-b-20">
                                <a href="student-attendance.php" class="btn btn-primary float-right btn-rounded"><i class="fa fa-plus"></i>Today's Attendance</a>
                            </div>
                        </div>
				<div class="content-page">
                 <form id="searchAttendance" action="student-attendance-list.php" method="get" novalidate="novalidate">
				 <div class="row">
                    <!-- <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
							<input type="text" />
							<label class="control-label">Employee name</label><i class="bar"></i>
						</div>
                    </div> -->
                    <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
							<select name="month" id="month">
                                <option value="">Select Month</option>
                                <option <?php if($get_current_month == '01'){echo 'selected'; } ?> value="01">Jan</option>
                                <option <?php if($get_current_month == '02'){echo 'selected'; } ?> value="02">Feb</option>
                                <option <?php if($get_current_month == '03'){echo 'selected'; } ?> value="03">Mar</option>
                                <option <?php if($get_current_month == '04'){echo 'selected'; } ?> value="04">Apr</option>
                                <option <?php if($get_current_month == '05'){echo 'selected'; } ?> value="05">May</option>
                                <option <?php if($get_current_month == '06'){echo 'selected'; } ?> value="06">Jun</option>
                                <option <?php if($get_current_month == '07'){echo 'selected'; } ?> value="07">Jul</option>
                                <option <?php if($get_current_month == '08'){echo 'selected'; } ?> value="08">Aug</option>
                                <option <?php if($get_current_month == '09'){echo 'selected'; } ?> value="09">Sep</option>
                                <option <?php if($get_current_month == '10'){echo 'selected'; } ?> value="10">Oct</option>
                                <option <?php if($get_current_month == '11'){echo 'selected'; } ?> value="11">Nov</option>
                                <option <?php if($get_current_month == '12'){echo 'selected'; } ?> value="12">Dec</option>
							 </select>
							 <label class="control-label">Select Month</label><i class="bar"></i>
						</div>	
                    </div>
                    <div class="col-sm-6 col-md-3">
					<div class="form-group custom-mt-form-group">
							<select name="year" id="year">
                                <option value="">Select Year</option>
                                <option <?php if($get_current_year == '2021'){echo 'selected'; } ?> value="2021">2021</option>
                                <option <?php if($get_current_year == '2020'){echo 'selected'; } ?> value="2020">2020</option>
                                <option <?php if($get_current_year == '2019'){echo 'selected'; } ?> value="2019">2019</option>
							 </select>
							 <label class="control-label">Select Year</label><i class="bar"></i>
						</div>	
                       
                    </div>
                    <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
                        <button class="btn btn-success btn-block" type="submit">Submit</button>
						</div>
                    </div>
                </div>
                </form>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table m-b-0">
                                <thead>
                                    <tr>
                                        <th>Students</th>
                                        <?php for ($i=1; $i <= $get_current_month_days; $i++) { ?>
                                        <th>Day <?php echo $i; ?></th>
                                    <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($get_student_details)) { 
                                        foreach ($get_student_details as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><?php echo $value['first_name'].' '.$value['last_name']; ?></td>
                                    <?php  
                                    $student_id = $value['student_id'];
                                        $get_current_month_attendance = $student_attendance->getCurrentMonthAttendance($get_class_id , $get_teacher_id , $get_current_month , $get_current_year , $student_id);
                                        if(!empty($get_current_month_attendance)) {
                                            foreach ($get_current_month_attendance as $key1 => $value1) { 
                                                if($value1['output'] == 'A') {
                                                    $class = 'fa fa-times text-danger';
                                                } elseif($value1['output'] == 'P') {
                                                    $class = 'fa fa-check text-success';
                                                } else {
                                                    $class = 'fa fa-check fa fa-minus';
                                                }
                                            ?>    
                                        <td><i class="<?php echo $class; ?>"></i></td>
                                    <?php } } ?>
                                    </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
				</div>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>