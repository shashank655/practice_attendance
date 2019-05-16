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
    $get_current_month = date('m');
    $get_current_year = date('Y');
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
								<li class="list-inline-item"><a href="index.html">Home</a></li>
								<li class="list-inline-item"><a href="index.html">Management</a></li>
								<li class="list-inline-item"><a href="index.html">Employees</a></li>
								<li class="list-inline-item"> Attendance</li>
							</ul>
						</div>
                        <div class="col-sm-4 col-3">
                      
                        </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="student-attendance.php" class="float-right btn-rounded">Take today's Attendance</a>
                    </div>
					</div>
				</div>
				<div class="content-page">
				 <div class="row">
                    <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
							<input type="text" />
							<label class="control-label">Employee name</label><i class="bar"></i>
						</div>
                    </div>
                    <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
							<select >
								 <option>-</option>
                                <option>Jan</option>
                                <option>Feb</option>
                                <option>Mar</option>
                                <option>Apr</option>
                                <option>May</option>
                                <option>Jun</option>
                                <option>Jul</option>
                                <option>Aug</option>
                                <option>Sep</option>
                                <option>Oct</option>
                                <option>Nov</option>
                                <option>Dec</option>
							 </select>
							 <label class="control-label">Select Month</label><i class="bar"></i>
						</div>	
                    </div>
                    <div class="col-sm-6 col-md-3">
					<div class="form-group custom-mt-form-group">
							<select >
								 <option>-</option>
                                <option>2019</option>
                                <option>2018</option>
                                <option>2018</option>
                                <option>2016</option>
                                <option>2015</option>
							 </select>
							 <label class="control-label">Select Year</label><i class="bar"></i>
						</div>	
                       
                    </div>
                    <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
                        <a href="#" class="btn btn-success btn-block"> Search </a>
						</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table m-b-0">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <?php for ($i=1; $i <= $get_current_month_days; $i++) { ?>
                                        <th><?php echo $i; ?></th>
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
                                    ?>
                                    <?php foreach ($get_current_month_attendance as $key1 => $value1) { 
                                        if($value1['output'] == 'A') {
                                            $class = 'text-danger';
                                        } elseif($value1['output'] == 'P') {
                                            $class = 'text-success';
                                        } else {
                                            $class = '';
                                        }
                                    ?>    
                                        <td><i class="fa fa-check <?php echo $class; ?>"></i></td>
                                    <?php } ?>
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